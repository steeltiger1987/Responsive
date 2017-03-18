<header style="padding:0px;">
    <div class="wrap">
        <div class="logo-menu">
            <div class="logo"><a href="http://www.teleportoo.cz"><img src="{{ URL::asset('public/images/teleportoo-logo.jpg') }}" style="width:150px !important;margin-top: 10px;margin-bottom: 10px;"/></a></div>
            <div class="menu">
                <ul>
                @if(Auth::guest())
                    <li><a href="{{ url('/login') }}" title="Login">@lang('general.login')</a></li>
                    <li><a href="{{ url('/register') }}" title="Register">@lang('general.register')</a></li>
                    <li><a href="{{ url('/orders/create') }}" title="Create new Order">@lang('general.create_order')</a> </li>
                @else
                    @if(Auth::user()->isMover())
                        <li><a href="{{ url('/jobs') }}" title="My active jobs">@lang('general.my_active_jobs')</a> </li>
                        <li><a href="{{ url('/orders/show') }}">@lang('general.orders')</a></li>
                        <li><a href="{{ url('/account/billing-info') }}">@lang('general.top_up')</a></li>
                        <li>Balance: {{ Auth::user()->getBalance() }} @lang('general.'.currency()->getUserCurrency())</li>
                    @endif
                    <li><a href="{{ url('/account') }}" title="My account">@lang('general.my_account')</a> </li>
                     <li><a href="{{ url('/logout') }}" title="Logout">@lang('general.logout')</a></li>
                @endif
                    <li>
                    @if(App::isLocale('en'))
                        <a href="{{ url('/cz') }}">cz</a>
                    @elseif(App::isLocale('cz'))
                        <a href="{{ url('/en') }}">en</a>
                    @endif
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</header>