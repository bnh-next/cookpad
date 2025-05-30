from sqlalchemy import create_engine, text, inspect

# Kết nối DB
DB_URL = "postgresql+psycopg2://doannganh:123456@localhost:5432/cookpad"
engine = create_engine(DB_URL)

try:
    with engine.connect() as conn:
        print("✅ Kết nối thành công!")

        # Dùng SQLAlchemy Inspector để lấy danh sách bảng
        inspector = inspect(engine)
        tables = inspector.get_table_names()
        print("📋 Danh sách các bảng trong DB:")
        for table in tables:
            print(" -", table)

except Exception as e:
    print("❌ Kết nối thất bại:", e)
