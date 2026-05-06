<!-- Search Modal -->
<div id="searchModal" class="search-modal" role="dialog" aria-labelledby="searchModalTitle" aria-hidden="true">
    <div class="search-modal-overlay" id="searchModalOverlay"></div>
    <div class="search-modal-content">
        <button type="button" class="search-modal-close" id="searchModalClose" aria-label="Close search">
            <i class="fas fa-times"></i>
        </button>

        <div class="search-modal-inner">
            <h2 id="searchModalTitle" class="search-modal-title">Search Products</h2>

            <form id="searchForm" class="search-form" action="{{ route('shop') }}" method="GET">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-input-icon"></i>
                    <input
                        type="text"
                        id="searchInput"
                        name="q"
                        class="search-input"
                        placeholder="Search for products, brands, styles..."
                        autocomplete="off"
                        spellcheck="false"
                    >
                    <div id="searchLoading" class="search-input-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>

                <!-- Search Results Container -->
                <div id="searchResultsContainer" style="display: none; margin-top: 16px;">
                    <!-- Exact Matches Section -->
                    <div id="exactMatchesSection" class="search-results-section" style="display: none;">
                        <div class="search-results-section-title">Best Matches</div>
                        <div id="exactMatchesList" class="search-results-list"></div>
                    </div>

                    <!-- Related Products Section -->
                    <div id="relatedProductsSection" class="search-results-section" style="display: none;">
                        <div class="search-results-section-title">Related Products</div>
                        <div id="relatedProductsList" class="search-results-list"></div>
                    </div>

                    <!-- Popular Products Section -->
                    <div id="popularProductsSection" class="search-results-section" style="display: none;">
                        <div class="search-results-section-title">Popular Products</div>
                        <div id="popularProductsList" class="search-results-list"></div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="empty-state-text">No products found. Try different keywords.</div>
                    </div>
                </div>

                <!-- Recent Searches -->
                <div id="recentSearches" class="recent-searches"></div>
            </form>
        </div>
    </div>
</div>

