<x-app>
    @push('meta')
        <title>{{ $blogPost->title }} | FashionHub Blog</title>
        <meta name="description" content="{{ \Illuminate\Support\Str::limit((string) ($blogPost->excerpt ?? ''), 160) }}">
        <meta name="keywords" content="{{ collect($blogPost->tags ?? [])->filter()->implode(', ') }}">
        <meta property="og:title" content="{{ $blogPost->title }} | FashionHub Blog">
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit((string) ($blogPost->excerpt ?? ''), 160) }}">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="article">
        <meta property="og:image" content="{{ $blogPost->featured_image_url ?? asset('assets/images/logo/logo.png') }}">
        <meta name="twitter:title" content="{{ $blogPost->title }} | FashionHub Blog">
        <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit((string) ($blogPost->excerpt ?? ''), 160) }}">
        <meta name="twitter:image" content="{{ $blogPost->featured_image_url ?? asset('assets/images/logo/logo.png') }}">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/blog-details.css') }}">
    @endpush

    @php
        $contentParagraphs = collect(preg_split('/\r\n|\r|\n/', (string) ($blogPost->content ?? '')))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values();

        $displayTags = collect($blogPost->tags ?? [])->filter()->values();
    @endphp

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <div class="post-meta">
                        <span class="category-tag">{{ $blogPost->category ?: 'Uncategorized' }}</span>
                        <span class="post-date"><i class="far fa-calendar"></i>
                            {{ optional($blogPost->publish_date)->format('F d, Y') ?? 'Recently published' }}</span>
                        <span class="post-author"><i class="far fa-user"></i> By {{ $blogPost->author_name ?? 'FashionHub Team' }}</span>
                        <span class="post-views"><i class="far fa-eye"></i> {{ number_format((int) ($blogPost->views_count ?? 0)) }} Views</span>
                    </div>
                    <h1 class="post-title text-light">{{ $blogPost->title }}</h1>
                    <p class="post-excerpt">{{ $blogPost->excerpt }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-content-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="blog-post">
                        <div class="featured-image">
                            <img src="{{ $blogPost->featured_image_url ?? 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200&h=600&fit=crop' }}"
                                alt="{{ $blogPost->title }}" class="img-fluid">
                        </div>

                        <div class="post-content">
                            @forelse ($contentParagraphs as $paragraph)
                                <p class="{{ $loop->first ? 'lead' : '' }}">{{ $paragraph }}</p>
                            @empty
                                <p class="lead">Content will appear here once you publish a blog post from admin.</p>
                            @endforelse
                        </div>

                        <div class="post-tags">
                            <h5><i class="fas fa-tags"></i> Tags:</h5>
                            @forelse ($displayTags as $tag)
                                <a href="{{ route('blog', ['q' => $tag]) }}" class="tag">{{ $tag }}</a>
                            @empty
                                <a href="{{ route('blog') }}" class="tag">Fashion</a>
                            @endforelse
                        </div>

                        <div class="related-posts">
                            <h3><i class="fas fa-newspaper"></i> Related Articles</h3>
                            <div class="row">
                                @forelse ($relatedPosts as $relatedPost)
                                    <div class="col-md-4">
                                        <div class="related-post-card">
                                            <div class="related-post-image">
                                                <img src="{{ $relatedPost->featured_image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&h=250&fit=crop' }}"
                                                    alt="{{ $relatedPost->title }}">
                                                <span class="post-category">{{ $relatedPost->category ?: 'Fashion' }}</span>
                                            </div>
                                            <div class="related-post-content">
                                                <p class="post-date"><i class="far fa-calendar"></i>
                                                    {{ optional($relatedPost->publish_date)->format('M d, Y') ?? 'Recent' }}</p>
                                                <h5>{{ \Illuminate\Support\Str::limit($relatedPost->title, 45) }}</h5>
                                                <p>{{ \Illuminate\Support\Str::limit((string) ($relatedPost->excerpt ?? ''), 75) }}</p>
                                                <a href="{{ route('blog.details', ['blogPost' => $relatedPost->slug ?? null]) }}"
                                                    class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="mb-0">No related articles available yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <div class="sidebar-widget search-widget">
                            <h4><i class="fas fa-search"></i> Search</h4>
                            <form class="search-form" action="{{ route('blog') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search posts...">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="sidebar-widget categories-widget">
                            <h4><i class="fas fa-folder"></i> Categories</h4>
                            <ul class="category-list">
                                @forelse ($categoryCounts as $category => $count)
                                    <li>
                                        <a href="{{ route('blog', ['q' => $category]) }}">
                                            <span>{{ $category }}</span>
                                            <span class="count">{{ $count }}</span>
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <a href="#">
                                            <span>No categories</span>
                                            <span class="count">0</span>
                                        </a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="sidebar-widget recent-posts-widget">
                            <h4><i class="far fa-clock"></i> Recent Posts</h4>
                            @forelse ($recentPosts as $recentPost)
                                <div class="recent-post-item">
                                    <div class="recent-post-thumb">
                                        <img src="{{ $recentPost->featured_image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=100&h=80&fit=crop' }}"
                                            alt="{{ $recentPost->title }}">
                                    </div>
                                    <div class="recent-post-info">
                                        <h6><a
                                                href="{{ route('blog.details', ['blogPost' => $recentPost->slug ?? null]) }}">{{ \Illuminate\Support\Str::limit($recentPost->title, 38) }}</a>
                                        </h6>
                                        <p class="post-date"><i class="far fa-calendar"></i>
                                            {{ optional($recentPost->publish_date)->format('M d, Y') ?? 'Recent' }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="mb-0">No recent posts.</p>
                            @endforelse
                        </div>

                        <div class="sidebar-widget tags-widget">
                            <h4><i class="fas fa-tags"></i> Popular Tags</h4>
                            <div class="tag-cloud">
                                @forelse ($popularTags as $tag)
                                    <a href="{{ route('blog', ['q' => $tag]) }}">{{ $tag }}</a>
                                @empty
                                    <a href="{{ route('blog') }}">Fashion</a>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</x-app>
