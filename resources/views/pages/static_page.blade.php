<x-app>
    @push('meta')
        <title>{{ $page->meta_title ?: $page->title }}</title>
        @if ($page->meta_description)
            <meta name="description" content="{{ $page->meta_description }}">
        @endif
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>{{ $page->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
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
