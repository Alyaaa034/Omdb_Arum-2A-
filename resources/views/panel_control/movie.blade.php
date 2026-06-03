@extends('panel_control.partials.master')

@section('title', __('messages.All Movies'))

@section('main-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.Movies') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ __('messages.Dashboard') }}</a></div>
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
                            {{-- Search form --}}
                            <div class="float-right">
                                <form method="GET" action="{{ url('/movies') }}" id="search-form">
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

                            {{-- Movie table --}}
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
                                                        class="rounded" width="50" height="70" style="object-fit: cover">
                                                </td>
                                                <td class="align-middle">{{ $data['Title'] }}</td>
                                                <td class="align-middle">{{ $data['Year'] }}</td>
                                                <td class="align-middle">
                                                    <span class="badge badge-primary text-capitalize">{{ $data['Type'] }}</span>
                                                </td>
                                                <td class="align-middle action-buttons" style="white-space: nowrap;">
                                                    <a href="{{ route('movies.detail', ['imdbID' => $data['imdbID']]) }}?q={{ urlencode(request('q')) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> {{ __('messages.Detail') }}
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm favorite-btn"
                                                        style="background:#fff; color:#dc3545; border:1px solid #dc3545;"
                                                        data-imdb="{{ $data['imdbID'] }}"
                                                        data-title="{{ $data['Title'] }}"
                                                        data-poster="{{ $data['Poster'] }}"
                                                        data-year="{{ $data['Year'] }}"
                                                        data-type="{{ $data['Type'] }}">
                                                        <i class="{{ isset($favorites[$data['imdbID']]) ? 'fas' : 'far' }} fa-heart"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    @if (request('q'))
                                                        <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                        <span class="text-muted">{{ __('messages.Movie not found!') }}</span>
                                                    @else
                                                        <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                                        <span class="text-muted">{{ __('messages.enter keywords to search for movies') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Loader and end indicator --}}
                            <div id="loader" class="text-center py-3" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">{{ __('messages.Loading...') }}</span>
                                </div>
                                <p class="text-muted mt-2">{{ __('messages.Loading more movies...') }}</p>
                            </div>
                            <div id="no-more" class="text-center text-muted py-3" style="display: none;">
                                <i class="fas fa-check-circle"></i> {{ __('messages.All movies loaded.') }}
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
    // Data dari server
    let page = 1, isLoading = false, hasMore = true;
    const query = "{{ request('q') }}";
    const favoritesMap = {!! json_encode(array_keys($favorites ?? [])) !!}.reduce((map, id) => { map[id] = true; return map; }, {});

    // Toggle favorite via AJAX
    function toggleFavorite(btn) {
        let imdb = btn.data('imdb');
        let isFav = btn.find('i').hasClass('fas');
        let url = isFav ? "{{ route('favorite.remove') }}" : "{{ route('favorite.add') }}";
        let method = isFav ? 'DELETE' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                _token: '{{ csrf_token() }}',
                imdbID: imdb,
                title: btn.data('title'),
                poster: btn.data('poster'),
                year: btn.data('year'),
                type: btn.data('type')
            },
            success: function(res) {
                let icon = btn.find('i');
                if (res.status === 'added') {
                    icon.removeClass('far').addClass('fas');
                    favoritesMap[imdb] = true;
                } else if (res.status === 'removed') {
                    icon.removeClass('fas').addClass('far');
                    delete favoritesMap[imdb];
                }
                Swal.fire({ text: res.message, icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            },
            error: function(xhr) {
                Swal.fire({ text: xhr.status === 401 ? 'Silakan login dulu' : 'Terjadi kesalahan', icon: 'error', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            }
        });
    }

    // Load more movies (infinite scroll)
    function loadMore() {
        if (isLoading || !hasMore || !query) return;
        isLoading = true;
        page++;
        $('#loader').show();
        $('#no-more').hide();

        $.ajax({
            url: "{{ route('movies') }}",
            data: { q: query, page: page },
            success: function(res) {
                if (res.movies && res.movies.length) {
                    res.movies.forEach(m => {
                        let isFav = favoritesMap[m.imdbID];
                        let row = `
                            <tr data-imdb="${m.imdbID}">
                                <td class="align-middle"><img src="${m.Poster}" width="50" height="70" style="object-fit:cover"></td>
                                <td class="align-middle">${m.Title}</td>
                                <td class="align-middle">${m.Year}</td>
                                <td class="align-middle"><span class="badge badge-primary text-capitalize">${m.Type}</span></td>
                                <td class="align-middle action-buttons" style="white-space:nowrap">
                                    <a href="/movies/${m.imdbID}?q=${encodeURIComponent(query)}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                                    <button type="button" class="btn btn-sm favorite-btn" style="background:#fff; color:#dc3545; border:1px solid #dc3545;"
                                        data-imdb="${m.imdbID}" data-title="${m.Title}" data-poster="${m.Poster}" data-year="${m.Year}" data-type="${m.Type}">
                                        <i class="${isFav ? 'fas' : 'far'} fa-heart"></i>
                                    </button>
                                </td>
                            </tr>`;
                        $('#movie-container').append(row);
                    });
                    $('.favorite-btn').off('click').on('click', function() { toggleFavorite($(this)); });
                    if ((page * 10) >= res.total) { hasMore = false; $('#no-more').show(); }
                } else {
                    hasMore = false;
                    $('#no-more').show();
                }
            },
            error: function() { page--; hasMore = false; },
            complete: function() { isLoading = false; $('#loader').hide(); }
        });
    }

    // Event binding awal
    $(document).ready(function() {
        $('.favorite-btn').on('click', function() { toggleFavorite($(this)); });
        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) loadMore();
        });
    });
</script>
@endpush
