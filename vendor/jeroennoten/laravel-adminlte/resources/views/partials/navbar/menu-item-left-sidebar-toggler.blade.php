<li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" @if(config('adminlte.sidebar_collapse_remember')) data-enable-remember="true" @endif @if(!config('adminlte.sidebar_collapse_remember_no_transition')) data-no-transition-after-reload="false" @endif @if(config('adminlte.sidebar_collapse_auto_size')) data-auto-collapse-size="{{ config('adminlte.sidebar_collapse_auto_size') }}" @endif>
        <i class="fas fa-bars"></i>
        <span class="sr-only">{{ __('adminlte::adminlte.toggle_navigation') }}</span>
    </a>
</li>
<li class="nav-item prev">
    <a class="nav-link" href="{{ url()->previous() }}">
        <i class="fa fa-arrow-left"></i>
    </a>
</li>
<li class="nav-item" id="actionbutton">

</li>