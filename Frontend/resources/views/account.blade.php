@extends('layouts.app')
@section('content')
<div class="min-vh-100 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Header Card -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-lg" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff6b35, #f5a623);">
                        <i class="fas fa-user-circle text-white" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="text-dark mt-3 mb-1 fw-bold">Thông tin tài khoản</h2>
                    <p class="text-muted mb-0">Quản lý thông tin cá nhân của bạn</p>
                </div>

                <!-- Main Card -->
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        {{-- Thông báo thành công --}}
                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-4 mb-4" style="background: rgba(34, 197, 94, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Hiển thị lỗi --}}
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 mb-4" style="background: rgba(239, 68, 68, 0.1);">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-triangle text-danger me-2 mt-1"></i>
                                    <div>
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('account.update') }}">
                            @csrf
                            @method('PUT')
                            
                            {{-- Họ và tên --}}
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-user me-2" style="color: #ff6b35;"></i>Họ và tên
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control border shadow-sm py-3 px-4" 
                                           style="border-radius: 12px; border-color: #e5e7eb;"
                                           id="name" 
                                           name="name"
                                           value="{{ old('name', Auth::user()->name) }}" 
                                           required
                                           placeholder="Nhập họ và tên của bạn">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-envelope me-2" style="color: #ff6b35;"></i>Email
                                </label>
                                <div class="input-group">
                                    <input type="email" 
                                           class="form-control border shadow-sm py-3 px-4" 
                                           style="border-radius: 12px; background: #f8fafc; border-color: #e5e7eb;"
                                           value="{{ Auth::user()->email }}" 
                                           disabled>
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 pe-none" style="z-index: 10;">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                </div>
                                <small class="text-muted mt-1">Email không thể thay đổi</small>
                            </div>

                            {{-- Toggle Password Section --}}
                            <div class="mb-4">
                                <button type="button" 
                                        class="btn w-100 py-3 fw-semibold border-0 shadow-sm text-white" 
                                        style="background: linear-gradient(135deg, #ff6b35, #f5a623); border-radius: 12px;"
                                        id="togglePasswordForm">
                                    <i class="fas fa-key me-2"></i>
                                    <span id="toggleText">Đổi mật khẩu</span>
                                    <i class="fas fa-chevron-down ms-2" id="toggleIcon"></i>
                                </button>
                            </div>

                            {{-- Password Form --}}
                            <div id="passwordForm" style="display: none;" class="password-section">
                                <div class="bg-light rounded-4 p-4 mb-4">
                                    <h6 class="text-dark mb-3 fw-bold">
                                        <i class="fas fa-shield-alt me-2" style="color: #ff6b35;"></i>Thay đổi mật khẩu
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-medium text-dark">
                                            Mật khẩu hiện tại
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control border shadow-sm py-3 px-4 pe-5" 
                                                   style="border-radius: 10px; border-color: #e5e7eb;"
                                                   id="current_password" 
                                                   name="current_password"
                                                   placeholder="••••••••">
                                            <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fas fa-eye-slash text-muted cursor-pointer" onclick="togglePassword('current_password')"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-medium text-dark">
                                            Mật khẩu mới
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control border shadow-sm py-3 px-4 pe-5" 
                                                   style="border-radius: 10px; border-color: #e5e7eb;"
                                                   id="password" 
                                                   name="password"
                                                   placeholder="••••••••">
                                            <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fas fa-eye-slash text-muted cursor-pointer" onclick="togglePassword('password')"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="password_confirmation" class="form-label fw-medium text-dark">
                                            Xác nhận mật khẩu mới
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control border shadow-sm py-3 px-4 pe-5" 
                                                   style="border-radius: 10px; border-color: #e5e7eb;"
                                                   id="password_confirmation" 
                                                   name="password_confirmation"
                                                   placeholder="••••••••">
                                            <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                                                <i class="fas fa-eye-slash text-muted cursor-pointer" onclick="togglePassword('password_confirmation')"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Save Button --}}
                            <button type="submit" 
                                    class="btn btn-dark w-100 py-3 fw-bold border-0 shadow" 
                                    style="border-radius: 12px; background: #1f2937;">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        <i class="fas fa-shield-alt me-1"></i>
                        Thông tin của bạn được bảo mật an toàn
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}

.password-section {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
    border-color: #ff6b35 !important;
}

.card {
    background: white !important;
}
</style>

<script>
document.getElementById('togglePasswordForm').addEventListener('click', function () {
    const form = document.getElementById('passwordForm');
    const icon = document.getElementById('toggleIcon');
    const text = document.getElementById('toggleText');
    
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        text.textContent = 'Ẩn đổi mật khẩu';
    } else {
        form.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        text.textContent = 'Đổi mật khẩu';
    }
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
</script>
@endsection