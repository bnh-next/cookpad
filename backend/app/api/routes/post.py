from fastapi import APIRouter, Depends, HTTPException, Query
from typing import List
from sqlmodel import select
from app.models import Dish, DishResponse, User,DishCreate, Ingredient, DishIngredient,IngredientResponse
from app.api.deps import SessionDep,get_current_active_superuser,get_current_user,get_db
from app.crud import get_all_dishes, get_dish_by_id,get_dishes_by_user,get_all_dishes_machine_learning,knn,normalize_string,recommend_dishes_with_kmeans,k_means_clustering
from uuid import UUID
from sqlalchemy.sql import func


router = APIRouter()

@router.get("/dishes", response_model=List[DishResponse])
async def read_dishes(
    session:SessionDep,  
    page: int = Query(0, ge=0),  
    limit: int = Query(10, gt=0),  
):
    """
    Lấy danh sách các món ăn với thông tin cơ bản và nguyên liệu.
    """
    try:
        dishes = get_all_dishes(session=session, skip=page * limit, limit=limit)

        if not dishes:
            raise HTTPException(status_code=404, detail="No dishes found.")
        
        return dishes
    except Exception as e:
        print(f"An error occurred: {e}")
        raise HTTPException(status_code=500, detail="Internal Server Error")

@router.get("/dishes/search", response_model=List[DishResponse])
async def search_dishes_by_ingredient(
    session: SessionDep,
    ingredient_name: str = Query(..., min_length=1, description="Tên nguyên liệu để tìm kiếm món ăn"),
    
):
    """
    Tìm kiếm các món ăn có chứa nguyên liệu dựa trên tên nguyên liệu.
    """
    # Chuẩn hóa tên nguyên liệu
    # Loại bỏ dấu cách ở đầu và cuối chuỗi
    normalized_name = ingredient_name.strip()


    matching_ingredient = session.exec(
        select(Ingredient).where(func.trim(Ingredient.name) == normalized_name)
    ).first()



    if not matching_ingredient:
        raise HTTPException(status_code=404, detail="Không tìm thấy nguyên liệu nào phù hợp.")

    
    ingredient_id = matching_ingredient.id


    # Tìm các món ăn có chứa những nguyên liệu này
    dishes = session.exec(
        select(Dish)
        .join(DishIngredient, Dish.id == DishIngredient.dish_id)
        .where(DishIngredient.ingredient_id == ingredient_id)
    ).all()

    if not dishes:
        raise HTTPException(status_code=404, detail="Không tìm thấy món ăn nào phù hợp.")

    # Tạo phản hồi theo schema DishResponse
    dish_responses = [
        DishResponse(
            id=dish.id,
            name=dish.name,
            servings=dish.servings,
            image_url=dish.image_url,
            instructions=dish.instructions,
            serving_instruction=dish.serving_instruction,
            user_id=dish.user_id,
            ingredients=[
                IngredientResponse(name=ingredient.name, quantity=dish_ingredient.quantity)
                for dish_ingredient in session.exec(
                    select(DishIngredient)
                    .where(DishIngredient.dish_id == dish.id)
                ).all()
                for ingredient in session.exec(
                    select(Ingredient)
                    .where(Ingredient.id == dish_ingredient.ingredient_id)
                ).all()
            ]
        )
        for dish in dishes
    ]

    return dish_responses
@router.get("/dishes/{dish_id}", response_model=DishResponse)
async def read_dish(
    dish_id: str,
    session: SessionDep,
    
):
    """
    Lấy thông tin chi tiết về một món ăn dựa trên dish_id.
    """
 
    dish = get_dish_by_id(session=session, dish_id=dish_id)
    
    if not dish:
        raise HTTPException(status_code=404, detail="Dish not found.")
    
    return dish

