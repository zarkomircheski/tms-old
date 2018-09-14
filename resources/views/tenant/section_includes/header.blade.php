@section('header')
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        @include('tenant.partial_views.menus.top_right')

        @include('tenant.partial_views.menus.top_left')

        @include('tenant.partial_views.menus.sidebar')

    </nav>

@show