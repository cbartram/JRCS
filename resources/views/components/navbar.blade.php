<!-- Define a Global Navbar that can be used anywhere here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Profile</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="../../public/css/Profile.css" rel="stylesheet">
    <link href="../../public/css/jquery-ui.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="../../public/css/fullcalendar.css" rel="stylesheet">
    <link href="../../public/css/fullcalendar.print.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                JRCS <span class="label label-warning">Beta</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if(!Auth::guest())
                <ul class="nav navbar-nav">
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="glyphicon glyphicon-plus"></span> New Volunteer </a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="profile"><a href="#"><span class="glyphicon glyphicon-usd"></span> Pending Donations</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="messages"><a href="#"><i class="fa fa-calendar"></i> New Event</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="checkout-volunteer"><a href="#"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="fa fa-user-plus"></span> New Volunteer </a></li>
                    <li role="presentation" id="profile"><a href="#" data-toggle="modal" data-target="#pending-donations"><span class="fa fa-money"></span> Pending Donations</a></li>
                    <li role="presentation" id="events"><a data-toggle="modal" data-target="#event-modal" href="#"><span class="fa fa-calendar"></span> New Event</a></li>
                    <li role="presentation" id="log"><a href="#"><span class="fa fa-pencil"></span> Log Event</a></li>
                    <li role="presentation" id="checkout-volunteer"><a href="#"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-random"></span>
                            &nbsp; Switch Organizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Organizations</li>
                            @foreach($groups as $k => $v)
                                @if($groups[$k] == true)
                                    @if($defaultGroup == $k)
                                        <li class="disabled"><a href="#">{{$k}} - Current Organization</a></li>
                                    @else
                                        <li><a href="/switch/{{$k}}">{{$k}}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/availability') }}"><i class="fa fa-btn fa-bed"></i>Availability</a></li>
                            <li><a href="{{ url('/home') }}"><i class="fa fa-btn fa-tachometer"></i>Dashboard</a></li>
                            <li><a href="{{ url('/search') }}"><i class="fa fa-btn fa-search"></i>Search</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- JS Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="../../public/js/Highcharts.js"></script>
<script src="../../public/js/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src='../../public/js/moment.js'></script>
<script src="../../public/js/fullcalendar.min.js"></script>

<!-- Local JS Files -->
<script src="../../public/js/Chart.js"></script>
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Profile.js"></script>
</body>
</html>