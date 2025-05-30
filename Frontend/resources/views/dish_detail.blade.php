@extends('layouts.app')

@section('content')

<style>
    /* Global Styles */
    * {
        box-sizing: border-box;
    }
    
    body {
        background: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }

    /* Container */
    .row-food {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Left Column Styles */
    .info-left {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .food-img {
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .food-img:hover {
        transform: translateY(-2px);
    }

    .food-img img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .food-img:hover img {
        transform: scale(1.02);
    }

    .food-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Table Styles */
    .info-ingredient {
        margin: 30px 0;
        background: #f8fafc;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e5e7eb;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .custom-table th {
        background: #1f2937;
        color: white;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 1rem;
    }

    .custom-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: white;
        transition: background-color 0.2s ease;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    /* Cooking Steps */
    .cooking-steps {
        margin: 30px 0;
        background: #f8fafc;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e5e7eb;
    }

    .cooking-steps h2, .cooking-steps h3 {
        color: #1f2937;
        margin-bottom: 20px;
        font-size: 1.5rem;
        font-weight: 600;
        position: relative;
        padding-left: 12px;
        border-left: 3px solid #6366f1;
    }

    .cooking-steps ol {
        list-style: none;
        counter-reset: step-counter;
        padding-left: 0;
    }

    .cooking-steps li {
        counter-increment: step-counter;
        margin-bottom: 15px;
        padding: 18px 18px 18px 55px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        position: relative;
        border-left: 3px solid #6366f1;
        transition: all 0.2s ease;
    }

    .cooking-steps li:hover {
        transform: translateX(3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .cooking-steps li::before {
        content: counter(step-counter);
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: #6366f1;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Rating Section */
    .rating-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 25px;
        margin: 25px 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    /* Improved Star Rating */
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        align-items: center;
        font-size: 2.5rem;
        gap: 5px;
        margin: 20px 0;
        padding: 15px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        color: #d1d5db;
        cursor: pointer;
        transition: all 0.2s ease;
        transform-origin: center;
    }

    .rating-stars label:hover {
        transform: scale(1.1);
        color: #fbbf24;
    }

    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #fbbf24;
        animation: starGlow 0.3s ease-in-out;
    }

    @keyframes starGlow {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1.1); }
    }

    /* User Ratings Display */
    .border-bottom {
        background: white;
        border-radius: 8px;
        padding: 18px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border-left: 3px solid #6366f1;
        transition: all 0.2s ease;
    }

    .border-bottom:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .border-bottom strong {
        color: #1f2937;
        font-size: 1.1rem;
        margin-bottom: 8px;
        display: block;
    }

    /* Form Styles */
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s ease;
        background: white;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #6366f1;
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-primary:hover {
        background: #5856eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
    }

    /* Right Column Styles */
    .info-right {
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .action-container {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .action-header {
        text-align: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .action-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1f2937;
    }

    .action-button {
        display: block;
        width: 100%;
        padding: 14px 20px;
        margin-bottom: 12px;
        background: #6366f1;
        color: white;
        text-align: center;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    }

    .action-button:hover {
        background: #5856eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        text-decoration: none;
        color: white;
    }

    .primary-button {
        background: #1f2937;
        box-shadow: 0 2px 8px rgba(31, 41, 55, 0.2);
    }

    .primary-button:hover {
        background: #111827;
        box-shadow: 0 4px 12px rgba(31, 41, 55, 0.3);
    }

    .disabled {
        background: #9ca3af;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .disabled:hover {
        transform: none;
        background: #9ca3af;
        box-shadow: 0 2px 8px rgba(156, 163, 175, 0.2);
    }

    .more-info {
        text-align: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
    }

    .more-info a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .more-info a:hover {
        color: #5856eb;
        text-decoration: underline;
    }

    /* Utility Classes */
    .mt-2 { margin-top: 15px; }
    .mt-3 { margin-top: 20px; }
    .mt-4 { margin-top: 25px; }
    .mb-2 { margin-bottom: 15px; }
    .mb-3 { margin-bottom: 20px; }
    .pb-2 { padding-bottom: 15px; }

    /* Responsive Design */
    @media (max-width: 992px) {
        .row-food {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .info-right {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .row-food {
            padding: 15px;
        }
        
        .info-left, .action-container {
            padding: 20px;
        }
        
        .food-title {
            font-size: 1.8rem;
        }
        
        .rating-stars {
            font-size: 2rem;
        }
        
        .custom-table th, .custom-table td {
            padding: 10px 15px;
        }
    }

    /* Animation for page load */
    .info-left, .info-right {
        animation: fadeInUp 0.5s ease-out;
    }

    .info-right {
        animation-delay: 0.1s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="row-food">
    <div class="info-left">
        <div class="food-img">
            <img src="{{ $dish['image_url'] }}" alt="{{ $dish['name'] }}" style="width: 100%; height: 500px;">
        </div>
        <p class="food-title">{{ $dish['name'] }}</p>

        <!-- info-ingredient -->
        <div class="info-ingredient">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>🥬 Nguyên liệu</th>
                        <th>⚖️ Khối lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dish['ingredients'] as $ingredient)
                        <tr>
                            <td>{{ $ingredient['name'] }}</td>
                            <td>{{ $ingredient['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Hướng dẫn cách làm -->
        <div class="cooking-steps">
            <h2 class="food-title">👨‍🍳 Hướng dẫn cách làm</h2>
            <ol>
                <li>{{ $dish['instructions'] }}</li>
            </ol>
        </div>

        <!-- Cách trình bày -->
        @if (is_array($dish['serving_instruction']))
            <div class="serving-instructions cooking-steps">
                <h2 class="food-title">🍽️ Cách trình bày</h2>
                <ol>
                    <li>{{ $dish['serving_instruction'] }}</li>
                </ol>
            </div>
        @endif

        <!-- Hiển thị điểm trung bình -->
        <div class="cooking-steps rating-section mt-4">
            <h3>⭐ Tổng điểm trung bình</h3>
            @php
                $avg = $ratings->avg('rating');
            @endphp
            <div style="text-align: center; font-size: 2rem; font-weight: bold; color: #1f2937; margin: 15px 0;">
                {{ number_format($avg, 1) }}/5 ⭐
            </div>
            <p style="text-align: center; font-size: 1.1rem; color: #6b7280;">từ {{ $ratings->count() }} đánh giá</p>
        </div>

        <!-- Hiển thị đánh giá -->
        <div class="cooking-steps mt-2">
            <h3>💬 Đánh giá từ người dùng</h3>
            @forelse ($ratings as $rate)
                <div class="border-bottom pb-2 mb-3">
                    <strong>{{ \App\Models\User::find($rate->user_id)->name ?? 'Ẩn danh' }}</strong> 
                    <span style="color: #fbbf24; font-size: 1.2rem;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $rate->rating ? '⭐' : '☆' }}
                        @endfor
                    </span>
                    <span style="color: #6b7280;">({{ $rate->rating }}/5)</span>
                    <div style="margin-top: 8px; color: #4b5563; line-height: 1.6;">
                        {{ $rate->comment }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 30px; color: #6b7280; font-style: italic;">
                    Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá món này! 🌟
                </div>
            @endforelse
        </div>

        <!-- Form gửi đánh giá -->
        @auth
        <div class="cooking-steps mt-4">
            <h3>✍️ Gửi đánh giá của bạn</h3>
            <form action="{{ route('dishes.rating', $dish['id']) }}" method="POST">
                @csrf

                <label style="font-weight: 600; color: #1f2937; margin-bottom: 10px; display: block;">Chọn sao:</label>
                <div class="rating-stars mb-2">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                        <label for="star{{ $i }}">&#9733;</label>
                    @endfor
                </div>

                <div class="mt-3">
                    <label style="font-weight: 600; color: #1f2937; margin-bottom: 10px; display: block;">Bình luận:</label>
                    <textarea name="comment" class="form-control mb-2" rows="4" placeholder="Viết cảm nhận của bạn về món ăn này..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">🚀 Gửi đánh giá</button>
            </form>
        </div>
        @endauth
    </div>

    <!-- right -->
    <div class="info-right">
        <div class="action-container">
            <div class="action-header">
                <span class="action-title">💾 Lưu Món</span>
            </div>

            <!-- Form lưu món -->
            @auth
            <form action="{{ route('dishes.favorite', $dish['id']) }}" method="POST">
                @csrf
                <button type="submit" class="action-button">⭐ Thêm vào bộ sưu tập</button>
            </form>
            @else
            <div class="action-button disabled">🔒 Vui lòng đăng nhập để lưu món</div>
            @endauth

            <div class="action-button">📤 Chia sẻ</div>
            <div class="action-button">🖨️ In</div>
            <div class="action-button primary-button">📸 Gửi Cooksnap</div>

            <div class="more-info">
                <a href="#">Tìm hiểu thêm về Cooksnap</a>
                <div style="margin-top: 5px; color: #9ca3af;">...</div>
            </div>
        </div>
    </div>
</div>

<script>
// Cải thiện hiệu ứng chọn sao
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-stars input[type="radio"]');
    const starLabels = document.querySelectorAll('.rating-stars label');
    
    ratingStars.forEach(function(star, index) {
        star.addEventListener('change', function() {
            // Thêm hiệu ứng rung nhẹ
            const container = document.querySelector('.rating-stars');
            container.style.animation = 'none';
            setTimeout(() => {
                container.style.animation = 'starSelection 0.3s ease-in-out';
            }, 10);
        });
    });
    
    // CSS animation cho việc chọn sao
    const style = document.createElement('style');
    style.textContent = `
        @keyframes starSelection {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
});
</script>

@endsection
