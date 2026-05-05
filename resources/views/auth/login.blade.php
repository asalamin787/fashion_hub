<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    @endpush
    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-container">
                        <div class="row g-0">
                            <!-- Left Side - Image/Illustration -->
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="login-image">
                                    <div class="login-image-overlay">
                                        <div class="login-image-content">
                                            <h2>Welcome Back!</h2>
                                            <p>Sign in to access your account and continue your fashion journey with us.
                                            </p>
                                            <div class="login-features">
                                                <div class="feature-item">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Exclusive Offers</span>
                                                </div>
                                                <div class="feature-item">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Fast Checkout</span>
                                                </div>
                                                <div class="feature-item">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Order Tracking</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Login Form -->
                            <div class="col-lg-6">
                                <div class="login-form-wrapper">
                                    <div class="login-form-header">
                                        <h2>Login to Your Account</h2>
                                        <p>Enter your credentials to access your account</p>
                                    </div>

                                    <form class="login-form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <!-- Email Input -->
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
                                                placeholder="Enter your email"
                                                required
                                                autocomplete="email"
                                                autofocus
                                            >
                                            @error('email')
                                                <span class="invalid-feedback d-block mt-2" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Password Input -->
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
                                                    placeholder="Enter your password"
                                                    required
                                                    autocomplete="current-password"
                                                >
                                                <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block mt-2" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Remember Me & Forgot Password -->
                                        <div class="form-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rememberMe">
                                                    Remember me
                                                </label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                                            @endif
                                        </div>

                                        <!-- Login Button -->
                                        <button type="submit" class="btn btn-primary w-100 login-btn">
                                            <i class="fas fa-sign-in-alt"></i> Login
                                        </button>

                                        <!-- Social Login Divider -->
                                        <div class="social-divider">
                                            <span>Or continue with</span>
                                        </div>

                                        <!-- Social Login Buttons -->
                                        <div class="social-login">
                                            <button type="button" class="btn social-btn google-btn">
                                                <i class="fab fa-google"></i> Google
                                            </button>
                                            <button type="button" class="btn social-btn facebook-btn">
                                                <i class="fab fa-facebook-f"></i> Facebook
                                            </button>
                                        </div>

                                        <!-- Register Link -->
                                        <div class="register-link">
                                            Don't have an account? <a href="{{ route('register') }}">Create Account</a>
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
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon');

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
