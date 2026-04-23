<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/terms.css') }}">
    @endpush
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-file-contract"></i> Terms & Conditions</h1>
                    <p class="header-subtitle">Please read these terms carefully before using our services</p>
                    <p class="last-updated"><i class="far fa-calendar-alt"></i> Last Updated: November 30, 2025</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Terms & Conditions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms Content Section -->
    <section class="terms-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3">
                    <div class="terms-sidebar">
                        <h5>Quick Navigation</h5>
                        <ul class="terms-nav">
                            <li><a href="#introduction"><i class="fas fa-chevron-right"></i> Introduction</a></li>
                            <li><a href="#website-use"><i class="fas fa-chevron-right"></i> Use of Website</a></li>
                            <li><a href="#account-terms"><i class="fas fa-chevron-right"></i> Account Terms</a></li>
                            <li><a href="#orders-payments"><i class="fas fa-chevron-right"></i> Orders & Payments</a>
                            </li>
                            <li><a href="#shipping"><i class="fas fa-chevron-right"></i> Shipping & Delivery</a></li>
                            <li><a href="#returns"><i class="fas fa-chevron-right"></i> Returns & Refunds</a></li>
                            <li><a href="#intellectual-property"><i class="fas fa-chevron-right"></i> Intellectual
                                    Property</a></li>
                            <li><a href="#limitation"><i class="fas fa-chevron-right"></i> Limitation of Liability</a>
                            </li>
                            <li><a href="#changes"><i class="fas fa-chevron-right"></i> Changes to Terms</a></li>
                            <li><a href="#contact-terms"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="terms-content">
                        <!-- Introduction -->
                        <div class="terms-section-item" id="introduction">
                            <h2><i class="fas fa-home"></i> Introduction</h2>
                            <p>Welcome to FashionHub. These Terms and Conditions ("Terms") govern your access to and use
                                of our website, products, and services. By accessing or using FashionHub, you agree to
                                be bound by these Terms.</p>
                            <p>If you do not agree to these Terms, please do not use our website or services. We reserve
                                the right to modify these Terms at any time, and such modifications will be effective
                                immediately upon posting on the website.</p>
                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <div>
                                    <strong>Important:</strong> By continuing to use our services after changes are
                                    posted, you accept the modified Terms.
                                </div>
                            </div>
                        </div>

                        <!-- Use of Website -->
                        <div class="terms-section-item" id="website-use">
                            <h2><i class="fas fa-desktop"></i> Use of Website</h2>
                            <p>You agree to use our website only for lawful purposes and in accordance with these Terms.
                                You must not:</p>
                            <ul class="terms-list">
                                <li>Use the website in any way that violates any applicable federal, state, local, or
                                    international law or regulation</li>
                                <li>Engage in any conduct that restricts or inhibits anyone's use or enjoyment of the
                                    website</li>
                                <li>Transmit any advertising or promotional material without our prior written consent
                                </li>
                                <li>Impersonate or attempt to impersonate FashionHub, a FashionHub employee, another
                                    user, or any other person or entity</li>
                                <li>Use any robot, spider, or other automatic device to access the website for any
                                    purpose without our express written permission</li>
                            </ul>
                        </div>

                        <!-- Account Terms -->
                        <div class="terms-section-item" id="account-terms">
                            <h2><i class="fas fa-user-circle"></i> Account Terms</h2>
                            <p>When you create an account with us, you must provide accurate, complete, and current
                                information at all times. Failure to do so constitutes a breach of the Terms.</p>
                            <h5>Account Responsibilities:</h5>
                            <ul class="terms-list">
                                <li>You are responsible for safeguarding the password that you use to access the website
                                </li>
                                <li>You agree not to disclose your password to any third party</li>
                                <li>You must notify us immediately upon becoming aware of any breach of security or
                                    unauthorized use of your account</li>
                                <li>You may not use another person's account without their permission</li>
                                <li>We reserve the right to refuse service, terminate accounts, or remove content at our
                                    sole discretion</li>
                            </ul>
                        </div>

                        <!-- Orders and Payments -->
                        <div class="terms-section-item" id="orders-payments">
                            <h2><i class="fas fa-shopping-cart"></i> Product Orders and Payments</h2>
                            <p>All orders placed through our website are subject to acceptance and availability. We
                                reserve the right to refuse or cancel any order for any reason.</p>

                            <h5>Pricing:</h5>
                            <p>All prices are in USD and are subject to change without notice. We strive to ensure
                                pricing accuracy, but errors may occur. If we discover an error in the price of products
                                you have ordered, we will inform you and give you the option to reconfirm your order at
                                the correct price or cancel it.</p>

                            <h5>Payment:</h5>
                            <ul class="terms-list">
                                <li>Payment must be received before your order is processed</li>
                                <li>We accept major credit cards, debit cards, and other payment methods as displayed on
                                    our website</li>
                                <li>All payments are processed securely through encrypted connections</li>
                                <li>You warrant that you have the legal right to use any payment method you provide</li>
                            </ul>

                            <div class="warning-box">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Payment Security:</strong> Never share your payment information via email or
                                    phone. We will never ask for your complete credit card details outside our secure
                                    checkout process.
                                </div>
                            </div>
                        </div>

                        <!-- Shipping and Delivery -->
                        <div class="terms-section-item" id="shipping">
                            <h2><i class="fas fa-shipping-fast"></i> Shipping and Delivery</h2>
                            <p>We ship to addresses within the United States and select international locations.
                                Shipping costs and delivery times vary based on your location and chosen shipping
                                method.</p>

                            <h5>Shipping Policy:</h5>
                            <ul class="terms-list">
                                <li>Orders are typically processed within 1-2 business days</li>
                                <li>Standard shipping takes 5-7 business days</li>
                                <li>Express shipping takes 2-3 business days</li>
                                <li>International shipping may take 10-15 business days</li>
                                <li>Delivery times are estimates and not guaranteed</li>
                                <li>You will receive a tracking number once your order ships</li>
                            </ul>

                            <p><strong>Risk of Loss:</strong> All items purchased from FashionHub are made pursuant to a
                                shipment contract. The risk of loss and title for such items pass to you upon delivery
                                to the carrier.</p>
                        </div>

                        <!-- Returns and Refunds -->
                        <div class="terms-section-item" id="returns">
                            <h2><i class="fas fa-undo"></i> Returns and Refunds</h2>
                            <p>We want you to be completely satisfied with your purchase. If you're not satisfied, we
                                accept returns within 30 days of delivery.</p>

                            <h5>Return Conditions:</h5>
                            <ul class="terms-list">
                                <li>Items must be unworn, unwashed, and in original condition with all tags attached
                                </li>
                                <li>Items must be returned in original packaging</li>
                                <li>Proof of purchase is required for all returns</li>
                                <li>Sale items and final sale items are not eligible for return</li>
                                <li>Customized or personalized items cannot be returned</li>
                            </ul>

                            <h5>Refund Process:</h5>
                            <p>Once we receive and inspect your return, we will notify you of the approval or rejection
                                of your refund. If approved, your refund will be processed, and a credit will be applied
                                to your original method of payment within 5-10 business days.</p>

                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <div>
                                    <strong>Return Shipping:</strong> Customers are responsible for return shipping
                                    costs unless the item is defective or we made an error in your order.
                                </div>
                            </div>
                        </div>

                        <!-- Intellectual Property -->
                        <div class="terms-section-item" id="intellectual-property">
                            <h2><i class="fas fa-copyright"></i> Intellectual Property</h2>
                            <p>The website and its entire contents, features, and functionality (including but not
                                limited to all information, software, text, displays, images, video, and audio) are
                                owned by FashionHub, its licensors, or other providers of such material and are
                                protected by copyright, trademark, patent, trade secret, and other intellectual property
                                or proprietary rights laws.</p>

                            <h5>Usage Restrictions:</h5>
                            <ul class="terms-list">
                                <li>You may not reproduce, distribute, modify, or create derivative works of our content
                                </li>
                                <li>You may not reverse engineer any aspect of the website</li>
                                <li>All trademarks, logos, and service marks displayed on the website are our property
                                    or the property of third parties</li>
                                <li>You are not permitted to use these marks without prior written consent</li>
                            </ul>
                        </div>

                        <!-- Limitation of Liability -->
                        <div class="terms-section-item" id="limitation">
                            <h2><i class="fas fa-shield-alt"></i> Limitation of Liability</h2>
                            <p>To the fullest extent permitted by applicable law, FashionHub shall not be liable for any
                                indirect, incidental, special, consequential, or punitive damages, or any loss of
                                profits or revenues, whether incurred directly or indirectly, or any loss of data, use,
                                goodwill, or other intangible losses.</p>

                            <h5>Disclaimers:</h5>
                            <ul class="terms-list">
                                <li>The website is provided on an "as is" and "as available" basis</li>
                                <li>We make no warranties, expressed or implied, regarding the website's operation or
                                    content</li>
                                <li>We do not guarantee that the website will be error-free or uninterrupted</li>
                                <li>We are not responsible for any damage to your computer system or loss of data</li>
                            </ul>

                            <div class="warning-box">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Maximum Liability:</strong> Our total liability to you for any claims
                                    arising from your use of the website shall not exceed the amount you paid us in the
                                    12 months prior to the claim.
                                </div>
                            </div>
                        </div>

                        <!-- Changes to Terms -->
                        <div class="terms-section-item" id="changes">
                            <h2><i class="fas fa-edit"></i> Changes to Terms</h2>
                            <p>We reserve the right to modify or replace these Terms at any time at our sole discretion.
                                If a revision is material, we will provide at least 30 days' notice prior to any new
                                terms taking effect.</p>
                            <p>What constitutes a material change will be determined at our sole discretion. By
                                continuing to access or use our website after revisions become effective, you agree to
                                be bound by the revised terms.</p>
                        </div>

                        <!-- Contact -->
                        <div class="terms-section-item" id="contact-terms">
                            <h2><i class="fas fa-envelope"></i> Contact Us</h2>
                            <p>If you have any questions about these Terms and Conditions, please contact us:</p>
                            <div class="contact-info-box">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <strong>Email:</strong>
                                        <a href="mailto:legal@fashionhub.com">legal@fashionhub.com</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <strong>Phone:</strong>
                                        <a href="tel:+12345678900">+1 (234) 567-8900</a>
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <strong>Address:</strong>
                                        123 Fashion Street, New York, NY 10001
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Notice -->
                        <div class="agreement-notice">
                            <i class="fas fa-check-circle"></i>
                            <p><strong>By using our website, you acknowledge that you have read and understood these
                                    Terms and Conditions and agree to be bound by them.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <!-- Smooth Scroll Script -->
        <script>
            document.querySelectorAll('.terms-nav a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Highlight active section in sidebar
            window.addEventListener('scroll', () => {
                let current = '';
                document.querySelectorAll('.terms-section-item').forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                document.querySelectorAll('.terms-nav a').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            });
        </script>
    @endpush
</x-app>
