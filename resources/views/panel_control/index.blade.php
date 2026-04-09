<!DOCTYPE html>
<html lang="en" lang="in">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Movies &mdash; OMDB</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

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
    <div class="main-wrapper main-wrapper-1">
      @include('partials.header')
      @include('partials.sidebar')

      <!-- Main Content -->
      <div class="main-content" style="min-height: 896px">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('movies') }}</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>{{ __('all_movies') }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="float-right">
                      <div class="search-element">
                        <div class="input-group-append">
                          <input type="text" name="q" id="search-input" class="form-control" placeholder="{{ __('search_placeholder') }}">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                      <table class="table table-striped" id="movie-table">
                        <thead>
                          <tr>
                            <th>{{ __('poster') }}</th>
                            <th>{{ __('title') }}</th>
                            <th>{{ __('year') }}</th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('action') }}</th>
                          </tr>
                        </thead>
                        <tbody id="Movie-container">
                          <tr id="empty-row">
                            <td colspan="5" class="text-center py-5">
                              <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                              <span class="text-muted">{{ __('search_prompt') }}</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      @include('partials.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
  <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/index.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('asset/assets/js/custom.js') }}"></script>

  <script>
    const year = document.getElementById('year');
    if (year) year.innerHTML = new Date().getFullYear();
  </script>
</body>
</html>