<style>
    .search-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .search-modal.active {
        display: flex;
    }

    .search-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        animation: overlayFadeIn 0.25s ease;
    }

    .search-modal.active .search-modal-overlay {
        cursor: pointer;
    }

    .search-modal-content {
        position: relative;
        width: 90%;
        max-width: 600px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(63, 34, 26, 0.25);
        animation: modalSlideIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-height: 80vh;
        display: flex;
        flex-direction: column;
    }

    .search-modal.closing .search-modal-content {
        animation: modalSlideOut 0.25s ease forwards;
    }

    .search-modal.closing .search-modal-overlay {
        animation: overlayFadeOut 0.25s ease forwards;
    }

    .search-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 40px;
        height: 40px;
        border: none;
        background: rgba(134, 87, 73, 0.1);
        color: #865749;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.2s ease;
        z-index: 2;
    }

    .search-modal-close:hover {
        background: rgba(134, 87, 73, 0.2);
        color: #6d3f35;
    }

    .search-modal-close:active {
        transform: scale(0.95);
    }

    .search-modal-inner {
        padding: 32px 24px;
        overflow-y: auto;
        flex: 1;
    }

    .search-modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #2b1f1a;
        margin: 0 0 24px 0;
        letter-spacing: -0.5px;
    }

    .search-form {
        position: relative;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input-icon {
        position: absolute;
        left: 16px;
        color: #865749;
        font-size: 16px;
        pointer-events: none;
    }

    .search-input-loader {
        position: absolute;
        right: 16px;
        color: #865749;
        font-size: 16px;
        animation: spin 1s linear infinite;
    }

    .search-input {
        width: 100%;
        padding: 14px 16px 14px 44px;
        font-size: 16px;
        border: 2px solid #e5ddd8;
        border-radius: 12px;
        background: #f9f7f5;
        color: #2b1f1a;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .search-input:focus {
        outline: none;
        border-color: #865749;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(134, 87, 73, 0.1);
    }

    .search-input::placeholder {
        color: #a89a92;
    }

    /* Search Results Sections */
    .search-results-section {
        margin-bottom: 20px;
    }

    .search-results-section:last-child {
        margin-bottom: 0;
    }

    .search-results-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #8b7a71;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        padding: 0 2px;
    }

    .search-results-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .search-result-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        background: #f9f7f5;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .search-result-item:hover {
        background: rgba(134, 87, 73, 0.08);
        transform: translateX(4px);
    }

    .search-result-image {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: #e5ddd8;
        overflow: hidden;
        object-fit: cover;
    }

    .search-result-content {
        flex: 1;
        min-width: 0;
    }

    .search-result-name {
        font-weight: 600;
        color: #2b1f1a;
        font-size: 14px;
        margin-bottom: 4px;
        line-height: 1.3;
        word-break: break-word;
    }

    .search-result-name .highlight {
        background: rgba(134, 87, 73, 0.25);
        padding: 0 2px;
        border-radius: 2px;
        font-weight: 700;
    }

    .search-result-meta {
        font-size: 12px;
        color: #8b7a71;
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .search-result-price {
        font-weight: 600;
        color: #865749;
        font-size: 13px;
        margin-left: auto;
        white-space: nowrap;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 32px 24px;
        color: #8b7a71;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.4;
    }

    .empty-state-text {
        font-size: 14px;
    }

    /* Recent Searches */
    .recent-searches {
        margin-top: 24px;
    }

    .recent-searches-title {
        font-size: 12px;
        font-weight: 700;
        color: #8b7a71;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .recent-searches-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .recent-search-tag {
        padding: 8px 14px;
        background: rgba(134, 87, 73, 0.1);
        color: #865749;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid rgba(134, 87, 73, 0.2);
    }

    .recent-search-tag:hover {
        background: rgba(134, 87, 73, 0.2);
        border-color: rgba(134, 87, 73, 0.3);
    }

    @keyframes overlayFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes overlayFadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes modalSlideOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        to {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @media (max-width: 576px) {
        .search-modal-inner {
            padding: 24px 16px;
        }

        .search-modal-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .search-input {
            font-size: 16px;
        }

        .search-result-item {
            padding: 10px;
        }

        .search-result-image {
            width: 50px;
            height: 50px;
        }

        .search-result-name {
            font-size: 13px;
        }

        .search-result-meta {
            font-size: 11px;
        }
    }
</style>

<script>
    (function() {
        const modal = document.getElementById('searchModal');
        const overlay = document.getElementById('searchModalOverlay');
        const closeBtn = document.getElementById('searchModalClose');
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const recentSearchesContainer = document.getElementById('recentSearches');
        const searchLoading = document.getElementById('searchLoading');
        const searchResultsContainer = document.getElementById('searchResultsContainer');

        // Debounce utility
        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => func(...args), delay);
            };
        }

        // Highlight matched text
        function highlightMatch(text, query) {
            if (!query || query.length < 2) return text;
            const regex = new RegExp(`(${query.split(' ').join('|')})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        // Format product item HTML
        function formatProductItem(product, query) {
            const highlighted = highlightMatch(product.name, query);
            const meta = [product.category, product.brand].filter(Boolean).join(' • ');

            return `
                <a href="/products/${product.slug}" class="search-result-item" title="${product.name}">
                    <img src="${product.image}" alt="${product.name}" class="search-result-image">
                    <div class="search-result-content">
                        <div class="search-result-name">${highlighted}</div>
                        ${meta ? `<div class="search-result-meta">${meta}</div>` : ''}
                    </div>
                    <div class="search-result-price">$${product.price}</div>
                </a>
            `;
        }

        // Render search results
        function renderResults(data, query) {
            const { exact_matches, related_products, popular_products } = data.results;
            const hasAnyResults = exact_matches.length > 0 || related_products.length > 0 || popular_products.length > 0;

            // Show/hide container
            if (hasAnyResults) {
                searchResultsContainer.style.display = 'block';
                recentSearchesContainer.style.display = 'none';
            } else {
                searchResultsContainer.style.display = 'block';
                recentSearchesContainer.style.display = 'none';
            }

            // Render exact matches
            if (exact_matches.length > 0) {
                const section = document.getElementById('exactMatchesSection');
                const list = document.getElementById('exactMatchesList');
                section.style.display = 'block';
                list.innerHTML = exact_matches
                    .map(p => formatProductItem(p, query))
                    .join('');
            } else {
                document.getElementById('exactMatchesSection').style.display = 'none';
            }

            // Render related products
            if (related_products.length > 0) {
                const section = document.getElementById('relatedProductsSection');
                const list = document.getElementById('relatedProductsList');
                section.style.display = 'block';
                list.innerHTML = related_products
                    .map(p => formatProductItem(p, query))
                    .join('');
            } else {
                document.getElementById('relatedProductsSection').style.display = 'none';
            }

            // Render popular products
            if (popular_products.length > 0) {
                const section = document.getElementById('popularProductsSection');
                const list = document.getElementById('popularProductsList');
                section.style.display = 'block';
                list.innerHTML = popular_products
                    .map(p => formatProductItem(p, query))
                    .join('');
            } else {
                document.getElementById('popularProductsSection').style.display = 'none';
            }

            // Show empty state
            if (!hasAnyResults) {
                document.getElementById('emptyState').style.display = 'block';
            } else {
                document.getElementById('emptyState').style.display = 'none';
            }
        }

        // Fetch products
        async function fetchProducts(query) {
            try {
                searchLoading.style.display = 'block';

                const response = await fetch('{{ route("search.products") }}?q=' + encodeURIComponent(query), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) throw new Error('Search failed');
                const data = await response.json();

                renderResults(data, query);
            } catch (error) {
                console.error('Search error:', error);
                document.getElementById('emptyState').style.display = 'block';
                searchResultsContainer.style.display = 'block';
            } finally {
                searchLoading.style.display = 'none';
            }
        }

        // Debounced search
        const debouncedSearch = debounce(function(query) {
            if (query.length >= 2) {
                fetchProducts(query);
            } else {
                searchResultsContainer.style.display = 'none';
                recentSearchesContainer.style.display = 'block';
                renderRecentSearches(getStoredSearches());
            }
        }, 350);

        // Get stored recent searches
        function getStoredSearches() {
            const stored = localStorage.getItem('recentSearches');
            return stored ? JSON.parse(stored) : [];
        }

        // Render recent searches
        function renderRecentSearches(searches) {
            if (searches.length === 0) {
                recentSearchesContainer.innerHTML = '';
                return;
            }

            recentSearchesContainer.innerHTML = `
                <div class="recent-searches-title">Recent Searches</div>
                <div class="recent-searches-list">
                    ${searches
                        .slice(0, 6)
                        .map(
                            (search) => `
                        <button type="button" class="recent-search-tag" data-search="${search}">
                            ${search}
                        </button>
                    `
                        )
                        .join('')}
                </div>
            `;

            document.querySelectorAll('.recent-search-tag').forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchInput.value = btn.dataset.search;
                    debouncedSearch(btn.dataset.search);
                });
            });
        }

        // Input handler
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            debouncedSearch(query);
        });

        // Modal control functions
        function openModal() {
            modal.classList.remove('closing');
            modal.classList.add('active');
            searchInput.focus();
            document.body.style.overflow = 'hidden';
            renderRecentSearches(getStoredSearches());
        }

        function closeModal() {
            modal.classList.add('closing');
            setTimeout(() => {
                modal.classList.remove('active', 'closing');
                document.body.style.overflow = '';
            }, 250);
        }

        // Event listeners
        document.querySelectorAll('a[data-search-toggle]').forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        });

        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Save search on form submit
        searchForm.addEventListener('submit', (e) => {
            const query = searchInput.value.trim();
            if (query) {
                const searches = getStoredSearches();
                const filtered = searches.filter((s) => s !== query);
                const updated = [query, ...filtered].slice(0, 10);
                localStorage.setItem('recentSearches', JSON.stringify(updated));
            }
        });

        // Prevent closing when clicking inside modal
        document.querySelector('.search-modal-content').addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Expose to global
        window.openSearchModal = openModal;
    })();
</script>
