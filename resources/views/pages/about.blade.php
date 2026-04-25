<x-app>
    @push('meta')
        <title>{{ $aboutPage->hero_title ?: 'About Us' }} | FashionHub</title>
        <meta name="description" content="{{ \Illuminate\Support\Str::limit((string) ($aboutPage->hero_subtitle ?? 'Learn more about FashionHub, our story, values, and team.'), 160) }}">
        <meta name="keywords" content="about fashionhub, fashion brand story, fashion team, fashion values">
        <meta property="og:title" content="{{ $aboutPage->hero_title ?: 'About Us' }} | FashionHub">
        <meta property="og:description" content="{{ \Illuminate\Support\Str::limit((string) ($aboutPage->hero_subtitle ?? 'Learn more about FashionHub, our story, values, and team.'), 160) }}">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="{{ $aboutPage->hero_title ?: 'About Us' }} | FashionHub">
        <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit((string) ($aboutPage->hero_subtitle ?? 'Learn more about FashionHub, our story, values, and team.'), 160) }}">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
    @endpush
    
    <section class="about-hero">
        <div class="container">
            <h1>{{ $aboutPage->hero_title }}</h1>
            <p>{{ $aboutPage->hero_subtitle }}</p>
        </div>
    </section>

    <section class="story-section">
        <div class="container">
            <div class="story-content">
                <div class="story-image">
                    <img src="{{ $aboutPage->story_image_url }}" alt="{{ $aboutPage->story_title }}">
                </div>
                <div class="story-text">
                    <h2>{{ $aboutPage->story_title }}</h2>
                    @foreach ($storyParagraphs as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <div class="section-title">
                <h2>{{ $aboutPage->values_title }}</h2>
                <p>{{ $aboutPage->values_subtitle }}</p>
            </div>
            <div class="row">
                @foreach (($aboutPage->values_items ?? []) as $valueItem)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="value-card">
                            <div class="value-icon">
                                <i class="{{ $valueItem['icon'] ?? 'fas fa-star' }}"></i>
                            </div>
                            <h4>{{ $valueItem['title'] ?? '' }}</h4>
                            <p>{{ $valueItem['description'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="section-title">
                <h2>{{ $aboutPage->team_title }}</h2>
                <p>{{ $aboutPage->team_subtitle }}</p>
            </div>
            <div class="row">
                @foreach (($aboutPage->team_members ?? []) as $member)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="team-member">
                            <div class="team-image">
                                <img src="{{ $member['image'] ?? '' }}" alt="{{ $member['name'] ?? 'Team Member' }}">
                                <div class="team-overlay">
                                    <div class="team-social">
                                        <a href="{{ $member['linkedin'] ?? '#' }}"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="{{ $member['twitter'] ?? '#' }}"><i class="fab fa-twitter"></i></a>
                                        <a href="{{ $member['instagram'] ?? '#' }}"><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-info">
                                <h4>{{ $member['name'] ?? '' }}</h4>
                                <p>{{ $member['role'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row">
                @foreach (($aboutPage->stats_items ?? []) as $stat)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $stat['value'] ?? '' }}</div>
                            <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app>