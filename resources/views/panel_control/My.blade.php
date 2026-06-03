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
                                    @php
                                        $favorites = session('favorites', []);
                                    @endphp

                                    @if (empty($favorites))
                                        <div class="text-center py-5">
                                            <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>

                                            <h5 class="text-muted">
                                                {{ __('messages.No favorites yet') }}
                                            </h5>

                                            <p class="text-muted">
                                                {{ __('messages.Start adding movies to your favorites list!') }}
                                            </p>

                                            <a href="{{ route('movies') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-search"></i>
                                                {{ __('messages.find your favorite movie') }}
                                            </a>
                                        </div>
                                    @else
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
                                                <tbody id="favorites-table">
                                                    @foreach ($favorites as $movie)
                                                        <tr data-imdb="{{ $movie['imdbID'] }}">
                                                            <td class="align-middle">
                                                                <img src="{{ $movie['poster'] }}"
                                                                    alt="{{ $movie['title'] }}"
                                                                    class="rounded" width="50" height="70"
                                                                    style="object-fit: cover">
                                                            </td>
                                                            <td class="align-middle">{{ $movie['title'] }}</td>
                                                            <td class="align-middle">{{ $movie['year'] }}</td>
                                                            <td class="align-middle">
                                                                <div class="badge badge-primary text-capitalize">
                                                                    {{ $movie['type'] }}
                                                                </div>
                                                            </td>
                                                            <td class="align-middle action-buttons" style="white-space: nowrap;">
                                                                <a href="{{ route('movies.detail', ['imdbID' => $movie['imdbID']]) }}"
                                                                    class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                    {{ __('messages.Detail') }}
                                                                </a>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger favorite-btn"
                                                                    data-imdb="{{ $movie['imdbID'] }}"
                                                                    data-title="{{ $movie['title'] }}"
                                                                    data-poster="{{ $movie['poster'] }}"
                                                                    data-year="{{ $movie['year'] }}"
                                                                    data-type="{{ $movie['type'] }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                    {{ __('messages.Remove') }}
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
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
        function removeFavorite(btn) {
            let imdbID = btn.data('imdb');
            let icon = btn.find('i');

            $.ajax({
                url: "{{ route('favorite.remove') }}",
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    imdbID: imdbID
                },
                success: function(response) {
                    if (response.status === 'removed') {
                        // Hapus baris dari tabel
                        $('tr[data-imdb="' + imdbID + '"]').fadeOut(function() {
                            $(this).remove();

                            // Jika tidak ada favorit lagi, tampilkan pesan kosong
                            if ($('#favorites-table tbody tr').length === 0) {
                                location.reload();
                            }
                        });
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
                    Swal.fire({
                        text: 'Terjadi kesalahan, coba lagi',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }

        $(document).ready(function() {
            $('.favorite-btn').on('click', function() {
                removeFavorite($(this));
            });
        });
    </script>
@endpush
