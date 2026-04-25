<x-app>
    @push('meta')
        <title>Fashion Blog | FashionHub</title>
        <meta name="description" content="Explore FashionHub blog for the latest fashion trends, styling guides, sustainability tips, and shopping advice.">
        <meta name="keywords" content="fashion blog, style guide, fashion trends, shopping tips, sustainability">
        <meta property="og:title" content="Fashion Blog | FashionHub">
        <meta property="og:description" content="Explore FashionHub blog for the latest fashion trends, styling guides, sustainability tips, and shopping advice.">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="Fashion Blog | FashionHub">
        <meta name="twitter:description" content="Explore FashionHub blog for the latest fashion trends, styling guides, sustainability tips, and shopping advice.">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Fashion Blog</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @forelse ($blogPosts as $post)
                        <div class="blog-post-card">
                            <div class="blog-image">
                                <img src="{{ $post->featured_image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800' }}"
                                    alt="{{ $post->title }}">
                                <span class="blog-category">{{ $post->category ?: 'Uncategorized' }}</span>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar"></i>
                                        {{ optional($post->publish_date)->format('F d, Y') ?? 'Recently published' }}</span>
                                    <span><i class="fas fa-user"></i> {{ $post->author_name ?? 'FashionHub Team' }}</span>
                                    <span><i class="fas fa-comment"></i> {{ (int) ($post->comments_count ?? 0) }} Comments</span>
                                </div>
                                <h3 class="blog-title"><a
                                        href="{{ route('blog.details', ['blogPost' => $post->slug ?? null]) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="blog-excerpt">{{ $post->excerpt ?: \Illuminate\Support\Str::limit((string) ($post->content ?? ''), 190) }}
                                </p>
                                <a href="{{ route('blog.details', ['blogPost' => $post->slug ?? null]) }}" class="blog-read-more">Read
                                    More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="blog-post-card">
                            <div class="blog-content">
                                <h3 class="blog-title">No blog posts found</h3>
                                <p class="blog-excerpt">Try another keyword or create a post from the admin panel.</p>
                            </div>
                        </div>
                    @endforelse

                    @if ($blogPosts->lastPage() > 1)
                        <div class="pagination-wrapper">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $blogPosts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $blogPosts->previousPageUrl() ?: '#' }}"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>

                                    @foreach ($blogPosts->getUrlRange(1, $blogPosts->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page === $blogPosts->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ $blogPosts->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $blogPosts->nextPageUrl() ?: '#' }}"><i
                                                class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget search-widget">
                            <h5 class="widget-title">Search</h5>
                            <form action="{{ route('blog') }}" method="GET">
                                <input type="text" class="form-control" name="q" placeholder="Search posts..."
                                    value="{{ $searchTerm }}">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Categories</h5>
                            <ul class="categories-list">
                                @forelse ($categoryCounts as $category => $count)
                                    <li><a href="{{ route('blog', ['q' => $category]) }}">{{ $category }} <span
                                                class="count">{{ $count }}</span></a></li>
                                @empty
                                    <li><a href="#">No categories <span class="count">0</span></a></li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Recent Posts</h5>
                            <ul class="recent-posts-list">
                                @forelse ($recentPosts as $recentPost)
                                    <li class="recent-post-item">
                                        <div class="recent-post-image">
                                            <img src="{{ $recentPost->featured_image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=200' }}"
                                                alt="{{ $recentPost->title }}">
                                        </div>
                                        <div class="recent-post-info">
                                            <h6><a
                                                    href="{{ route('blog.details', ['blogPost' => $recentPost->slug ?? null]) }}">{{ \Illuminate\Support\Str::limit($recentPost->title, 32) }}</a>
                                            </h6>
                                            <p class="recent-post-date">
                                                {{ optional($recentPost->publish_date)->format('F d, Y') ?? 'Recently' }}</p>
                                        </div>
                                    </li>
                                @empty
                                    <li class="recent-post-item">
                                        <div class="recent-post-info">
                                            <h6>No recent posts</h6>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Tags</h5>
                            <div class="tags-widget">
                                @forelse ($popularTags as $tag)
                                    <a href="{{ route('blog', ['q' => $tag]) }}" class="tag">{{ $tag }}</a>
                                @empty
                                    <a href="#" class="tag">Fashion</a>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
