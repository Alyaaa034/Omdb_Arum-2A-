<!DOCTYPE html>
<html lang="en" lang="in">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Movies &mdash; OMDB</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{asset('assets/img/stisla-fill.svg')}}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <!-- Dropdown Bahasa -->
            <div class="text-center mb-4">
              <div class="dropdown d-inline-block">
                <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ strtoupper(session('locale', 'en')) }}
                </button>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                  <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a>
                  <a class="dropdown-item" href="{{ route('lang.switch', 'in') }}">Bahasa Indonesia</a>
                </div>
              </div>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>{{ __('login') }}</h4></div>
              <div class="card-body">
                <form method="POST" action="{{ url('/login') }}" class="needs-validation" novalidate="">
                  @csrf
                  @if(session('login_error'))
                    <div class="alert alert-danger">{{ session('login_error') }}</div>
                  @endif
                  <div class="form-group">
                    <label for="email">{{ __('email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" tabindex="1" required autofocus>
                    <div class="invalid-feedback">{{ __('please_fill', ['field' => __('email')]) }}</div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="control-label">{{ __('password') }}</label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">{{ __('please_fill', ['field' => __('password')]) }}</div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">{{ __('login') }}</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="mt-5 text-muted text-center">
              {{ __('no_account') }} <a href="{{ url('/register') }}">{{ __('create_one') }}</a>
            </div>
            <div class="simple-footer">
              {{ __('copyright', ['year' => date('Y')]) }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('assets/modules/popper.js')}}"></script>
  <script src="{{asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('asset/assets/js/custom.js')}}"></script>
  <script>const year = document.getElementById('year'); year.innerHTML = new Date().getFullYear();</script>
</body>
</html>
