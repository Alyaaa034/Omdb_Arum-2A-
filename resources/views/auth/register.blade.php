@extends('panel_control/partials.master')

@section('title', __('messages.register'))

@section('main-content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
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

                    {{-- Card Register --}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{ __('messages.register') }}</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('signup') }}">
                                @csrf

                                {{-- Full Name --}}
                                <div class="form-group">
                                    <label for="name">{{ __('messages.Full Name') }}</label>
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label for="email">{{ __('messages.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Password & Confirmation --}}
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password" class="d-block">{{ __('messages.password') }}</label>
                                        <input id="password" type="password" class="form-control pwstrength"
                                            data-indicator="pwindicator" name="password">
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                        @error('password')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="password2" class="d-block">{{ __('messages.Password Confirmation') }}</label>
                                        <input id="password2" type="password" class="form-control"
                                            name="password_confirmation">
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        {{ __('messages.register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Link to Login --}}
                    <div class="mt-5 text-muted text-center">
                        {{ __('messages.Already have an account?') }}
                        <a href="{{ route('login') }}">{{ __('messages.Login here') }}</a>
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
    {{-- Library untuk password strength --}}
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

    {{-- Page specific JS for register --}}
    <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>

    {{-- Script untuk tahun berjalan --}}
    <script>
        const yearElement = document.getElementById('year');
        if (yearElement) {
            yearElement.innerHTML = new Date().getFullYear();
        }
    </script>
@endpush
