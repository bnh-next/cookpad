import uuid

from pydantic import EmailStr
from sqlmodel import Field, Relationship, SQLModel
from typing import List, Optional
from uuid import UUID


# Shared properties
class UserBase(SQLModel):
    email: EmailStr = Field(unique=True, index=True, max_length=255)
    is_active: bool = True
    is_superuser: bool = False
    full_name: str | None = Field(default=None, max_length=255)


# Properties to receive via API on creation
class UserCreate(UserBase):
    password: str = Field(min_length=8, max_length=40)


class UserRegister(SQLModel):
    email: EmailStr = Field(max_length=255)
    password: str = Field(min_length=8, max_length=40)
    full_name: str | None = Field(default=None, max_length=255)


# Properties to receive via API on update, all are optional
class UserUpdate(UserBase):
    email: EmailStr | None = Field(default=None, max_length=255)  # type: ignore
    password: str | None = Field(default=None, min_length=8, max_length=40)


class UserUpdateMe(SQLModel):
    full_name: str | None = Field(default=None, max_length=255)
    email: EmailStr | None = Field(default=None, max_length=255)


class UpdatePassword(SQLModel):
    current_password: str = Field(min_length=8, max_length=40)
    new_password: str = Field(min_length=8, max_length=40)


# Database model, database table inferred from class name
class User(UserBase, table=True):
    __tablename__ = "user"  # ⚠️ RẤT QUAN TRỌNG – phải khớp với tên bảng SQL

    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    hashed_password: str
    items: list["Item"] = Relationship(back_populates="owner", cascade_delete=True)



# Properties to return via API, id is always required
class UserPublic(UserBase):
    id: uuid.UUID


class UsersPublic(SQLModel):
    data: list[UserPublic]
    count: int


# Shared properties
class ItemBase(SQLModel):
    title: str = Field(min_length=1, max_length=255)
    description: str | None = Field(default=None, max_length=255)


# Properties to receive on item creation
class ItemCreate(ItemBase):
    pass


# Properties to receive on item update
class ItemUpdate(ItemBase):
    title: str | None = Field(default=None, min_length=1, max_length=255)  # type: ignore


# Database model, database table inferred from class name
class Item(ItemBase, table=True):
    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    title: str = Field(max_length=255)
    owner_id: uuid.UUID = Field(
        foreign_key="user.id", nullable=False, ondelete="CASCADE"
    )
    owner: User | None = Relationship(back_populates="items")


# Properties to return via API, id is always required
class ItemPublic(ItemBase):
    id: uuid.UUID
    owner_id: uuid.UUID


class ItemsPublic(SQLModel):
    data: list[ItemPublic]
    count: int


# Generic message
class Message(SQLModel):
    message: str


# JSON payload containing access token
class Token(SQLModel):
    access_token: str
    token_type: str = "bearer"


# Contents of JWT token
class TokenPayload(SQLModel):
    sub: str | None = None


class NewPassword(SQLModel):
    token: str
    new_password: str = Field(min_length=8, max_length=40)

class DishBase(SQLModel):
    name: str = Field(max_length=255)
    servings: int | None = Field(default=None)  # Số lượng người ăn
    image_url: str | None = Field(default=None)  # Link hình ảnh
    instructions: str | None = Field(default=None)  # Cách thực hiện
    serving_instruction: str | None = Field(default=None)  # Phục vụ
    user_id: uuid.UUID | None = Field(default=None)

class DishCreate(DishBase):
    pass


class DishUpdate(DishBase):
    name: str | None = Field(default=None, max_length=255)
    servings: int | None = Field(default=None)
    image_url: str | None = Field(default=None)
    instructions: str | None = Field(default=None)
    serving_instruction: str | None = Field(default=None)


class Dish(DishBase, table=True):
    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    ingredients: list["DishIngredient"] = Relationship(back_populates="dish")


# Ingredient model
class IngredientBase(SQLModel):
    name: str = Field(max_length=255)


class IngredientCreate(IngredientBase):
    pass


class IngredientUpdate(IngredientBase):
    name: str | None = Field(default=None, max_length=255)


class Ingredient(IngredientBase, table=True):
    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    dishes: list["DishIngredient"] = Relationship(back_populates="ingredient")


class DishIngredientBase(SQLModel):
    quantity: str | None = Field(default=None, max_length=255)

class DishIngredientCreate(DishIngredientBase):
    pass

class DishIngredient(DishIngredientBase, table=True):
    dish_id: uuid.UUID = Field(foreign_key="dish.id", primary_key=True)
    ingredient_id: uuid.UUID = Field(foreign_key="ingredient.id", primary_key=True)

    # Relationships
    dish: Dish = Relationship(back_populates="ingredients")
    ingredient: Ingredient = Relationship(back_populates="dishes")

# Tạo response cho Ingredient trong DishResponse
class IngredientResponse(SQLModel):
    name: str
    quantity: Optional[str]

# Tạo DishResponse chứa các trường thông tin cơ bản và danh sách ingredients
class DishResponse(SQLModel):
    id: uuid.UUID
    name: str
    servings: Optional[int] = None
    image_url: Optional[str] = None
    instructions: Optional[str] = None
    serving_instruction: Optional[str] = None
    user_id: Optional[UUID] = None 
    ingredients: List[IngredientResponse] = []  # Danh sách các nguyên liệu và số lượng

class DishCreate(SQLModel):
    name: str
    servings: int
    image_url: Optional[str] = None
    instructions: Optional[str] = None
    serving_instruction: Optional[str] = None
    ingredients: List[IngredientResponse]