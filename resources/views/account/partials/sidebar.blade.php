<div class="account-sidebar card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:56px;height:56px;background:linear-gradient(135deg,#865749,#6d3f35);color:#fff;font-weight:700;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="fw-bold">{{ auth()->user()->name }}</div>
                <div class="text-muted small">{{ auth()->user()->email }}</div>
            </div>
        </div>

        <div
            class="list-group list-group-flush account-nav"
            style="--bs-list-group-active-bg: var(--primary-color); --bs-list-group-active-border-color: var(--primary-color);"
        >
            <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">Dashboard Overview</a>
            <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.orders*') ? 'active' : '' }}">My Orders</a>
            <a href="{{ route('account.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.profile') ? 'active' : '' }}">Profile Update</a>
            <a href="{{ route('account.address') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.address') ? 'active' : '' }}">Address Book</a>
            <a href="{{ route('account.security') }}" class="list-group-item list-group-item-action {{ request()->routeIs('account.security') ? 'active' : '' }}">Password Change</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn w-100 rounded-0" style="background:linear-gradient(135deg,#865749,#6d3f35);color:#fff;font-weight:600;">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
</div>
