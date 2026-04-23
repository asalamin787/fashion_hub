<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
    @endpush
    
    <section class="about-hero">
        <div class="container">
            <h1>About FashionHub</h1>
            <p>Bringing you timeless style and exceptional quality since 2015</p>
        </div>
    </section>

    <section class="story-section">
        <div class="container">
            <div class="story-content">
                <div class="story-image">
                    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600" alt="Our Story">
                </div>
                <div class="story-text">
                    <h2>Our Story</h2>
                    <p>Founded in 2015, FashionHub began with a simple vision: to make high-quality, stylish fashion
                        accessible to everyone. What started as a small boutique has grown into a trusted online
                        destination for fashion enthusiasts worldwide.</p>
                    <p>We believe that fashion is more than just clothing—it's a form of self-expression. That's why we
                        carefully curate each piece in our collection, ensuring it meets our high standards for quality,
                        style, and sustainability.</p>
                    <p>Today, we serve thousands of satisfied customers globally, offering an ever-expanding range of
                        fashion-forward pieces that combine timeless elegance with contemporary trends.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Values</h2>
                <p>What drives us every day</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h4>Quality First</h4>
                        <p>We source only the finest materials and work with skilled artisans to ensure every piece
                            meets our exacting standards.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Sustainability</h4>
                        <p>We're committed to ethical fashion practices and sustainable production methods that respect
                            our planet.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Customer Satisfaction</h4>
                        <p>Your happiness is our priority. We go above and beyond to ensure you love every purchase.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Team</h2>
                <p>The faces behind FashionHub</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-member">
                        <div class="team-image">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Team Member">
                            <div class="team-overlay">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <h4>Sarah Anderson</h4>
                            <p>Founder & CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-member">
                        <div class="team-image">
                            <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Team Member">
                            <div class="team-overlay">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <h4>Michael Chen</h4>
                            <p>Creative Director</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-member">
                        <div class="team-image">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Team Member">
                            <div class="team-overlay">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <h4>Emma Wilson</h4>
                            <p>Head of Marketing</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-member">
                        <div class="team-image">
                            <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Team Member">
                            <div class="team-overlay">
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-info">
                            <h4>James Rodriguez</h4>
                            <p>Operations Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Countries</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-number">9+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>