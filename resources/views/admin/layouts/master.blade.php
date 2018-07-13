
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="{{config('app.skin')}} sidebar-mini">

<div id="wrapper">

    @include('admin.partials.topbar')
    @include('admin.partials.sidebar')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">



                    @yield('content')


        </section>
    </div>
</div>

{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('admin.partials.javascripts')
@yield('javascript')
</body>
</html>



