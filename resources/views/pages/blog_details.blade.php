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

        $readingTime = max(1, (int) ceil(str_word_count((string) ($blogPost->content ?? '')) / 200));
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
                        <span class="post-reading-time"><i class="far fa-clock"></i> {{ $readingTime }} min read</span>
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

                        <div class="social-share">
                            <h5><i class="fas fa-share-alt"></i> Share this article</h5>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blogPost->title) }}" target="_blank" rel="noopener noreferrer" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($blogPost->title) }}" target="_blank" rel="noopener noreferrer" class="share-btn pinterest">
                                    <i class="fab fa-pinterest-p"></i> Pinterest
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($blogPost->title) }}" target="_blank" rel="noopener noreferrer" class="share-btn linkedin">
                                    <i class="fab fa-linkedin-in"></i> LinkedIn
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($blogPost->title . ' — ' . request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
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

                        <div class="author-bio">
                            <div class="author-image">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($blogPost->author_name ?? 'FashionHub Team') }}&background=865749&color=fff&size=130&bold=true" alt="{{ $blogPost->author_name ?? 'FashionHub Team' }}">
                            </div>
                            <div class="author-info">
                                <h4>{{ $blogPost->author_name ?? 'FashionHub Team' }}</h4>
                                <p class="author-role"><i class="fas fa-pen-nib"></i> Fashion Writer & Style Expert</p>
                                <p class="author-description">Passionate about fashion and lifestyle, bringing you the latest trends and style inspiration. With years of experience in the industry, dedicated to helping you look and feel your best every single day.</p>
                                <div class="author-social">
                                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="#" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="comments-section">
                            <h3><i class="fas fa-comments"></i> Comments ({{ (int) ($blogPost->comments_count ?? 0) }})</h3>

                            <div class="comment">
                                <div class="comment-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=C0876A&color=fff&size=70" alt="Sarah Johnson">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <h5>Sarah Johnson</h5>
                                        <span class="comment-date"><i class="far fa-clock"></i> 2 days ago</span>
                                    </div>
                                    <p>This is such an insightful article! The styling tips are really practical and easy to follow. I've already tried the layering technique and got so many compliments. Thank you for sharing!</p>
                                    <a href="#" class="reply-btn"><i class="fas fa-reply"></i> Reply</a>
                                </div>
                            </div>

                            <div class="comment">
                                <div class="comment-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Emma+Williams&background=A76048&color=fff&size=70" alt="Emma Williams">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <h5>Emma Williams</h5>
                                        <span class="comment-date"><i class="far fa-clock"></i> 5 days ago</span>
                                    </div>
                                    <p>Loved reading this! FashionHub always delivers quality content. Would love to see more articles about sustainable fashion choices and eco-friendly brands.</p>
                                    <a href="#" class="reply-btn"><i class="fas fa-reply"></i> Reply</a>
                                </div>
                            </div>

                            <div class="comment-form">
                                <h4><i class="fas fa-pen"></i> Leave a Comment</h4>
                                <form>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Your Name *" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" placeholder="Your Email *" required>
                                        </div>
                                        <div class="col-12">
                                            <input type="url" class="form-control" placeholder="Your Website (optional)">
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" rows="5" placeholder="Write your comment here..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn-submit">
                                                <i class="fas fa-paper-plane"></i> Post Comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
