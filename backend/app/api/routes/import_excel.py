import io
import pandas as pd
from fastapi import APIRouter, Depends, HTTPException, UploadFile, File
from sqlmodel import select
from app import crud
from app.api.deps import SessionDep, CurrentUser, get_current_active_superuser
from app.models import Dish, Ingredient, DishIngredient
from sqlalchemy.sql import func
router = APIRouter()

@router.post("/import-excel")
async def import_excel(session: SessionDep, file: UploadFile = File(...)):
    """
    Import data from an Excel file.
    Only accessible to superusers.
    """
    if not file.filename.endswith('.xlsx'):
        raise HTTPException(status_code=400, detail="Invalid file type. Please upload an Excel file.")

    contents = await file.read()
    file_data = io.BytesIO(contents)

    try:
        df = pd.read_excel(file_data)

        required_columns = ['Tên món ăn', 'Nguyên liệu', 'Số lượng người ăn', 'Link hình ảnh', 'Cách thực hiện', 'Phục vụ']
        for column in required_columns:
            if column not in df.columns:
                raise HTTPException(status_code=400, detail=f"Cột '{column}' không tồn tại trong file Excel")

        for index, row in df.iterrows():
            dish_name = row['Tên món ăn']
            servings = row['Số lượng người ăn']
            image_url = row['Link hình ảnh']
            instructions = row['Cách thực hiện']
            serving_instruction = row['Phục vụ']

            new_dish = Dish(
                name=dish_name,
                servings=servings,
                image_url=image_url,
                instructions=instructions,
                serving_instruction=serving_instruction,
            )
            session.add(new_dish)
            session.commit()  # Commit để có ID cho món ăn mới
            session.refresh(new_dish)  # Lấy lại ID của món ăn

            ingredient_list = row['Nguyên liệu'].split(', ')
            for ingredient in ingredient_list:
                if ':' not in ingredient:
                    continue  # Bỏ qua nếu không có dấu ':'
                
                name, quantity = ingredient.split(': ', 1)
                
                if not quantity:
                    quantity = "" 

                existing_ingredient = session.exec(select(Ingredient).where(func.lower(Ingredient.name) == name.lower())).first()
                if not existing_ingredient:
                    new_ingredient = Ingredient(name=name)
                    session.add(new_ingredient)
                    session.commit()  # Commit để có ID cho nguyên liệu mới
                    session.refresh(new_ingredient)  # Lấy lại ID của nguyên liệu
                else:
                    new_ingredient = existing_ingredient

                # Kiểm tra xem cặp dish_id và ingredient_id đã tồn tại
                exists_query = select(DishIngredient).where(
                    DishIngredient.dish_id == new_dish.id,
                    DishIngredient.ingredient_id == new_ingredient.id
                )
                exists = session.exec(exists_query).first()

                if not exists:
                    # Liên kết Dish và Ingredient
                    dish_ingredient = DishIngredient(
                        dish_id=new_dish.id,
                        ingredient_id=new_ingredient.id,
                        quantity=quantity
                    )
                    session.add(dish_ingredient)  # Thêm vào DishIngredient
                    print(f"Đã thêm DishIngredient cho món '{dish_name}' và nguyên liệu '{name}' với số lượng '{quantity}'")  # Log thông báo

        session.commit()  # Commit tất cả các thay đổi

    except Exception as e:
        session.rollback()
        raise HTTPException(status_code=500, detail=f"Lỗi khi xử lý file Excel: {str(e)}")

    return {"message": "Dữ liệu đã được nhập thành công"}
