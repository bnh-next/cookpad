from fastapi import APIRouter

from app.api.routes import items, login, users, utils,import_excel,post

api_router = APIRouter()
api_router.include_router(login.router, tags=["login"])
api_router.include_router(users.router, prefix="/users", tags=["users"])
api_router.include_router(utils.router, prefix="/utils", tags=["utils"])
api_router.include_router(items.router, prefix="/items", tags=["items"])
api_router.include_router(import_excel.router, prefix="/excel", tags=["excel"])
api_router.include_router(post.router, prefix="/post", tags=["post"])