@router.post("/dishes/create", response_model=DishResponse)
def create_dish(dish_create: DishCreate, session: SessionDep, current_user: User = Depends(get_current_user)):
    # Tạo đối tượng Dish mới và gán người tạo là current_user
    dish = Dish(
        name=dish_create.name,
        servings=dish_create.servings,
        image_url=dish_create.image_url,
        instructions=dish_create.instructions,
        serving_instruction=dish_create.serving_instruction,
        user_id=current_user.id  # Gán người tạo món ăn
    )

    # Thêm món ăn vào session và commit
    session.add(dish)
    session.commit()
    session.refresh(dish)

    # Tạo danh sách các nguyên liệu đã thêm vào món ăn
    ingredient_responses = []
    for ingredient in dish_create.ingredients:
        # Tìm hoặc tạo mới Ingredient nếu chưa tồn tại
        db_ingredient = session.exec(select(Ingredient).where(Ingredient.name == ingredient.name)).first()
        if not db_ingredient:
            db_ingredient = Ingredient(name=ingredient.name)
            session.add(db_ingredient)
            session.flush()  # Flush để lấy ngay ID của ingredient

        # Tạo quan hệ giữa Dish và Ingredient
        dish_ingredient = DishIngredient(
            dish_id=dish.id,
            ingredient_id=db_ingredient.id,
            quantity=ingredient.quantity
        )
        session.add(dish_ingredient)

        # Thêm vào danh sách phản hồi ingredient
        ingredient_responses.append(IngredientResponse(name=db_ingredient.name, quantity=ingredient.quantity))

    # Commit tất cả thay đổi một lần nữa
    session.commit()

    # Tạo đối tượng phản hồi DishResponse
    dish_response = DishResponse(
        id=dish.id,
        name=dish.name,
        servings=dish.servings,
        image_url=dish.image_url,
        instructions=dish.instructions,
        serving_instruction=dish.serving_instruction,
        user_id=dish.user_id, 
        ingredients=ingredient_responses
    )

    return dish_response

@router.delete("/dishes/delete/{dish_id}", response_model=DishResponse)
def delete_dish(dish_id: str, session: SessionDep):
    # Kiểm tra món ăn có tồn tại không bằng `session.exec()`
    statement = select(Dish).where(Dish.id == dish_id)
    dish = session.exec(statement).first()

    if not dish:
        raise HTTPException(status_code=404, detail="Dish not found")

    # Xóa các quan hệ DishIngredient
    statement = select(DishIngredient).where(DishIngredient.dish_id == dish_id)
    ingredients = session.exec(statement).all()
    for ingredient in ingredients:
        session.delete(ingredient)

    # Xóa món ăn
    session.delete(dish)
    session.commit()

    return DishResponse(id=dish.id, name=dish.name)
@router.put("/dishes/update/{dish_id}", response_model=DishResponse)
def update_dish(dish_id: str, dish_update: DishCreate, session: SessionDep,current_user: User = Depends(get_current_user)):
    # Kiểm tra món ăn có tồn tại không bằng `session.exec()`
    statement = select(Dish).where(Dish.id == dish_id)
    dish = session.exec(statement).first()

    if not dish:
        raise HTTPException(status_code=404, detail="Dish not found")

    # Cập nhật thông tin món ăn
    dish.name = dish_update.name
    dish.servings = dish_update.servings
    dish.image_url = dish_update.image_url
    dish.instructions = dish_update.instructions
    dish.serving_instruction = dish_update.serving_instruction
    dish.user_id = current_user.id
    session.commit()

    # Xóa các nguyên liệu cũ và thêm lại các nguyên liệu mới
    statement = select(DishIngredient).where(DishIngredient.dish_id == dish_id)
    ingredients = session.exec(statement).all()
    for ingredient in ingredients:
        session.delete(ingredient)

    for ingredient in dish_update.ingredients:
        # Tìm hoặc tạo đối tượng Ingredient
        statement = select(Ingredient).where(Ingredient.name == ingredient.name)
        db_ingredient = session.exec(statement).first()
        if not db_ingredient:
            db_ingredient = Ingredient(name=ingredient.name)
            session.add(db_ingredient)
            session.commit()
            session.refresh(db_ingredient)

        # Tạo quan hệ DishIngredient
        dish_ingredient = DishIngredient(
            dish_id=dish.id,
            ingredient_id=db_ingredient.id,
            quantity=ingredient.quantity
        )
        session.add(dish_ingredient)

    session.commit()

    # Tạo phản hồi dạng DishResponse
    dish_response = DishResponse(
        id=dish.id,
        name=dish.name,
        servings=dish.servings,
        image_url=dish.image_url,
        instructions=dish.instructions,
        serving_instruction=dish.serving_instruction,
        user_id=dish.user_id,
        ingredients=[ 
            IngredientResponse(name=ingredient.name, quantity=ingredient.quantity) 
            for ingredient in dish_update.ingredients
        ]
    )

    return dish_response

