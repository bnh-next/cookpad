# Sử dụng Python 3.10 làm base image
FROM python:3.10

# Thiết lập biến môi trường
ENV PYTHONUNBUFFERED=1
ENV UV_HTTP_TIMEOUT=60  
ENV UV_COMPILE_BYTECODE=1
ENV UV_LINK_MODE=copy
ENV PYTHONPATH=/app
ENV PATH="/app/.venv/bin:$PATH"

# Thiết lập thư mục làm việc
WORKDIR /app/

# Cài đặt uv từ image đã build trước đó
COPY --from=ghcr.io/astral-sh/uv:0.4.15 /uv /bin/uv

# Cài đặt distlib để tránh lỗi khi cài đặt uv
RUN pip install distlib==0.3.8

# Sao chép các file cấu hình của dự án
COPY ./pyproject.toml ./uv.lock ./alembic.ini /app/

# Cài đặt dependencies từ `uv.lock` sử dụng `uv`
RUN --mount=type=cache,target=/root/.cache/uv \
    uv sync --frozen

# Sao chép mã nguồn của ứng dụng
COPY ./app /app/app
COPY ./scripts /app/scripts

# Sync dự án và cache lại các dependencies
RUN --mount=type=cache,target=/root/.cache/uv \
    uv sync

# Chạy ứng dụng
CMD ["sh", "-c", "which uvicorn && uvicorn app.main:app --host 0.0.0.0 --port 8000 --workers 4"]
