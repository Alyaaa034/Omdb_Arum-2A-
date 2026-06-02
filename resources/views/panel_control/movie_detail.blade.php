@extends('panel_control/partials.master')

@section('title', $movie['Title'] ?? __('messages.Movie Detail'))

@section('main-content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('messages.Movie Detail') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('movies') }}">{{ __('messages.Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">
                        <a href="{{ route('movies') }}?q={{ str_replace(' ', '+', request('q')) }}">
                            {{ __('messages.Movies') }}
                        </a>
                    </div>
                    <div class="breadcrumb-item">
                        {{ __('messages.Movie Detail') }}
                    </div>
                </div>
            </div>

            <div class="section-body">
                @if ($error ?? false)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @else
                    <div class="row">
                        {{-- Poster --}}
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ $movie['Poster'] }}"
                                        alt="{{ $movie['Title'] }}"
                                        class="img-fluid rounded"
                                        loading="lazy">
                                </div>
                            </div>
                        </div>

                        {{-- Detail --}}
                        <div class="col-12 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h2 class="mb-1">{{ $movie['Title'] }}</h2>
                                            <p class="text-muted mb-3">
                                                {{ $movie['Year'] }} •
                                                {{ $movie['Runtime'] }} •
                                                {{ $movie['Genre'] }}
                                            </p>
                                        </div>
                                        {{-- Tombol favorite (jika diperlukan nanti) --}}
                                        {{-- <button type="button" class="btn btn-outline-danger favorite-btn"
                                            data-imdb="{{ $movie['imdbID'] }}"
                                            id="favorite-btn-{{ $movie['imdbID'] }}">
                                            <i class="far fa-heart"></i>
                                            <span>{{ __('messages.Add to Favorites') }}</span>
                                        </button> --}}
                                    </div>

                                    {{-- Ratings --}}
                                    <div class="mb-4">
                                        @foreach ($movie['Ratings'] as $rating)
                                            <span class="badge badge-info mr-1">
                                                {{ $rating['Source'] }}: {{ $rating['Value'] }}
                                            </span>
                                        @endforeach
                                        <span class="badge badge-warning mr-1">
                                            IMDb: {{ $movie['imdbRating'] }}
                                        </span>
                                    </div>

                                    {{-- Plot --}}
                                    <h5>{{ __('messages.Plot') }}</h5>
                                    <p class="mb-4">{{ $movie['Plot'] }}</p>

                                    {{-- Director & Writer --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Director') }}</h6>
                                            <p>{{ $movie['Director'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Writer') }}</h6>
                                            <p>{{ $movie['Writer'] }}</p>
                                        </div>
                                    </div>

                                    {{-- Actors & Language --}}
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Actors') }}</h6>
                                            <p>{{ $movie['Actors'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Language') }}</h6>
                                            <p>{{ $movie['Language'] }}</p>
                                        </div>
                                    </div>

                                    {{-- Country & Box Office --}}
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Country') }}</h6>
                                            <p>{{ $movie['Country'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('messages.Box Office') }}</h6>
                                            <p>{{ $movie['BoxOffice'] ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    {{-- Tombol kembali --}}
                                    <div class="mt-4">
                                        <a href="{{ route('movies') }}?q={{ str_replace(' ', '+', request('q')) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i>
                                            {{ __('messages.Back to Movies') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
