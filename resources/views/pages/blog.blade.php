<x-app>
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
                    <div class="blog-post-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800"
                                alt="Blog Post">
                            <span class="blog-category">Fashion Trends</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-calendar"></i> November 25, 2024</span>
                                <span><i class="fas fa-user"></i> Sarah Johnson</span>
                                <span><i class="fas fa-comment"></i> 15 Comments</span>
                            </div>
                            <h3 class="blog-title"><a href="{{ route('blog.details')}}">10 Must-Have Fashion Pieces for Winter
                                    2024</a></h3>
                            <p class="blog-excerpt">Discover the essential fashion pieces that will keep you stylish and
                                warm this winter season. From cozy sweaters to elegant coats, we've curated the perfect
                                list for your wardrobe.</p>
                            <a href="{{ route('blog.details')}}" class="blog-read-more">Read More <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="blog-post-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800"
                                alt="Blog Post">
                            <span class="blog-category">Style Guide</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-calendar"></i> November 20, 2024</span>
                                <span><i class="fas fa-user"></i> Emma Williams</span>
                                <span><i class="fas fa-comment"></i> 23 Comments</span>
                            </div>
                            <h3 class="blog-title"><a href="{{ route('blog.details')}}">How to Style Your Wardrobe for Every
                                    Occasion</a></h3>
                            <p class="blog-excerpt">Learn the art of versatile dressing with our comprehensive guide.
                                Whether it's a casual brunch or a formal event, we've got you covered with expert
                                styling tips.</p>
                            <a href="{{ route('blog.details')}}" class="blog-read-more">Read More <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="blog-post-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800"
                                alt="Blog Post">
                            <span class="blog-category">Sustainability</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="fas fa-calendar"></i> November 15, 2024</span>
                                <span><i class="fas fa-user"></i> Michael Chen</span>
                                <span><i class="fas fa-comment"></i> 18 Comments</span>
                            </div>
                            <h3 class="blog-title"><a href="{{ route('blog.details')}}">Sustainable Fashion: Making Conscious
                                    Choices</a></h3>
                            <p class="blog-excerpt">Explore the world of sustainable fashion and learn how to make
                                eco-friendly choices without compromising on style. Discover brands and practices that
                                make a difference.</p>
                            <a href="{{ route('blog.details')}}" class="blog-read-more">Read More <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="pagination-wrapper">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#"><i
                                            class="fas fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i
                                            class="fas fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget search-widget">
                            <h5 class="widget-title">Search</h5>
                            <input type="text" class="form-control" placeholder="Search posts...">
                            <button class="btn btn-primary">Search</button>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Categories</h5>
                            <ul class="categories-list">
                                <li><a href="#">Fashion Trends <span class="count">12</span></a></li>
                                <li><a href="#">Style Guide <span class="count">8</span></a></li>
                                <li><a href="#">Sustainability <span class="count">6</span></a></li>
                                <li><a href="#">Shopping Tips <span class="count">15</span></a></li>
                                <li><a href="#">Designer Spotlight <span class="count">5</span></a></li>
                            </ul>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Recent Posts</h5>
                            <ul class="recent-posts-list">
                                <li class="recent-post-item">
                                    <div class="recent-post-image">
                                        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=200"
                                            alt="Post">
                                    </div>
                                    <div class="recent-post-info">
                                        <h6><a href="{{ route('blog.details')}}">10 Must-Have Fashion Pieces</a></h6>
                                        <p class="recent-post-date">November 25, 2024</p>
                                    </div>
                                </li>
                                <li class="recent-post-item">
                                    <div class="recent-post-image">
                                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=200"
                                            alt="Post">
                                    </div>
                                    <div class="recent-post-info">
                                        <h6><a href="{{ route('blog.details')}}">Style for Every Occasion</a></h6>
                                        <p class="recent-post-date">November 20, 2024</p>
                                    </div>
                                </li>
                                <li class="recent-post-item">
                                    <div class="recent-post-image">
                                        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=200"
                                            alt="Post">
                                    </div>
                                    <div class="recent-post-info">
                                        <h6><a href="{{ route('blog.details')}}">Sustainable Fashion Choices</a></h6>
                                        <p class="recent-post-date">November 15, 2024</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-widget">
                            <h5 class="widget-title">Tags</h5>
                            <div class="tags-widget">
                                <a href="#" class="tag">Fashion</a>
                                <a href="#" class="tag">Style</a>
                                <a href="#" class="tag">Trends</a>
                                <a href="#" class="tag">Winter</a>
                                <a href="#" class="tag">Sustainable</a>
                                <a href="#" class="tag">Shopping</a>
                                <a href="#" class="tag">Tips</a>
                                <a href="#" class="tag">Designer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
