<x-app>
    @push('meta')
        <title>Privacy Policy | FashionHub</title>
        <meta name="description" content="Read FashionHub's Privacy Policy to understand how we collect, use, and protect your personal information.">
        <meta name="keywords" content="privacy policy, data protection, user privacy, fashionhub policy">
        <meta property="og:title" content="Privacy Policy | FashionHub">
        <meta property="og:description" content="Read FashionHub's Privacy Policy to understand how we collect, use, and protect your personal information.">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="Privacy Policy | FashionHub">
        <meta name="twitter:description" content="Read FashionHub's Privacy Policy to understand how we collect, use, and protect your personal information.">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/privacy.css') }}">
    @endpush

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-shield-alt"></i> Privacy Policy</h1>
                    <p class="header-subtitle">Your privacy is important to us. Learn how we protect your data.</p>
                    <p class="last-updated"><i class="far fa-calendar-alt"></i> Last Updated: November 30, 2025</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Privacy Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Content Section -->
    <section class="privacy-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3">
                    <div class="privacy-sidebar">
                        <h5>Quick Navigation</h5>
                        <ul class="privacy-nav">
                            <li><a href="#introduction"><i class="fas fa-chevron-right"></i> Introduction</a></li>
                            <li><a href="#information-collection"><i class="fas fa-chevron-right"></i> Information
                                    Collection</a></li>
                            <li><a href="#information-use"><i class="fas fa-chevron-right"></i> Use of Information</a>
                            </li>
                            <li><a href="#cookies"><i class="fas fa-chevron-right"></i> Cookies & Tracking</a></li>
                            <li><a href="#third-party"><i class="fas fa-chevron-right"></i> Third-Party Sharing</a></li>
                            <li><a href="#data-security"><i class="fas fa-chevron-right"></i> Data Security</a></li>
                            <li><a href="#user-rights"><i class="fas fa-chevron-right"></i> Your Rights</a></li>
                            <li><a href="#children"><i class="fas fa-chevron-right"></i> Children's Privacy</a></li>
                            <li><a href="#changes"><i class="fas fa-chevron-right"></i> Policy Changes</a></li>
                            <li><a href="#contact-privacy"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="privacy-content">
                        <!-- Introduction -->
                        <div class="privacy-section-item" id="introduction">
                            <h2><i class="fas fa-info-circle"></i> Introduction</h2>
                            <p>At FashionHub, we are committed to protecting your privacy and ensuring the security of
                                your personal information. This Privacy Policy explains how we collect, use, disclose,
                                and safeguard your information when you visit our website or make a purchase.</p>
                            <p>By using our website, you consent to the data practices described in this policy. If you
                                do not agree with our policies and practices, please do not use our website.</p>

                            <div class="privacy-card">
                                <div class="privacy-card-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="privacy-card-content">
                                    <h6>Our Commitment</h6>
                                    <p>We will never sell your personal information to third parties. Your data is used
                                        solely to enhance your shopping experience and fulfill your orders.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Information Collection -->
                        <div class="privacy-section-item" id="information-collection">
                            <h2><i class="fas fa-database"></i> Information We Collect</h2>
                            <p>We collect several types of information from and about users of our website, including:
                            </p>

                            <h5>Personal Information:</h5>
                            <div class="info-grid">
                                <div class="info-grid-item">
                                    <i class="fas fa-user"></i>
                                    <h6>Identity Data</h6>
                                    <p>Name, username, date of birth</p>
                                </div>
                                <div class="info-grid-item">
                                    <i class="fas fa-envelope"></i>
                                    <h6>Contact Data</h6>
                                    <p>Email address, phone number, billing and shipping addresses</p>
                                </div>
                                <div class="info-grid-item">
                                    <i class="fas fa-credit-card"></i>
                                    <h6>Financial Data</h6>
                                    <p>Payment card details (processed securely by payment providers)</p>
                                </div>
                                <div class="info-grid-item">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h6>Transaction Data</h6>
                                    <p>Purchase history, order details, cart contents</p>
                                </div>
                                <div class="info-grid-item">
                                    <i class="fas fa-laptop"></i>
                                    <h6>Technical Data</h6>
                                    <p>IP address, browser type, device information</p>
                                </div>
                                <div class="info-grid-item">
                                    <i class="fas fa-chart-line"></i>
                                    <h6>Usage Data</h6>
                                    <p>How you interact with our website, pages visited, time spent</p>
                                </div>
                            </div>

                            <h5 class="mt-4">How We Collect Information:</h5>
                            <ul class="privacy-list">
                                <li><strong>Directly from you:</strong> When you create an account, make a purchase, or
                                    contact us</li>
                                <li><strong>Automatically:</strong> Through cookies and similar technologies as you
                                    navigate our website</li>
                                <li><strong>From third parties:</strong> Payment processors, delivery services, and
                                    analytics providers</li>
                            </ul>
                        </div>

                        <!-- Information Use -->
                        <div class="privacy-section-item" id="information-use">
                            <h2><i class="fas fa-tasks"></i> How We Use Your Information</h2>
                            <p>We use the information we collect about you for various purposes, including:</p>

                            <div class="purpose-card">
                                <div class="purpose-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="purpose-content">
                                    <h6>Order Processing & Fulfillment</h6>
                                    <p>To process your transactions, manage orders, and deliver products to you</p>
                                </div>
                            </div>

                            <div class="purpose-card">
                                <div class="purpose-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="purpose-content">
                                    <h6>Account Management</h6>
                                    <p>To create and manage your account, including authentication and customer support
                                    </p>
                                </div>
                            </div>

                            <div class="purpose-card">
                                <div class="purpose-icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div class="purpose-content">
                                    <h6>Communication</h6>
                                    <p>To send you order confirmations, shipping updates, newsletters, and promotional
                                        offers</p>
                                </div>
                            </div>

                            <div class="purpose-card">
                                <div class="purpose-icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="purpose-content">
                                    <h6>Analytics & Improvement</h6>
                                    <p>To analyze website usage and improve our products, services, and user experience
                                    </p>
                                </div>
                            </div>

                            <div class="purpose-card">
                                <div class="purpose-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="purpose-content">
                                    <h6>Security & Fraud Prevention</h6>
                                    <p>To protect against fraudulent transactions and ensure the security of our website
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Cookies -->
                        <div class="privacy-section-item" id="cookies">
                            <h2><i class="fas fa-cookie-bite"></i> Cookies and Tracking Technologies</h2>
                            <p>We use cookies and similar tracking technologies to track activity on our website and
                                store certain information. Cookies are files with small amounts of data that are stored
                                on your device.</p>

                            <h5>Types of Cookies We Use:</h5>
                            <div class="cookie-table">
                                <div class="cookie-row">
                                    <div class="cookie-type">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Essential Cookies</strong>
                                    </div>
                                    <div class="cookie-desc">
                                        <p>Required for the website to function properly. Enable core functionality like
                                            security, network management, and accessibility.</p>
                                    </div>
                                </div>
                                <div class="cookie-row">
                                    <div class="cookie-type">
                                        <i class="fas fa-chart-bar"></i>
                                        <strong>Analytics Cookies</strong>
                                    </div>
                                    <div class="cookie-desc">
                                        <p>Help us understand how visitors interact with our website by collecting and
                                            reporting information anonymously.</p>
                                    </div>
                                </div>
                                <div class="cookie-row">
                                    <div class="cookie-type">
                                        <i class="fas fa-cog"></i>
                                        <strong>Functional Cookies</strong>
                                    </div>
                                    <div class="cookie-desc">
                                        <p>Remember your preferences and choices, such as language settings and region.
                                        </p>
                                    </div>
                                </div>
                                <div class="cookie-row">
                                    <div class="cookie-type">
                                        <i class="fas fa-bullhorn"></i>
                                        <strong>Marketing Cookies</strong>
                                    </div>
                                    <div class="cookie-desc">
                                        <p>Used to deliver relevant advertisements and track advertising campaign
                                            effectiveness.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <div>
                                    <strong>Cookie Control:</strong> You can control cookies through your browser
                                    settings. However, disabling cookies may affect your ability to use certain features
                                    of our website.
                                </div>
                            </div>
                        </div>

                        <!-- Third-Party Sharing -->
                        <div class="privacy-section-item" id="third-party">
                            <h2><i class="fas fa-share-alt"></i> Third-Party Sharing</h2>
                            <p>We may share your information with third parties only in the following circumstances:</p>

                            <ul class="privacy-list">
                                <li><strong>Service Providers:</strong> We share information with companies that perform
                                    services on our behalf, such as payment processing, order fulfillment, data
                                    analysis, email delivery, and customer service</li>
                                <li><strong>Business Transfers:</strong> If we are involved in a merger, acquisition, or
                                    sale of assets, your information may be transferred as part of that transaction</li>
                                <li><strong>Legal Requirements:</strong> We may disclose your information if required by
                                    law, court order, or governmental authority</li>
                                <li><strong>Consent:</strong> We may share your information with third parties when you
                                    have given us explicit consent to do so</li>
                            </ul>

                            <div class="warning-box">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Important:</strong> We do not sell, rent, or trade your personal information
                                    to third parties for their marketing purposes without your explicit consent.
                                </div>
                            </div>
                        </div>

                        <!-- Data Security -->
                        <div class="privacy-section-item" id="data-security">
                            <h2><i class="fas fa-lock"></i> Data Security</h2>
                            <p>We implement appropriate technical and organizational security measures to protect your
                                personal information against unauthorized access, alteration, disclosure, or
                                destruction.</p>

                            <h5>Security Measures Include:</h5>
                            <div class="security-grid">
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h6>SSL Encryption</h6>
                                    <p>All data transmitted between your browser and our servers is encrypted using SSL
                                        technology</p>
                                </div>
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-user-lock"></i>
                                    </div>
                                    <h6>Access Controls</h6>
                                    <p>Strict access controls ensure only authorized personnel can access your data</p>
                                </div>
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <h6>Secure Servers</h6>
                                    <p>Your data is stored on secure servers protected by firewalls and regular security
                                        audits</p>
                                </div>
                                <div class="security-item">
                                    <div class="security-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <h6>PCI Compliance</h6>
                                    <p>Payment processing meets PCI-DSS security standards</p>
                                </div>
                            </div>

                            <p class="mt-4">However, please note that no method of transmission over the Internet or
                                electronic storage is 100% secure. While we strive to protect your personal information,
                                we cannot guarantee its absolute security.</p>
                        </div>

                        <!-- User Rights -->
                        <div class="privacy-section-item" id="user-rights">
                            <h2><i class="fas fa-user-check"></i> Your Privacy Rights</h2>
                            <p>You have certain rights regarding your personal information. Depending on your location,
                                these rights may include:</p>

                            <div class="rights-grid">
                                <div class="rights-card">
                                    <i class="fas fa-eye"></i>
                                    <h6>Access</h6>
                                    <p>Request access to your personal data we hold</p>
                                </div>
                                <div class="rights-card">
                                    <i class="fas fa-edit"></i>
                                    <h6>Correction</h6>
                                    <p>Request correction of inaccurate or incomplete data</p>
                                </div>
                                <div class="rights-card">
                                    <i class="fas fa-trash-alt"></i>
                                    <h6>Deletion</h6>
                                    <p>Request deletion of your personal information</p>
                                </div>
                                <div class="rights-card">
                                    <i class="fas fa-ban"></i>
                                    <h6>Opt-Out</h6>
                                    <p>Opt-out of marketing communications</p>
                                </div>
                                <div class="rights-card">
                                    <i class="fas fa-file-download"></i>
                                    <h6>Portability</h6>
                                    <p>Request a copy of your data in a portable format</p>
                                </div>
                                <div class="rights-card">
                                    <i class="fas fa-hand-paper"></i>
                                    <h6>Restriction</h6>
                                    <p>Request restriction of processing your data</p>
                                </div>
                            </div>

                            <p class="mt-4">To exercise any of these rights, please contact us using the information
                                provided at the end of this policy. We will respond to your request within 30 days.</p>
                        </div>

                        <!-- Children's Privacy -->
                        <div class="privacy-section-item" id="children">
                            <h2><i class="fas fa-child"></i> Children's Privacy</h2>
                            <p>Our website is not intended for children under the age of 13. We do not knowingly collect
                                personal information from children under 13. If you are a parent or guardian and believe
                                your child has provided us with personal information, please contact us immediately.</p>
                            <p>If we discover that we have collected personal information from a child under 13, we will
                                take steps to delete that information as quickly as possible.</p>
                        </div>

                        <!-- Changes to Policy -->
                        <div class="privacy-section-item" id="changes">
                            <h2><i class="fas fa-sync-alt"></i> Changes to This Privacy Policy</h2>
                            <p>We may update our Privacy Policy from time to time to reflect changes in our practices or
                                for other operational, legal, or regulatory reasons. We will notify you of any material
                                changes by:</p>
                            <ul class="privacy-list">
                                <li>Posting the new Privacy Policy on this page</li>
                                <li>Updating the "Last Updated" date at the top of this policy</li>
                                <li>Sending you an email notification (if you have an account with us)</li>
                            </ul>
                            <p>We encourage you to review this Privacy Policy periodically to stay informed about how we
                                are protecting your information.</p>
                        </div>

                        <!-- Contact -->
                        <div class="privacy-section-item" id="contact-privacy">
                            <h2><i class="fas fa-envelope"></i> Contact Us</h2>
                            <p>If you have any questions, concerns, or requests regarding this Privacy Policy or our
                                data practices, please contact us:</p>

                            <div class="contact-info-box">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <strong>Privacy Email:</strong>
                                        <a href="mailto:privacy@fashionhub.com">privacy@fashionhub.com</a>
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
                                        <strong>Mailing Address:</strong>
                                        FashionHub Privacy Department<br>
                                        123 Fashion Street<br>
                                        New York, NY 10001
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Commitment Notice -->
                        <div class="commitment-notice">
                            <i class="fas fa-heart"></i>
                            <div>
                                <h5>Our Privacy Commitment</h5>
                                <p>At FashionHub, we are committed to transparency and protecting your privacy. Your
                                    trust is important to us, and we continuously work to ensure your data is handled
                                    responsibly and securely.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <!-- Smooth Scroll Script -->
        <script>
            document.querySelectorAll('.privacy-nav a').forEach(anchor => {
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
                document.querySelectorAll('.privacy-section-item').forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                document.querySelectorAll('.privacy-nav a').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            });
        </script>
    @endpush
</x-app>
