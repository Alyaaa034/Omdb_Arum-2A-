      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/index') }}">OMDB ALIYA</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/index') }}">OA</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">{{ __('pages') }}</li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>{{ __('movies') }}</span></a>
              <ul class="dropdown-menu">
                <li class="active"><a class="nav-link" href="{{ url('/index') }}">{{ __('search_movies') }}</a></li>
                <li><a class="nav-link" href="{{ url('/My') }}">{{ __('my_favorites') }}</a></li>
              </ul>
            </li>
          </ul>
        </aside>
      </div>
