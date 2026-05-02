<x-app>
    @push('css')
        <style>
            .auth-shell {
                min-height: calc(100vh - 210px);
                background:
                    radial-gradient(circle at 82% 14%, rgba(169, 109, 91, 0.25), transparent 18%),
                    radial-gradient(circle at 14% 82%, rgba(109, 63, 53, 0.14), transparent 22%),
                    linear-gradient(135deg, #f6eee8 0%, #efe4dc 46%, #fcf8f5 100%);
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

            .auth-copy {
                color: #7d655d;
                margin-bottom: 30px;
                max-width: 460px;
            }

            .auth-showcase {
                height: 100%;
                position: relative;
                padding: 54px 48px;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.06), transparent),
                    linear-gradient(160deg, #1f120f 0%, #5d332c 40%, #a96d5b 100%);
                color: #fff6ef;
            }

            .auth-showcase::after {
                content: '';
                position: absolute;
                bottom: 22px;
                right: 24px;
                width: 190px;
                height: 190px;
                border-radius: 32px;
                background: rgba(255, 255, 255, 0.08);
                transform: rotate(-16deg);
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
                margin: 24px 0 16px;
                font-size: clamp(2.3rem, 4vw, 3.8rem);
                line-height: 0.98;
                font-weight: 800;
                letter-spacing: -0.04em;
            }

            .auth-showcase p {
                color: rgba(255, 246, 239, 0.82);
                font-size: 15px;
                line-height: 1.84;
            }

            .auth-stat-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                margin-top: 38px;
            }

            .auth-stat {
                padding: 18px;
                border-radius: 24px;
                background: rgba(255, 255, 255, 0.07);
                border: 1px solid rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(10px);
            }

            .auth-stat strong {
                display: block;
                font-size: 1.7rem;
                margin-bottom: 6px;
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

            .auth-link {
                color: #7d655d;
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

                .auth-form-wrap,
                .auth-showcase {
                    padding: 32px 24px;
                }
            }
        </style>
    @endpush

    <section class="auth-shell">
        <div class="container">
            <div class="row g-0 auth-panel align-items-stretch">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="auth-form-wrap">
                        <div class="auth-mobile-banner d-lg-none">
                            <h3>Join the edit.</h3>
                            <p>Create your account and keep your style picks, orders, and wishlist in one home.</p>
                        </div>

                        <h2>{{ __('Create Account') }}</h2>
                        <p class="auth-copy">Create your FashionHub identity and turn every future visit into a faster, smarter, more personal shopping session.</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="auth-label">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control auth-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback d-block mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="auth-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback d-block mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="auth-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback d-block mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="auth-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control auth-input" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn w-100 auth-btn">
                                {{ __('Register') }}
                            </button>
                        </form>

                        <div class="auth-divider">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}" class="auth-link ms-2">Sign in</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2 d-none d-lg-block">
                    <div class="auth-showcase">
                        <div class="auth-kicker">
                            <i class="fas fa-sparkles"></i>
                            New Member
                        </div>
                        <h1>Build your own fashion profile in minutes.</h1>
                        <p>Create an account to unlock saved carts, handpicked edits, and a smoother shopping flow every time you return.</p>

                        <div class="auth-stat-grid">
                            <div class="auth-stat">
                                <strong>24/7</strong>
                                <span>Access to your orders and saved looks.</span>
                            </div>
                            <div class="auth-stat">
                                <strong>Fast</strong>
                                <span>Checkout with your profile details ready.</span>
                            </div>
                            <div class="auth-stat">
                                <strong>Secure</strong>
                                <span>Protected account space for your activity.</span>
                            </div>
                            <div class="auth-stat">
                                <strong>Personal</strong>
                                <span>Keep wishlists and preferences synced.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
