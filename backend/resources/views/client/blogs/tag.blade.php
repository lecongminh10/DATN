@extends('client.layouts.app')

@section('content')
    @include('client.layouts.nav')

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.blogs.index') }}">Blog</a></li>
                    <li class="breadcrumb-item"> <a href="{{ route('client.blogs.tag', $tag->id) }}">{{ $tag->name }}</a></li>
                </ol>
            </div>
        </nav>

        <div class="container">
            <div class="row">

                <div class="col-lg-9 order-lg-1">
                    <div class="blog-section row">
                        @foreach ($posts as $post)
                            <div class="col-md-5 col-lg-4">
                                <article class="post">
                                    <div class="post-media">
                                        <a href="{{ route('client.blogs.show', $post->id) }}">
                                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Post"
                                                width="225" height="280">
                                        </a>
                                        <div class="post-date">
                                            <span class="day">{{ \Carbon\Carbon::parse($post->published_at)->format('d') }}</span>
                                            <span class="month">{{ \Carbon\Carbon::parse($post->published_at)->format('M') }}</span>
                                        </div>
                                    </div>

                                    <div class="post-body">
                                        <h2 class="post-title">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a>
                                        </h2>
                                        <div class="post-content">
                                            <p>{{ Str::limit($post->meta_title, 80) }}</p>
                                        </div>
                                        
                                        <div class="post-tags">
                                            @foreach ($post->tags as $tag)
                                                <a href="{{ route('client.blogs.tag', $tag->id) }}" class="post-tag">{{ $tag->name }}</a>
                                            @endforeach
                                        </div>
                                        
                                        <a href="{{ route('client.blogs.show', $post->id) }}" class="post-comment">0 Bình luận</a>
                                    </div><
                                </article>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="sidebar-toggle custom-sidebar-toggle">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="sidebar-overlay"></div>
                <div class="col-lg-3 order-lg-3">
                    <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>

                        <div class="widget widget-post">
                            <h4 class="widget-title">Bài viết gần đây</h4>

                            <ul class="simple-post-list">
                                @foreach ($posts->take(5) as $post)
                                    <li>
                                        <div class="post-media">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Post">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a>
                                            <div class="post-meta">{{ $post->created_at->format('F d, Y') }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div><

                        <!-- Hiển thị danh sách các tag -->
                        <div class="widget">
                            <h4 class="widget-title">Tags</h4>

                            <div class="tagcloud">
                                @foreach ($tags as $tag)
                                    <a href="{{ route('client.blogs.tag', $tag->id) }}">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>

                    </div>>
                </div>
            </div>
        </div>
    </main>
@endsection
