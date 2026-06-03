<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">OMDB ALIYA</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">OA</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">{{ __('messages.PAGES') }}</li>
      <li class="dropdown active">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-film"></i><span>{{ __('messages.Movies') }}</span></a>
        <ul class="dropdown-menu">
          <li class="{{ Route::is('movies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('movies') }}">{{ __('messages.Search Movies') }}</a>
          </li>
          <li class="{{ Route::is('favorites*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('favorites') }}">{{ __('messages.Favorite Movies') }}</a>
        </li>
        </ul>
      </li>
    </ul>
  </aside>
</div>
