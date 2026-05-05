<x-app>
    <section class="auth-shell" style="min-height:calc(100vh - 210px);background:linear-gradient(135deg,#f5ede7,#fffaf6);padding:84px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg" style="overflow:hidden;">
                        <div class="card-body p-4 p-lg-5">
                            <span class="badge rounded-pill text-bg-light mb-3">Set New Password</span>
                            <h1 class="h2 fw-bold mb-2">Create a fresh password</h1>
                            <p class="text-muted mb-4">Choose a strong new password to restore access to your FashionHub account.</p>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">New Password</label>
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <div class="form-text">Use at least 8 characters with mixed case, numbers, and symbols.</div>
                                    @error('password')
                                        <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
