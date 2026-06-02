@extends('panel_control/partials.master')

@section('title', __('messages.Dashboard'))

@section('main-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('messages.Dashboard') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('dashboard') }}">{{ __('messages.Dashboard') }}</a>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-film"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('messages.Movies') }}</h4>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('movies') }}">{{ __('messages.Search Movies') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('messages.Favorites') }}</h4>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('favorite') }}">{{ __('messages.My Favorites') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
