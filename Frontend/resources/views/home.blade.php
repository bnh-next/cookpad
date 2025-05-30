@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
    <div class="header-style-1">
        <div class="slider-container">
            <div class="slider">
                <div class="slide">
                    <img src="{{ asset('assets/image/banner/banner (1).webp') }}" alt="Image 1">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/image/banner/banner (2).webp') }}" alt="Image 1">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/image/banner/banner (3).webp') }}" alt="Image 1">
                </div>
                <div class="slide">
                    <img src="{{ asset('assets/image/banner/banner.webp') }}" alt="Image 1">
                </div>
            </div>
            <button class="prev arrow" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next arrow" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </div>
    <div class="main-content-1">
        <h1 class="header">
            Nguyên liệu phổ biến
        </h1>
        <div class="container-item">
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/b075ec48da5abba6/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Tôm</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/71a332bb22a8f8fe/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Mực</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/827f3e65d4158e54/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Ốc</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/f3002269e017e2cd/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Ớt chuông</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/f3002269e017e2cd/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">đu đủ xanh</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/b76aaa8e0f821d73/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">vịt</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/e2e26d825859a00b/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Thịt bò</p>
                </div>
            </div>
            <div class="item">
                <div class="img">
                    <a href=""><img
                            src="https://img-global.cpcdn.com/recipes/52c467e7836488d4/320x240cq50/photo.webp"
                            alt=""></a>
                </div>
                <div class="desc">
                    <p class="description">Cá hồi</p>
                </div>
            </div>
        </div>

        <div class="suggestion_home">

            <h1 class="header">
                Món ngon mỗi này
            </h1>
            <div class="container-item">

                @foreach ($items as $item)
                    <div class="item">
                        <div class="img">
                            <a href=""><img src="{{ $item['image_url'] }}"
                                    alt=""></a>
                        </div>
                        <div class="desc">
                            <p class="description"><a href="{{ route('dish.show', $item['id']) }}">{{ $item['name'] }}</a></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="pagination-container mt-4">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Trang trước -->
                <li class="page-item {{ $items->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $items->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Trang số -->
                @foreach ($items->links()->elements[0] as $page => $url)
                    <li class="page-item {{ $items->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                <!-- Trang sau -->
                <li class="page-item {{ $items->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $items->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>



@endsection
