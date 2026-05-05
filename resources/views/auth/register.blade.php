<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    @endpush

    <!-- Register Section -->
    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="register-container">
                        <div class="row g-0">
                            <!-- Left Side - Image/Illustration -->
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="register-image">
                                    <div class="register-image-overlay">
                                        <div class="register-image-content">
                                            <h2>Join FashionHub</h2>
                                            <p>Create an account to unlock exclusive benefits and personalized shopping
                                                experiences.</p>
                                            <div class="register-benefits">
                                                <div class="benefit-item">
                                                    <i class="fas fa-gift"></i>
                                                    <div class="benefit-text">
                                                        <h6>Welcome Bonus</h6>
                                                        <span>Get 10% off your first order</span>
                                                    </div>
                                                </div>
                                                <div class="benefit-item">
                                                    <i class="fas fa-shipping-fast"></i>
                                                    <div class="benefit-text">
                                                        <h6>Free Shipping</h6>
                                                        <span>On orders above $50</span>
                                                    </div>
                                                </div>
                                                <div class="benefit-item">
                                                    <i class="fas fa-star"></i>
                                                    <div class="benefit-text">
                                                        <h6>Loyalty Rewards</h6>
                                                        <span>Earn points on every purchase</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Register Form -->
                            <div class="col-lg-7">
                                <div class="register-form-wrapper">
                                    <div class="register-form-header">
                                        <h2>Create Your Account</h2>
                                        <p>Fill in your details to get started</p>
                                    </div>

                                    <form class="register-form" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row">
                                            <!-- First Name -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name" class="form-label">
                                                        <i class="fas fa-user"></i> First Name
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        id="first_name"
                                                        name="first_name"
                                                        value="{{ old('first_name') }}"
                                                        placeholder="First name"
                                                        required
                                                        autocomplete="given-name"
                                                        autofocus
                                                    >
                                                    @error('first_name')
                                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name" class="form-label">
                                                        <i class="fas fa-user"></i> Last Name
                                                    </label>
                                                    <input
                                                        type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        id="last_name"
                                                        name="last_name"
                                                        value="{{ old('last_name') }}"
                                                        placeholder="Last name"
                                                        required
                                                        autocomplete="family-name"
                                                    >
                                                    @error('last_name')
                                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">
                                                        <i class="fas fa-envelope"></i> Email Address
                                                    </label>
                                                    <input
                                                        type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email"
                                                        name="email"
                                                        value="{{ old('email') }}"
                                                        placeholder="your.email@example.com"
                                                        required
                                                        autocomplete="email"
                                                    >
                                                    @error('email')
                                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Phone -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">
                                                        <i class="fas fa-phone"></i> Phone Number
                                                    </label>
                                                    <input
                                                        type="tel"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone"
                                                        name="phone"
                                                        value="{{ old('phone') }}"
                                                        placeholder="+1 234 567 8900"
                                                        autocomplete="tel"
                                                    >
                                                    @error('phone')
                                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">
                                                        <i class="fas fa-lock"></i> Password
                                                    </label>
                                                    <div class="password-input-wrapper">
                                                        <input
                                                            type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="password"
                                                            name="password"
                                                            placeholder="Create password"
                                                            required
                                                            autocomplete="new-password"
                                                        >
                                                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')" aria-label="Toggle password visibility">
                                                            <i class="fas fa-eye" id="toggleIcon1"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <small class="password-hint">Minimum 8 characters</small>
                                                </div>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="form-label">
                                                        <i class="fas fa-lock"></i> Confirm Password
                                                    </label>
                                                    <div class="password-input-wrapper">
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id="password_confirmation"
                                                            name="password_confirmation"
                                                            placeholder="Re-enter password"
                                                            required
                                                            autocomplete="new-password"
                                                        >
                                                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')" aria-label="Toggle confirm password visibility">
                                                            <i class="fas fa-eye" id="toggleIcon2"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Terms & Conditions -->
                                        <div class="form-check terms-check">
                                            <input
                                                class="form-check-input @error('terms') is-invalid @enderror"
                                                type="checkbox"
                                                id="termsConditions"
                                                name="terms"
                                                value="1"
                                                {{ old('terms') ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="form-check-label" for="termsConditions">
                                                I agree to the <a href="{{ route('terms.of.condition') }}" class="terms-link" target="_blank">Terms &amp; Conditions</a> and
                                                <a href="{{ route('privacy.policy') }}" class="terms-link" target="_blank">Privacy Policy</a>
                                            </label>
                                            @error('terms')
                                                <span class="invalid-feedback d-block mt-1" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Newsletter Subscription -->
                                        <div class="form-check newsletter-check">
                                            <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter" value="1" checked>
                                            <label class="form-check-label" for="newsletter">
                                                Subscribe to our newsletter for exclusive offers and updates
                                            </label>
                                        </div>

                                        <!-- Register Button -->
                                        <button type="submit" class="btn btn-primary w-100 register-btn">
                                            <i class="fas fa-user-plus"></i> Create Account
                                        </button>

                                        <!-- Social Register Divider -->
                                        <div class="social-divider">
                                            <span>Or register with</span>
                                        </div>

                                        <!-- Social Register Buttons -->
                                        <div class="social-register">
                                            <button type="button" class="btn social-btn google-btn">
                                                <i class="fab fa-google"></i> Google
                                            </button>
                                            <button type="button" class="btn social-btn facebook-btn">
                                                <i class="fab fa-facebook-f"></i> Facebook
                                            </button>
                                        </div>

                                        <!-- Login Link -->
                                        <div class="login-link">
                                            Already have an account? <a href="{{ route('login') }}">Sign In</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            function togglePassword(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const toggleIcon = document.getElementById(iconId);

                if (!passwordInput || !toggleIcon) {
                    return;
                }

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
</x-app>