@router.get("/dishes/user", response_model=List[DishResponse])
async def read_user_dishes(
    session: SessionDep,
    current_user: User = Depends(get_current_user),  
    page: int = Query(0, ge=0),
    limit: int = Query(10, gt=0),  
):
    """
    Lấy danh sách các món ăn của người dùng hiện tại, với thông tin cơ bản và nguyên liệu.
    """
    try:

        dishes = get_dishes_by_user(session=session, user_id=current_user.id, skip=page * limit, limit=limit)

        if not dishes:
            raise HTTPException(status_code=404, detail="No dishes found for this user.")
        
        return dishes
    except Exception as e:
        print(f"An error occurred: {e}")
        raise HTTPException(status_code=500, detail="Internal Server Error")

@router.post("/recommend_dishes_knn")
async def recommend_dishes_knn(
    session: SessionDep,
    user_ingredients: List[str],
    k: int = Query(10, gt=0)
):
    """
    Gợi ý các món ăn tương tự từ cơ sở dữ liệu dựa trên nguyên liệu người dùng nhập vào.
    """
    # Chuyển tất cả nguyên liệu người dùng nhập vào thành chữ thường và loại bỏ khoảng trắng
    user_ingredients = [ingredient.lower().strip() for ingredient in user_ingredients]
    print("Nguyên liệu nhận được:", user_ingredients)
    
    # Lấy tất cả món ăn, vector món ăn và danh sách nguyên liệu từ cơ sở dữ liệu
    all_dishes, dishes_vectors, all_ingredients = get_all_dishes_machine_learning(session)
    
    # Gọi hàm knn để tìm các món ăn gần nhất
    recommended_dishes = knn(user_ingredients, dishes_vectors, all_ingredients, k=k)

    return {"recommended_dishes": recommended_dishes}

@router.get("/suggest_ingredients")
async def suggest_ingredients(
    session: SessionDep, 
    query: str = Query(..., min_length=1)
):
    """
    Gợi ý các nguyên liệu dựa trên từ khóa người dùng nhập vào.
    """
    # Chuẩn hóa từ khóa người dùng
    normalized_query = normalize_string(query)
    
    # Truy vấn tất cả các nguyên liệu từ cơ sở dữ liệu
    all_ingredients = session.exec(select(Ingredient.name)).all()
    if all_ingredients and isinstance(all_ingredients[0], tuple):
        all_ingredients = [ingredient[0] for ingredient in all_ingredients]
    
    # Chuẩn hóa các nguyên liệu trong cơ sở dữ liệu
    normalized_ingredients = [
        (ingredient, normalize_string(ingredient)) for ingredient in all_ingredients
    ]
    
    # Tìm các nguyên liệu khớp với từ khóa đã chuẩn hóa
    suggested_ingredients = [
        original for original, normalized in normalized_ingredients
        if normalized_query in normalized
    ]
    
    # Giới hạn số lượng gợi ý trả về
    return {"suggestions": suggested_ingredients[:20]}

@router.post("/recommend_dishes_kmeans")
async def recommend_dishes_kmeans(
    session: SessionDep,
    user_ingredients: List[str],
    k: int = Query(10, gt=0)
):
    """
    Gợi ý món ăn dựa trên K-means và Cosine Similarity từ nguyên liệu người dùng nhập.
    """
    # Chuyển tất cả nguyên liệu người dùng nhập vào thành chữ thường và loại bỏ khoảng trắng
    user_ingredients = [ingredient.lower().strip() for ingredient in user_ingredients]
    print("Nguyên liệu nhận được:", user_ingredients)
    
    # Lấy tất cả món ăn, vector món ăn và danh sách nguyên liệu từ cơ sở dữ liệu
    all_dishes, dishes_vectors, all_ingredients = get_all_dishes_machine_learning(session)
    
    # Giả sử bạn đã có kết quả phân cụm sẵn (clusters và centroids từ K-means)
    # Nếu chưa, bạn có thể tính toán lại ở đây bằng cách gọi K-means
    num_clusters = 3  # Chỉ định số lượng cụm, có thể thay đổi
    clusters, centroids = k_means_clustering(dishes_vectors, num_clusters)

    # Gọi hàm để gợi ý món ăn với K-means + Cosine Similarity
    recommended_dishes = recommend_dishes_with_kmeans(
        user_ingredients, clusters, centroids, all_ingredients, k=k
    )

    return {"recommended_dishes": recommended_dishes}
