<x-app>
    @push('css')
        <style>
            .auth-shell {
                min-height: calc(100vh - 210px);
                background:
                    radial-gradient(circle at 12% 18%, rgba(219, 168, 131, 0.28), transparent 20%),
                    radial-gradient(circle at 88% 22%, rgba(123, 79, 66, 0.2), transparent 24%),
                    linear-gradient(135deg, #f4ece6 0%, #efe2d7 46%, #f9f4ef 100%);
                padding: 84px 0;
            }

            .auth-panel {
                background: rgba(255, 251, 247, 0.94);
                border: 1px solid rgba(109, 63, 53, 0.12);
                border-radius: 32px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(74, 42, 33, 0.14);
                backdrop-filter: blur(18px);
            }

            .auth-showcase {
                position: relative;
                height: 100%;
                padding: 54px 48px;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent),
                    linear-gradient(155deg, #2b1712 0%, #5d332c 42%, #9a6655 100%);
                color: #fff7f0;
            }

            .auth-showcase::after {
                content: '';
                position: absolute;
                inset: auto -30px 24px auto;
                width: 170px;
                height: 170px;
                border-radius: 28px;
                background: rgba(255, 255, 255, 0.08);
                transform: rotate(22deg);
            }

            .auth-showcase::before {
                content: '';
                position: absolute;
                top: 26px;
                right: 26px;
                width: 88px;
                height: 88px;
                border-radius: 50%;
                border: 1px solid rgba(255, 255, 255, 0.16);
            }

            .auth-kicker {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.1);
                font-size: 13px;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .auth-showcase h1 {
                margin: 24px 0 18px;
                font-size: clamp(2.35rem, 4vw, 4rem);
                line-height: 0.98;
                font-weight: 800;
                letter-spacing: -0.04em;
            }

            .auth-showcase p {
                max-width: 420px;
                color: rgba(255, 247, 240, 0.82);
                font-size: 15px;
                line-height: 1.85;
            }

            .auth-highlights {
                display: grid;
                gap: 14px;
                margin-top: 38px;
            }

            .auth-highlight {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 14px 16px;
                border-radius: 22px;
                background: rgba(255, 255, 255, 0.07);
                border: 1px solid rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(10px);
            }

            .auth-highlight i {
                width: 42px;
                height: 42px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 16px;
                background: rgba(255, 255, 255, 0.14);
            }

            .auth-form-wrap {
                padding: 54px 48px;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.56), rgba(255, 255, 255, 0.84)),
                    #fffdfb;
            }

            .auth-form-wrap h2 {
                color: #2e1c17;
                font-size: 2.4rem;
                font-weight: 800;
                margin-bottom: 10px;
                letter-spacing: -0.04em;
            }

            .auth-form-wrap .auth-copy {
                color: #7d655d;
                margin-bottom: 30px;
                max-width: 460px;
            }

            .auth-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: #4e342d;
            }

            .auth-input {
                height: 54px;
                border-radius: 18px;
                border: 1px solid #e8d7cf;
                background: rgba(255, 255, 255, 0.95);
                padding: 0 16px;
                transition: border-color .2s ease, box-shadow .2s ease;
            }

            .auth-input:focus {
                border-color: #865749;
                box-shadow: 0 0 0 0.24rem rgba(134, 87, 73, 0.12);
            }

            .auth-btn {
                height: 58px;
                border: 0;
                border-radius: 20px;
                background: linear-gradient(135deg, #a96d5b 0%, #7b4f42 48%, #4b2a23 100%);
                color: #fff;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                box-shadow: 0 18px 36px rgba(134, 87, 73, 0.24);
            }

            .auth-btn:hover {
                color: #fff;
                background: linear-gradient(135deg, #966150 0%, #673d34 48%, #3d221c 100%);
            }

            .auth-link,
            .auth-form-wrap .form-check-label {
                color: #7d655d;
            }

            .auth-link {
                text-decoration: none;
                font-weight: 600;
            }

            .auth-link:hover {
                color: #865749;
            }

            .auth-divider {
                margin-top: 28px;
                padding-top: 22px;
                border-top: 1px solid #f0e3dc;
                color: #7d655d;
                text-align: center;
            }

            .auth-mobile-banner {
                margin-bottom: 24px;
                padding: 18px 20px;
                border-radius: 22px;
                background: linear-gradient(135deg, #2f1a15 0%, #865749 100%);
                color: #fff7f0;
            }

            .auth-mobile-banner h3 {
                margin: 0 0 8px;
                font-size: 1.65rem;
                font-weight: 800;
            }

            .auth-mobile-banner p {
                margin: 0;
                color: rgba(255, 247, 240, 0.8);
                font-size: 14px;
            }

            @media (max-width: 991.98px) {
                .auth-shell {
                    padding: 36px 0 54px;
                }

                .auth-showcase,
                .auth-form-wrap {
                    padding: 32px 24px;
                }
            }
        </style>
    @endpush

    <section class="auth-shell">
        <div class="container">
            <div class="row g-0 auth-panel align-items-stretch">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="auth-showcase">
                        <div class="auth-kicker">
                            <i class="fas fa-lock"></i>
                            Member Access
                        </div>
                        <h1>Welcome back to your curated wardrobe.</h1>
                        <p>Sign in to track orders, save favorites, manage your cart, and keep your style picks synced across every visit.</p>

                        <div class="auth-highlights">
                            <div class="auth-highlight">
                                <i class="fas fa-heart"></i>
                                <div>
                                    <strong class="d-block mb-1">Your wishlist stays ready</strong>
                                    <span>Revisit saved looks and seasonal edits in one place.</span>
                                </div>
                            </div>
                            <div class="auth-highlight">
                                <i class="fas fa-bag-shopping"></i>
                                <div>
                                    <strong class="d-block mb-1">Faster checkout</strong>
                                    <span>Keep your account details ready for your next order.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="auth-form-wrap">
                        <div class="auth-mobile-banner d-lg-none">
                            <h3>Style starts here.</h3>
                            <p>Access saved favorites, orders, and a smoother checkout in one place.</p>
                        </div>

                        <h2>{{ __('Login') }}</h2>
                        <p class="auth-copy">Step into your FashionHub profile and pick up exactly where your wardrobe journey left off.</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="auth-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="auth-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback d-block mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="auth-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn w-100 auth-btn">
                                {{ __('Login') }}
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>New to FashionHub?</span>
                            <a href="{{ route('register') }}" class="auth-link ms-2">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
