<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @foreach($breadcrumb as $key => $item)
                        <li class="breadcrumb-item">
                            @if ($key === count($breadcrumb) - 1)
                                {{ $item['name'] }}  <!-- Không tạo liên kết cho phần tử cuối cùng -->
                            @else
                                <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
