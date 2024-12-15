@extends('client.layouts.app')

@section('content')
    @include('client.layouts.nav')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-1">
                    <article class="post single">
                        <div class="post-media" style="width: 550px; height: 550px;">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }} " style="width: 550px; height: 550px;">
                        </div><!-- End .post-media -->

                        <div class="post-body">
                            <div class="post-date">
                                <span class="day">{{ $post->created_at->format('d') }}</span>
                                <span class="month">{{ $post->created_at->format('M') }}</span>
                            </div><!-- End .post-date -->

                            <h2 class="post-title">{{ $post->title }}</h2>

                            <div class="post-meta">
                                <a href="#" class="hash-scroll">{{ $post->comments_count }} Bình luận</a>
                            </div><!-- End .post-meta -->

                            <div class="post-content">
                               
                                <p>{!! strip_tags(html_entity_decode($post->content), '<p><img><a><b><i><ul><ol><li>') !!}</p>
                            </div><!-- End .post-content -->

                            
                        </div><!-- End .post-body -->
                    </article><!-- End .post -->

                    <hr class="mt-2 mb-1">
                </div><!-- End .col-lg-9 -->
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
                                        </div><!-- End .post-media -->
                                        <div class="post-info">
                                            <a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a>
                                            <div class="post-meta">{{ $post->created_at->format('F d, Y') }}</div>
                                        </div><!-- End .post-info -->
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- End .widget -->

                        
                    </div><!-- End .sidebar-wrapper -->
                </div><!-- End .col-lg-3 -->

                <!-- Sidebar code here -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </main><!-- End .main -->
@endsection
