    @if (!empty($ingredients['suggestions']))
        <ul>
            @foreach ($ingredients['suggestions'] as $suggestion)
                <li>{{ $suggestion }}</li>
            @endforeach
        </ul>
    @else
        <p>Không có gợi ý nào cho từ khóa này.</p>
    @endif
