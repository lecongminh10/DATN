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
                <div class="col-lg-9">
                    <article class="post single">
                        <div class="post-media">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                        </div><!-- End .post-media -->

                        <div class="post-body">
                            <div class="post-date">
                                <span class="day">{{ $post->created_at->format('d') }}</span>
                                <span class="month">{{ $post->created_at->format('M') }}</span>
                            </div><!-- End .post-date -->

                            <h2 class="post-title">{{ $post->title }}</h2>

                            <div class="post-meta">
                                <a href="#" class="hash-scroll">{{ $post->comments_count }} Comments</a>
                            </div><!-- End .post-meta -->

                            <div class="post-content">
                                <p>{{ strip_tags($post->content) }}</p>
                            </div><!-- End .post-content -->

                            <div class="post-share">
                                <h3 class="d-flex align-items-center">
                                    <i class="fas fa-share"></i>
                                    Share this post
                                </h3>

                                <div class="social-icons">
                                    <a href="#" class="social-icon social-facebook" target="_blank" title="Facebook">
                                        <i class="icon-facebook"></i>
                                    </a>
                                    <a href="#" class="social-icon social-twitter" target="_blank" title="Twitter">
                                        <i class="icon-twitter"></i>
                                    </a>
                                    <a href="#" class="social-icon social-linkedin" target="_blank" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .post-share -->

                            <div class="post-author">
                                <h3><i class="far fa-user"></i>Author</h3>

                                <figure>
                                    <a href="#">
                                        <img src="{{ asset('storage/' . $post->user->profile_picture) }}"
                                            alt="{{ $post->user->username }}">
                                    </a>
                                </figure>

                                <div class="author-content">
                                    <h4><a href="#">{{ $post->user->username }}</a></h4>
                                    <p>{{ $post->user->bio }}</p>
                                </div><!-- End .author-content -->
                            </div><!-- End .post-author -->
                        </div><!-- End .post-body -->
                    </article><!-- End .post -->

                    <hr class="mt-2 mb-1">
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
                                <li>
                                    <a href="#">All about clothing</a>

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

                        {{-- <div class="widget">
                            <h4 class="widget-title">Tags</h4>

                            <div class="tagcloud">
                                <a href="#">ARTICLES</a>
                                <a href="#">CHAT</a>
                            </div><!-- End .tagcloud -->
                        </div><!-- End .widget --> --}}
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->

                <!-- Sidebar code here -->
            </div><!-- End .row -->
        </div><!-- End .container -->

    </main><!-- End .main -->
@endsection
