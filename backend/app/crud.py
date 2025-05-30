import uuid
import math
import random
from typing import Any, List, Optional
import unicodedata
import re
from sqlmodel import Session, select
from typing import List, Tuple
from app.core.security import get_password_hash, verify_password
from app.models import Item, ItemCreate, User, UserCreate, UserUpdate,Dish, Ingredient, DishIngredient


def create_user(*, session: Session, user_create: UserCreate) -> User:
    db_obj = User.model_validate(
        user_create, update={"hashed_password": get_password_hash(user_create.password)}
    )
    session.add(db_obj)
    session.commit()
    session.refresh(db_obj)
    return db_obj


def update_user(*, session: Session, db_user: User, user_in: UserUpdate) -> Any:
    user_data = user_in.model_dump(exclude_unset=True)
    extra_data = {}
    if "password" in user_data:
        password = user_data["password"]
        hashed_password = get_password_hash(password)
        extra_data["hashed_password"] = hashed_password
    db_user.sqlmodel_update(user_data, update=extra_data)
    session.add(db_user)
    session.commit()
    session.refresh(db_user)
    return db_user


def get_user_by_email(*, session: Session, email: str) -> User | None:
    statement = select(User).where(User.email == email)
    session_user = session.exec(statement).first()
    return session_user


def authenticate(*, session: Session, email: str, password: str) -> User | None:
    db_user = get_user_by_email(session=session, email=email)
    if not db_user:
        return None
    if not verify_password(password, db_user.hashed_password):
        return None
    return db_user


def create_item(*, session: Session, item_in: ItemCreate, owner_id: uuid.UUID) -> Item:
    db_item = Item.model_validate(item_in, update={"owner_id": owner_id})
    session.add(db_item)
    session.commit()
    session.refresh(db_item)
    return db_item

def get_dish_by_id( session: Session, dish_id: str):
    """
    Lấy thông tin chi tiết về một món ăn dựa trên dish_id
    """
    # Truy vấn lấy món ăn và nguyên liệu liên quan trong một lần truy vấn
    dish_query = session.exec(
        select(Dish, Ingredient.name, DishIngredient.quantity)
        .join(DishIngredient, DishIngredient.dish_id == Dish.id)
        .join(Ingredient, DishIngredient.ingredient_id == Ingredient.id)
        .where(Dish.id == dish_id)
    ).all()

    if not dish_query:
        return None

    # Lấy thông tin cơ bản của món ăn từ kết quả truy vấn đầu tiên
    dish_data = {
        "id": dish_query[0][0].id,
        "name": dish_query[0][0].name,
        "servings": dish_query[0][0].servings,
        "image_url": dish_query[0][0].image_url,
        "instructions": dish_query[0][0].instructions,
        "serving_instruction": dish_query[0][0].serving_instruction,
        "user_id":dish_query[0][0].user_id,
        "ingredients": [{"name": i[1], "quantity": i[2]} for i in dish_query]
    }
    
    return dish_data


def get_all_dishes(session: Session, skip: int = 0, limit: int = 10):
    """
    Lấy danh sách các món ăn cùng với thông tin cơ bản và nguyên liệu.
    """
    # Truy vấn tất cả các món ăn
    dishes = session.exec(
        select(Dish)
        .offset(skip)
        .limit(limit)
    ).all()

    # Xây dựng danh sách kết quả theo định dạng mong muốn
    all_dishes = []
    for dish in dishes:
        # Tạo thông tin cơ bản cho món ăn
        dish_data = {
            "id": dish.id,
            "name": dish.name,
            "servings": dish.servings,
            "image_url": dish.image_url,
            "instructions": dish.instructions,
            "serving_instruction": dish.serving_instruction,
            "user_id":dish.user_id,
            "ingredients": []
        }

        # Truy vấn tất cả các nguyên liệu liên quan của món ăn
        ingredients = session.exec(
            select(Ingredient.name, DishIngredient.quantity)
            .join(DishIngredient, DishIngredient.ingredient_id == Ingredient.id)
            .where(DishIngredient.dish_id == dish.id)
        ).all()

        # Thêm nguyên liệu vào danh sách nguyên liệu
        for ingredient_name, quantity in ingredients:
            dish_data["ingredients"].append({
                "name": ingredient_name,
                "quantity": quantity
            })

        # Thêm thông tin món ăn vào danh sách kết quả
        all_dishes.append(dish_data)

    return all_dishes

