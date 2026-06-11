@extends('panel_control/partials.master')

@section('title', __('messages.My Favorites'))

@section('main-content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('messages.My Favorites') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('dashboard') }}">
                            {{ __('messages.Dashboard') }}
                        </a>
                    </div>
                    <div class="breadcrumb-item">
                        {{ __('messages.Favorites') }}
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.Favorite Movies') }}</h4>
                            </div>

                            <div class="card-body">
                                <div id="favorites-content">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const favoritesStorageKey = 'omdb_favorites';
        const initialFavorites = @json(session('favorites', []));

        function loadFavorites() {
            try {
                const storedFavorites = localStorage.getItem(favoritesStorageKey);

                if (storedFavorites !== null) {
                    const parsedFavorites = JSON.parse(storedFavorites);
                    return parsedFavorites && typeof parsedFavorites === 'object' && !Array.isArray(parsedFavorites)
                        ? parsedFavorites
                        : {};
                }

                if (initialFavorites && Object.keys(initialFavorites).length) {
                    localStorage.setItem(favoritesStorageKey, JSON.stringify(initialFavorites));
                    return initialFavorites;
                }
            } catch (error) {
                console.error('Failed to load favorites', error);
            }

            return {};
        }

        function saveFavorites(favorites) {
            localStorage.setItem(favoritesStorageKey, JSON.stringify(favorites));
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(character) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[character];
            });
        }

        function renderEmptyState(container) {
            container.html(`
                <div class="text-center py-5">
                    <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">{{ __('messages.No favorites yet') }}</h5>
                    <p class="text-muted">{{ __('messages.Start adding movies to your favorites list!') }}</p>
                    <a href="{{ route('movies') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-search"></i>
                        {{ __('messages.find your favorite movie') }}
                    </a>
                </div>
            `);
        }

        function renderFavorites() {
            const container = $('#favorites-content');
            const favorites = loadFavorites();
            const movies = Object.values(favorites);

            if (!movies.length) {
                renderEmptyState(container);
                return;
            }

            const rows = movies.map((movie) => `
                <tr data-imdb="${movie.imdbID}">
                    <td class="align-middle">
                        <img src="${escapeHtml(movie.poster)}" alt="${escapeHtml(movie.title)}" class="rounded" width="50" height="70" style="object-fit: cover">
                    </td>
                    <td class="align-middle">${escapeHtml(movie.title)}</td>
                    <td class="align-middle">${escapeHtml(movie.year)}</td>
                    <td class="align-middle">
                        <div class="badge badge-primary text-capitalize">${escapeHtml(movie.type)}</div>
                    </td>
                    <td class="align-middle action-buttons" style="white-space: nowrap;">
                        <a href="/movies/${encodeURIComponent(movie.imdbID)}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                            {{ __('messages.Detail') }}
                        </a>
                        <button type="button"
                            class="btn btn-sm favorite-btn"
                            style="background-color: #dc3545; color: #fff; border: 1px solid #dc3545;"
                            data-imdb="${escapeHtml(movie.imdbID)}">
                            <i class="fas fa-trash-alt"></i>
                            <span class="ml-1">{{ __('messages.Remove') }}</span>
                        </button>
                    </td>
                </tr>
            `).join('');

            container.html(`
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('messages.Poster') }}</th>
                                <th>{{ __('messages.Title') }}</th>
                                <th>{{ __('messages.Year') }}</th>
                                <th>{{ __('messages.Type') }}</th>
                                <th>{{ __('messages.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="favorites-table">${rows}</tbody>
                    </table>
                </div>
            `);
        }

        function removeFavorite(imdbID) {
            const favorites = loadFavorites();
            delete favorites[imdbID];
            saveFavorites(favorites);
            renderFavorites();

            Swal.fire({
                text: '{{ __('messages.favorite_removed') }}',
                icon: 'info',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }

        $(document).ready(function() {
            renderFavorites();

            $(document).on('click', '.favorite-btn', function() {
                removeFavorite($(this).data('imdb'));
            });
        });
    </script>
@endpush
