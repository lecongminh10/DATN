@extends('client.layouts.app')

@section('content')

    @include('client.layouts.nav')

    <div class="widget">
        <h4 class="widget-title">Bài viết tags: {{ $tag->name }}</h4>

        @if ($posts->isEmpty())
            <p>Không có bài viết nào có sẵn cho thẻ này.</p>
        @else
            <div class="posts-list">
                @foreach ($posts as $post)
                    <div class="post">
                        <h5><a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a></h5>
                        <p>{{ $post->excerpt }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div><!-- End .widget -->
    
@endsection
