@extends('layouts.app')

@section('content')
    <div class="main-content-1">

        @if (!empty($dishes))
            <div class="container-item-search" style="margin-top: 50px">
                <h1 class="header">
                    ({{ $countDish }}) món có {{ $query }}
                </h1>
                @foreach ($dishes as $dish)
                    <div class="item">
                        <div class="row">
                            <div class="img" style="padding: 20px">
                                <a href=""><img src="{{ $dish['image_url'] }}" alt="{{ $dish['name'] }}"></a>
                            </div>
                            <div class="desc" style="padding: 20px">
                                <div class="name">
                                    <a style="color: #000; font-size: 18px; font-weight:600" href="{{ route('dish.show', $dish['id']) }}">{{ $dish['name'] }}</a>
                                </div>
                                <p class="description">
                                    @foreach ($dish['ingredients'] as $ingredient)
                                        @php

                                            $normalizedIngredient = strtolower(trim($ingredient['name']));

                                            $normalizedIngredients = array_map(function ($item)
                                            {
                                                return strtolower(trim($item));
                                            }, $ingredients);

                                            $isMatched = in_array($normalizedIngredient, $normalizedIngredients);
                                        @endphp

                                        @if ($isMatched)
                                            <strong>{{ $ingredient['name'] }}</strong>*
                                        @else
                                            {{ $ingredient['name'] }}*
                                        @endif
                                    @endforeach
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
