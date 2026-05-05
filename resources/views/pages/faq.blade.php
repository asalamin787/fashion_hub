<x-app>
    @push('meta')
        <title>{{ $metaTitle }}</title>
        <meta name="description" content="{{ $metaDescription }}">
    @endpush

    <section class="py-5" style="background:linear-gradient(135deg,#efe2d7,#f8f4ef);">
        <div class="container text-center py-4">
            <span class="badge rounded-pill text-bg-light mb-3">Support</span>
            <h1 class="display-5 fw-bold">Frequently Asked Questions</h1>
            <p class="text-muted col-lg-7 mx-auto mb-0">Clear answers about ordering, payments, shipping, returns, and how FashionHub works.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @forelse ($categories as $category)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h4 fw-bold mb-4">{{ $category->name }}</h2>
                        <div class="accordion" id="faq-{{ $category->id }}">
                            @foreach ($category->faqs as $faq)
                                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-item-{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                    <div id="faq-item-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faq-{{ $category->id }}">
                                        <div class="accordion-body">{!! nl2br(e($faq->answer)) !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm"><div class="card-body p-5 text-center"><h2 class="h5">FAQ content is coming soon</h2><p class="text-muted mb-0">Your most common shopping questions will appear here once they are published from the admin panel.</p></div></div>
            @endforelse
        </div>
    </section>
</x-app>