def get_dishes_by_user(session: Session, user_id: str, skip: int = 0, limit: int = 10):
    """
    Lấy danh sách các món ăn của một user cụ thể cùng với thông tin nguyên liệu.
    """
    # Truy vấn tất cả các món ăn của user
    dishes = session.exec(
        select(Dish)
        .where(Dish.user_id == user_id)  # Lọc theo user_id
        .offset(skip)
        .limit(limit)
    ).all()

    # Xây dựng danh sách kết quả theo định dạng mong muốn
    all_dishes = []
    for dish in dishes:
        # Tạo thông tin cơ bản cho món ăn
        dish_data = {
            "id": dish.id,
            "name": dish.name,
            "servings": dish.servings,
            "image_url": dish.image_url,
            "instructions": dish.instructions,
            "serving_instruction": dish.serving_instruction,
            "user_id": dish.user_id,
            "ingredients": []
        }

        # Truy vấn tất cả các nguyên liệu liên quan của món ăn
        ingredients = session.exec(
            select(Ingredient.name, DishIngredient.quantity)
            .join(DishIngredient, DishIngredient.ingredient_id == Ingredient.id)
            .where(DishIngredient.dish_id == dish.id)
        ).all()

        # Thêm nguyên liệu vào danh sách nguyên liệu
        for ingredient_name, quantity in ingredients:
            dish_data["ingredients"].append({
                "name": ingredient_name,
                "quantity": quantity
            })

        # Thêm thông tin món ăn vào danh sách kết quả
        all_dishes.append(dish_data)

    return all_dishes



def get_all_dishes_machine_learning(session: Session):
    """
    Lấy danh sách các món ăn cùng với thông tin cơ bản và nguyên liệu.
    """
    # Truy vấn tất cả các món ăn
    dishes = session.exec(
        select(Dish)
    ).all()

    # Danh sách tất cả các nguyên liệu trong hệ thống (mặc định là các nguyên liệu đã biết)
    all_ingredients = session.exec(select(Ingredient.name)).all()
    if all_ingredients and isinstance(all_ingredients[0], tuple):
        all_ingredients = [ingredient[0] for ingredient in all_ingredients]

    # Chuyển tất cả nguyên liệu thành chữ thường và loại bỏ khoảng trắng
    all_ingredients = [ingredient.lower().strip() for ingredient in all_ingredients]

    # Xây dựng danh sách kết quả theo định dạng mong muốn và tạo vector nhị phân cho mỗi món ăn
    all_dishes = []
    dishes_vectors = []  
    for dish in dishes:
        # Tạo thông tin cơ bản cho món ăn
        dish_data = {
            "id": dish.id,
            "name": dish.name,
            "servings": dish.servings,
            "image_url": dish.image_url,
            "instructions": dish.instructions,
            "serving_instruction": dish.serving_instruction,
            "user_id": dish.user_id,
            "ingredients": []
        }

        ingredients = session.exec(
            select(Ingredient.name)
            .join(DishIngredient, DishIngredient.ingredient_id == Ingredient.id)
            .where(DishIngredient.dish_id == dish.id)
        ).all()
        
        ingredients = [ingredient.lower().strip() for ingredient in ingredients]

        # Thêm nguyên liệu vào dish_data và tạo vector
        ingredient_vector = [0] * len(all_ingredients)  # Khởi tạo vector nhị phân với tất cả giá trị là 0
        for ingredient_name in ingredients:
            dish_data["ingredients"].append({"name": ingredient_name})
            if ingredient_name in all_ingredients:
                ingredient_index = all_ingredients.index(ingredient_name)
                ingredient_vector[ingredient_index] = 1  # Đánh dấu nguyên liệu có mặt trong món ăn

        # Thêm vector của món ăn vào danh sách, lưu cả thông tin món ăn và vector
        dishes_vectors.append((dish_data, ingredient_vector))

        # Thêm thông tin món ăn vào danh sách kết quả
        all_dishes.append(dish_data)

    return all_dishes, dishes_vectors, all_ingredients

def cosine_similarity(vec1, vec2):
    """
    Tính độ tương đồng Cosine giữa hai vector.
    """
    # Tính tích vô hướng giữa hai vector
    dot_product = sum(a * b for a, b in zip(vec1, vec2))
    
    # Tính độ dài (magnitude) của từng vector
    magnitude_vec1 = math.sqrt(sum(a ** 2 for a in vec1))
    magnitude_vec2 = math.sqrt(sum(b ** 2 for b in vec2))
    
    # Tránh chia cho 0 nếu một trong hai vector là vector không có giá trị
    if magnitude_vec1 == 0 or magnitude_vec2 == 0:
        return 0
    
    # Tính cosine similarity
    return dot_product / (magnitude_vec1 * magnitude_vec2)
