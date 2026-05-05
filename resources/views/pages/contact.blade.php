<x-app>
    @php
        $siteLinks = \App\Models\Setting::group('site');
    @endphp
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-info-cards">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4>Visit Us</h4>
                            <p>{{ $siteLinks->get('address') ?? '123 Fashion St, NY 10001' }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h4>Call Us</h4>
                            <p><a href="tel:{{ $siteLinks->get('phone') ?? '+1 (555) 123-4567' }}">{{ $siteLinks->get('phone') ?? '+1 (555) 123-4567' }}</a></p>
                            <p><a href="tel:{{ $siteLinks->get('phone_alt') ?? '+1 (555) 987-6543' }}">{{ $siteLinks->get('phone_alt') ?? '+1 (555) 987-6543' }}</a></p>
                            {{-- <p>Mon-Fri: 9AM - 6PM EST</p> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h4>Email Us</h4>
                            <p><a href="mailto:{{ $siteLinks->get('site-email') ?? 'info@fashionhub.com' }}">{{ $siteLinks->get('site-email') ?? 'info@fashionhub.com' }}</a></p>
                            <p><a href="mailto:{{ $siteLinks->get('support-email') ?? 'support@fashionhub.com' }}">{{ $siteLinks->get('support-email') ?? 'support@fashionhub.com' }}</a></p>
                            <p>We reply within 24 hours</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-form-section">
                        <h2 class="form-title">Send Us a Message</h2>
                        <form class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Your Name *</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Your Email *</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="map-section">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
</x-app>
