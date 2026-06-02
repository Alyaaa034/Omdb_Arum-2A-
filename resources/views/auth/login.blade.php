@extends('panel_control/partials.master')

@section('title', __('messages.login'))

@section('main-content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    {{-- Logo --}}
                    <div class="login-brand">
                        <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    {{-- Language Switcher --}}
                    <div class="text-center mb-3">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                data-toggle="dropdown">
                                <i class="fas fa-globe"></i>
                                {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{ url('lang', 'en') }}" class="dropdown-item">
                                    English
                                </a>
                                <a href="{{ url('lang', 'id') }}" class="dropdown-item">
                                    Bahasa Indonesia
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Card Login --}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{ __('messages.login') }}</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('signin') }}" class="needs-validation" novalidate="">
                                @csrf

                                <div class="form-group">
                                    <label for="email">{{ __('messages.email') }}</label>
                                    <input type="email" class="form-control" name="email" tabindex="1"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">{{ __('messages.password') }}</label>
                                    </div>
                                    <input type="password" class="form-control" name="password" tabindex="2">
                                    @error('password')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        {{ __('messages.login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Link Register --}}
                    <div class="mt-5 text-muted text-center">
                        {{ __('messages.Dont have an account?') }}
                        <a href="{{ url('/register') }}">{{ __('messages.create one') }}</a>
                    </div>

                    {{-- Footer --}}
                    <div class="simple-footer">
                        Copyright &copy; Stisla <span id="year"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const yearElement = document.getElementById('year');
        if (yearElement) {
            yearElement.innerHTML = new Date().getFullYear();
        }
    </script>
@endpush
