@extends('client.layouts.app')

@section('content')
    @include('client.layouts.nav')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="demo4.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="blog-section row">
                        @foreach ($posts as $post)
                        <div class="col-md-6 col-lg-4">
                            <article class="post">
                                <div class="post-media">
                                    <a href="{{ route('client.blogs.show', $post->id) }}">
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Post" width="225" height="280">
                                    </a>
                                    <div class="post-date">
                                        <span class="day">{{ $post->created_at->format('d') }}</span>
                                        <span class="month">{{ $post->created_at->format('M') }}</span>
                                    </div>
                                </div><!-- End .post-media -->
                        
                                <div class="post-body">
                                    <h2 class="post-title">
                                        <a href="{{ route('client.blogs.show', $post->id) }}">{{ $post->title }}</a>
                                    </h2>
                                    <div class="post-content">
                                        <p>{{ Str::limit($post->content, 100) }}</p>
                                    </div><!-- End .post-content -->
                                    <a href="{{ route('client.blogs.show', $post->id) }}" class="post-comment">0 Comments</a>
                                </div><!-- End .post-body -->
                            </article><!-- End .post -->
                        </div>
                        
                        @endforeach
                    </div>
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-toggle custom-sidebar-toggle">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="sidebar-overlay"></div>
                <aside class="sidebar mobile-sidebar col-lg-3">
                    <div class="sidebar-wrapper" data-sticky-sidebar-options='{"offsetTop": 72}'>
                        {{-- <div class="widget widget-categories">
                            <h4 class="widget-title">Blog Categories</h4>

                            <ul class="list">
                                <li><a href="#">All about clothing</a>
                                    <ul class="list">
                                        <li><a href="#">Dresses</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Make-up &amp; beauty</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Fashion trends</a></li>
                                <li><a href="#">Haircuts &amp; hairstyles</a></li>
                            </ul>
                        </div><!-- End .widget --> --}}

                        <div class="widget widget-post">
                            <h4 class="widget-title">Recent Posts</h4>

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

                        <div class="widget">
                            <h4 class="widget-title">Tags</h4>
                            <div class="tagcloud">
                                <a href="#">ARTICLES</a>
                                <a href="#">CHAT</a>
                            </div><!-- End .tagcloud -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </main><!-- End .main -->
@endsection
