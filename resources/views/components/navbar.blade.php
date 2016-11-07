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
                JRCS <span class="label label-primary">Beta</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if(1 == 2)
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
                    <li role="presentation" id="checkout-volunteer"><a href="/checkout"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (true)
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="fa fa-user-plus"></span> New Volunteer </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-calendar"></span> Events <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Event Actions</li>
                            <li><a href="#" id="events" data-toggle="modal" data-target="#event-modal"><span class="fa fa-calendar"></span> Create Event</a></li>
                            <li><a href="#" id="log" data-toggle="modal" data-target="#log-event-modal"><span class="fa fa-pencil"></span> Log Event</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-money"></span> Donations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Donation Actions</li>
                            <li><a href="#" data-toggle="modal" data-target="#add-donation"><span class="fa fa-plus-square"></span> New Donation</a></li>
                            <li><a href="#" id="profile" data-toggle="modal" data-target="#pending-donations"><span class="fa fa-exclamation-triangle"></span> Pending Donations</a></li>
                            <li><a href="/donation/history"><span class="fa fa-history"></span> Donation History</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list"></span> Programs <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Program Actions</li>
                            <li><a href="#" data-toggle="modal" data-target="#add-program"><span class="fa fa-plus-square"></span> Add Program</a></li>
                            @if($defaultGroup == "ADMIN")
                            <li><a href="#" id="profile" data-toggle="modal" data-target="#delete-program"><span class="fa fa-trash"></span> Delete Program</a></li>
                            @endif
                        </ul>
                    </li>
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
                    <li role="presentation" id="checkout-volunteer"><a href="/checkout"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
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

<!-- Include all the modals with Blade -->
@include('components.modals.add-event')
@include('components.modals.volunteer-detail')
@include('components.modals.log-event')
@include('components.modals.drag-drop')
@include('components.modals.donation')
@include('components.modals.account-settings')
@include('components.modals.add-volunteer')
@include('components.modals.add-donation')
@include('components.modals.add-program')
@include('components.modals.delete-program')
@include('components.modals.donation-denied')


@yield('content')

<!-- JS Libraries -->
<script src='../../public/js/moment.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../../public/js/jquery-ui.min.js"></script>

<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="../../public/js/Highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="../../public/js/fullcalendar.min.js"></script>
{!! Toastr::render() !!}

<!-- Local JS Files -->
<script src="../../public/js/Chart.js"></script>
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Profile.js"></script>
</body>
</html>