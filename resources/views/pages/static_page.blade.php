<x-app>
    @push('meta')
        <title>{{ $page->meta_title ?: $page->title }}</title>
        @if ($page->meta_description)
            <meta name="description" content="{{ $page->meta_description }}">
        @endif
    @endpush

    <section class="py-5" style="background:linear-gradient(135deg,#efe2d7,#f8f4ef);">
        <div class="container text-center py-4">
            <span class="badge rounded-pill text-bg-light mb-3">Information</span>
            <h1 class="display-5 fw-bold">{{ $page->title }}</h1>
            @if ($page->meta_description)
                <p class="text-muted col-lg-7 mx-auto mb-0">{{ $page->meta_description }}</p>
            @endif
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="cms-content">{!! $safeContent !!}</div>
                </div>
            </div>
        </div>
    </section>
</x-app>
