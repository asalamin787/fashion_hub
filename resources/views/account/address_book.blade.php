<x-app>
    <section class="py-5" style="background:#f7f3ef;min-height:70vh;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">@include('account.partials.sidebar')</div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h1 class="h3 fw-bold mb-1">Address Book</h1>
                            <p class="text-muted mb-4">Manage your default billing and delivery address in one place.</p>
                            <form method="POST" action="{{ route('account.address.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-12"><label class="form-label">Street Address</label><input name="address" value="{{ old('address', $user->address) }}" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">City</label><input name="city" value="{{ old('city', $user->city) }}" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">Country</label><input name="country" value="{{ old('country', $user->country) }}" class="form-control" required></div>
                                </div>
                                <button class="btn btn-primary rounded-pill px-4 mt-4">Save address</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
