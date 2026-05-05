<x-app>
    <section class="py-5" style="background:#f7f3ef;min-height:70vh;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">@include('account.partials.sidebar')</div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h1 class="h3 fw-bold mb-1">Password Change</h1>
                            <p class="text-muted mb-4">Use a strong password with letters, numbers, and symbols to keep your account secure.</p>
                            <form method="POST" action="{{ route('account.security.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-12"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">New Password</label><input type="password" name="password" class="form-control" required><div class="form-text">Use at least 8 characters and mix cases, numbers, and symbols.</div></div>
                                    <div class="col-md-6"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
                                </div>
                                <button class="btn btn-primary rounded-pill px-4 mt-4">Update password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