def knn(user_ingredients, dishes_vectors, all_ingredients, k=3):
    """
    Tìm k món ăn gần nhất với nguyên liệu người dùng nhập vào.
    """
    # Chuyển nguyên liệu người dùng nhập vào thành vector nhị phân
    user_vector = [1 if ingredient in user_ingredients else 0 for ingredient in all_ingredients]

    # Tính độ tương đồng Cosine giữa món ăn người dùng nhập và các món ăn trong cơ sở dữ liệu
    distances = []
    for dish_data, dish_vector in dishes_vectors:
        dist = cosine_similarity(user_vector, dish_vector)
        distances.append((dist, dish_data))

    # Sắp xếp theo độ tương đồng (giảm dần) và lấy K món ăn gần nhất
    distances.sort(reverse=True, key=lambda x: x[0])
    
    # Trả về danh sách thông tin của K món ăn gần nhất
    return [dish_data for _, dish_data in distances[:k]]

def normalize_string(input_str):
    """
    Chuẩn hóa chuỗi: loại bỏ dấu, chuyển thành chữ thường, và loại bỏ khoảng trắng thừa.
    """
    # Loại bỏ dấu tiếng Việt
    normalized_str = unicodedata.normalize('NFD', input_str)
    normalized_str = normalized_str.encode('ascii', 'ignore').decode('utf-8')
    
    # Chuyển thành chữ thường và loại bỏ khoảng trắng thừa
    normalized_str = normalized_str.lower().strip()
    
    # Loại bỏ các ký tự đặc biệt
    normalized_str = re.sub(r'\s+', ' ', normalized_str)
    return normalized_str


def euclidean_distance(vector1: List[int], vector2: List[int]) -> float:
    return math.sqrt(sum((x - y) ** 2 for x, y in zip(vector1, vector2)))

# Hàm chính triển khai K-means
def k_means_clustering(dishes_vectors, n_clusters=10, max_iterations=100):
    """
    Phân nhóm món ăn dựa trên nguyên liệu bằng thuật toán K-means.
    :param dishes_vectors: Danh sách các vector nhị phân của món ăn.
    :param n_clusters: Số cụm (cluster) cần phân loại.
    :param max_iterations: Số vòng lặp tối đa.
    :return: Các cụm (clusters) và tâm cụm (centroids).
    """
    # Khởi tạo ngẫu nhiên các tâm cụm (centroids)
    centroids = random.sample([vector for _, vector in dishes_vectors], n_clusters)

    for iteration in range(max_iterations):
        # Gán mỗi món ăn vào cụm gần nhất
        clusters = {i: [] for i in range(n_clusters)}
        for dish_data, vector in dishes_vectors:
            distances = [euclidean_distance(vector, centroid) for centroid in centroids]
            cluster_index = distances.index(min(distances))
            clusters[cluster_index].append((dish_data, vector))


        # Cập nhật lại tâm cụm
        new_centroids = []
        for cluster_index in clusters:
            cluster_vectors = [vector for _, vector in clusters[cluster_index]]
            if cluster_vectors:  # Tránh chia cho 0
                new_centroid = [sum(values) / len(cluster_vectors) for values in zip(*cluster_vectors)]
                new_centroids.append(new_centroid)
            else:
                new_centroids.append(centroids[cluster_index])  # Giữ nguyên nếu cụm rỗng

        # Dừng nếu tâm cụm không thay đổi
        if new_centroids == centroids:
            break
        centroids = new_centroids

    return clusters, centroids

def recommend_dishes_with_kmeans(user_ingredients, clusters, centroids, all_ingredients, k=3):
    """
    Gợi ý món ăn dựa trên cụm gần nhất và Cosine Similarity.
    """
    # Chuyển nguyên liệu người dùng nhập thành vector nhị phân
    user_vector = [1 if ingredient in user_ingredients else 0 for ingredient in all_ingredients]

    # Tìm cụm gần nhất bằng Euclidean Distance
    distances_to_centroids = [euclidean_distance(user_vector, centroid) for centroid in centroids]
    closest_cluster_index = distances_to_centroids.index(min(distances_to_centroids))  # Cụm gần nhất

    # Lấy tất cả món ăn trong cụm gần nhất
    closest_cluster = clusters[closest_cluster_index]

    # Tính Cosine Similarity giữa user_vector và các món ăn trong cụm
    similarities = []
    for dish_data, dish_vector in closest_cluster:
        similarity = cosine_similarity(user_vector, dish_vector)
        similarities.append((similarity, dish_data))

    # Sắp xếp theo độ tương đồng (giảm dần) và lấy K món ăn phù hợp nhất
    similarities.sort(reverse=True, key=lambda x: x[0])

    # Trả về danh sách thông tin của K món ăn gần nhất
    return [dish_data for _, dish_data in similarities[:k]]


