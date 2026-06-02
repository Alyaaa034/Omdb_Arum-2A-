@extends('panel_control/partials.master')

@section('title', __('messages.All Movies'))

@section('main-content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('messages.Movies') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">{{ __('messages.Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('messages.Movies') }}</div>
                    <div class="breadcrumb-item">{{ __('messages.All Movies') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('messages.All Movies') }}</h4>
                            </div>

                            <div class="card-body">
                                {{-- Search Form --}}
                                <div class="float-right">
                                    <form method="GET" action="{{ url('/') }}/movies" id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="q" id="search-input" class="form-control"
                                                placeholder="{{ __('messages.search for movies') }}"
                                                value="{{ request('q') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                {{-- Tabel Movies --}}
                                <div class="table-responsive">
                                    <table class="table table-striped" id="movie-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.Poster') }}</th>
                                                <th>{{ __('messages.Title') }}</th>
                                                <th>{{ __('messages.Year') }}</th>
                                                <th>{{ __('messages.Type') }}</th>
                                                <th>{{ __('messages.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="movie-container">
                                            @forelse ($movies as $data)
                                                <tr data-imdb="{{ $data['imdbID'] }}">
                                                    <td class="align-middle">
                                                        <img src="{{ $data['Poster'] }}" alt="{{ $data['Title'] }}"
                                                            class="rounded" width="50" height="70"
                                                            style="object-fit: cover">
                                                    </td>
                                                    <td class="align-middle">{{ $data['Title'] }}</td>
                                                    <td class="align-middle">{{ $data['Year'] }}</td>
                                                    <td class="align-middle">
                                                        <div class="badge badge-primary text-capitalize">
                                                            {{ $data['Type'] }}
                                                        </div>
                                                    </td>
                                                    <td class="align-middle action-buttons" style="white-space: nowrap;">
                                                        {{-- Tombol Detail --}}
                                                        <a href="{{ route('movies.detail', ['imdbID' => $data['imdbID']]) }}?q={{ urlencode(request('q')) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> {{ __('messages.Detail') }}
                                                        </a>

                                                        {{-- Tombol Favorite (Love) --}}
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger favorite-btn"
                                                            data-imdb="{{ $data['imdbID'] }}"
                                                            data-title="{{ $data['Title'] }}"
                                                            data-poster="{{ $data['Poster'] }}"
                                                            data-year="{{ $data['Year'] }}"
                                                            data-type="{{ $data['Type'] }}">
                                                            <i class="@if(isset($favorites[$data['imdbID']])) fas @else far @endif fa-heart"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                @if (request('q'))
                                                    <tr id="empty-row">
                                                        <td colspan="5" class="text-center py-5">
                                                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                            <span class="text-muted">
                                                                {{ __('messages.Movie not found!') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr id="empty-row">
                                                        <td colspan="5" class="text-center py-5">
                                                            <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                            <span class="text-muted">
                                                                {{ __('messages.enter keywords to search for movies') }}
                                                            </span>
                                                        </td>
                                                    <tr>
                                                @endif
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Loader & No More --}}
                                <div id="loader" class="text-center py-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">{{ __('messages.Loading...') }}</span>
                                    </div>
                                    <p class="text-muted mt-2">{{ __('messages.Loading more movies...') }}</p>
                                </div>
                                <div id="no-more" class="text-center text-muted py-3" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('messages.All movies loaded.') }}
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
    let page = 1;
    let isLoading = false;
    let hasMore = true;
    const query = "{{ request('q') }}";

    // Daftar favorit dari server
    const favorites = {!! json_encode(array_keys($favorites)) !!};
    const favoritesMap = {};
    favorites.forEach(id => {
        favoritesMap[id] = true;
    });

    // Fungsi untuk menambah/menghapus favorit
    function toggleFavorite(btn) {
        let imdbID = btn.data('imdb');
        let title = btn.data('title');
        let poster = btn.data('poster');
        let year = btn.data('year');
        let type = btn.data('type');
        let icon = btn.find('i');

        // Cek apakah sudah favorit (icon solid)
        let isFavorited = icon.hasClass('fas');

        let url = isFavorited ? "{{ route('favorite.remove') }}" : "{{ route('favorite.add') }}";
        let method = isFavorited ? 'DELETE' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                _token: '{{ csrf_token() }}',
                imdbID: imdbID,
                title: title,
                poster: poster,
                year: year,
                type: type
            },
            success: function(response) {
                if (response.status === 'added') {
                    icon.removeClass('far').addClass('fas');
                    favoritesMap[imdbID] = true;
                    Swal.fire({
                        text: 'Film ditambahkan ke favorit',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (response.status === 'removed') {
                    icon.removeClass('fas').addClass('far');
                    delete favoritesMap[imdbID];
                    Swal.fire({
                        text: 'Film dihapus dari favorit',
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    Swal.fire({
                        text: 'Silakan login terlebih dahulu',
                        icon: 'warning',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        text: 'Terjadi kesalahan, coba lagi',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    // Fungsi untuk memuat movie tambahan (infinite scroll)
    function loadMovies() {
        if (isLoading || !hasMore || !query) return;

        isLoading = true;
        page++;

        $('#loader').show();
        $('#no-more').hide();

        $.ajax({
            url: "{{ route('movies') }}",
            method: 'GET',
            data: { q: query, page: page },
            success: function(response) {
                if (response.movies && response.movies.length > 0) {
                    response.movies.forEach(function(data) {
                        let heartIcon = favoritesMap[data.imdbID] ? 'fas' : 'far';
                        let newRow = `
                            <tr data-imdb="${data.imdbID}">
                                <td class="align-middle">
                                    <img src="${data.Poster}" alt="${data.Title}" class="rounded" width="50" height="70" style="object-fit: cover">
                                </td>
                                <td class="align-middle">${data.Title}</td>
                                <td class="align-middle">${data.Year}</td>
                                <td class="align-middle">
                                    <div class="badge badge-primary text-capitalize">${data.Type}</div>
                                </td>
                                <td class="align-middle action-buttons" style="white-space: nowrap;">
                                    <a href="/movies/${data.imdbID}?q=${encodeURIComponent(query)}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger favorite-btn"
                                        data-imdb="${data.imdbID}"
                                        data-title="${data.Title}"
                                        data-poster="${data.Poster}"
                                        data-year="${data.Year}"
                                        data-type="${data.Type}">
                                        <i class="${heartIcon} fa-heart"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        $('#movie-container').append(newRow);
                    });

                    // Attach event listener ke tombol favorite yang baru
                    $('.favorite-btn').off('click').on('click', function() {
                        toggleFavorite($(this));
                    });

                    const totalLoaded = page * 10;
                    if (totalLoaded >= response.total) {
                        hasMore = false;
                        $('#no-more').show();
                    }
                } else {
                    hasMore = false;
                    $('#no-more').show();
                }
            },
            error: function() {
                page--;
                hasMore = false;
            },
            complete: function() {
                isLoading = false;
                $('#loader').hide();
            }
        });
    }

    // Event listener untuk tombol favorite yang sudah ada di awal
    $(document).ready(function() {
        $('.favorite-btn').on('click', function() {
            toggleFavorite($(this));
        });
    });

    // Infinite scroll
    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            loadMovies();
        }
    });
</script>
@endpush
