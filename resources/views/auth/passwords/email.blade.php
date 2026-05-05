<x-app>
    <section class="auth-shell" style="min-height:calc(100vh - 210px);background:linear-gradient(135deg,#f5ede7,#fffaf6);padding:84px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg" style="overflow:hidden;">
                        <div class="card-body p-4 p-lg-5">
                            <span class="badge rounded-pill text-bg-light mb-3">Password Recovery</span>
                            <h1 class="h2 fw-bold mb-2">Forgot your password?</h1>
                            <p class="text-muted mb-4">Enter your account email and we will send a secure link so you can set a new password.</p>

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3">Send Reset Link</button>
                            </form>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="text-decoration-none">Back to login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
