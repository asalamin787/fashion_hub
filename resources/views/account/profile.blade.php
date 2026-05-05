<x-app>
    @php [$firstName, $lastName] = array_pad(explode(' ', auth()->user()->name ?? '', 2), 2, ''); @endphp
    <section class="py-5" style="background:#f7f3ef;min-height:70vh;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">@include('account.partials.sidebar')</div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h1 class="h3 fw-bold mb-1">Profile Update</h1>
                            <p class="text-muted mb-4">Keep your account details current for faster checkout and order updates.</p>
                            <form method="POST" action="{{ route('account.profile.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" value="{{ old('first_name', $firstName) }}" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" value="{{ old('last_name', $lastName) }}" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></div>
                                    <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" value="{{ old('phone', $user->phone) }}" class="form-control"></div>
                                </div>
                                <button class="btn btn-primary rounded-pill px-4 mt-4">Save profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
