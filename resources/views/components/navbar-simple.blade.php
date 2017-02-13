<!-- Define a Global Navbar that can be used anywhere here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/public/css/images/favicon.ico">

    <title>Volunteer Profile</title>

    <link href="/public/css/Profile.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom: 50px">
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
                JRCS
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if(1 == 2)
                <ul class="nav navbar-nav">
                    <li role="presentation" id="add-volunteer"><a href="/profile"><span class="glyphicon glyphicon-plus"></span> New Volunteer </a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="profile"><a href="/profile"><span class="glyphicon glyphicon-usd"></span> Pending Donations</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="messages"><a href="/profile"><i class="fa fa-calendar"></i> New Event</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="checkout-volunteer"><a href="/checkout"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (true)
                    <!-- Volunteer Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span> Volunteers <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Volunteer Actions</li>
                            <li><a href="/profile" id="add-volunteer"><span class="fa fa-user-plus"></span> New Volunteer</a></li>
                            <li><a href="/profile"><span class="fa fa-search"></span> Volunteer Search</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Volunteer Archive</a></li>
                        </ul>
                    </li>

                    <!-- Event Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-calendar"></span> Events <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Event Actions</li>
                            <li><a href="/profile" id="events"><span class="fa fa-calendar"></span> Create Event</a></li>
                            <li><a href="/profile" id="log"><span class="fa fa-pencil"></span> Log Event</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Event Archive</a></li>
                        </ul>
                    </li>

                    <!-- Donation Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-money"></span> Donations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Donation Actions</li>
                            <li><a href="/profile"><span class="fa fa-plus-square"></span> New Donation</a></li>
                            <li><a href=/profile id="profile"><span class="fa fa-exclamation-triangle"></span> Pending Donations</a></li>
                            <li><a href="/archive"><span class="fa fa-history"></span> Donation History</a></li>
                        </ul>
                    </li>

                    <!-- Programs Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list"></span> Programs <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Program Actions</li>
                            <li><a href="/profile"><span class="fa fa-plus-square"></span> Add Program</a></li>
                            @if($defaultGroup == "ADMIN" || $defaultGroup == "JRCS")
                            <li><a href="/profile" id="profile"><span class="fa fa-trash"></span> Delete Program</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Archived Programs</a></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Export Dropdown -->
                    <li role="presentation"><a href="/profile"><span class="fa fa-file-excel-o"></span> Export</a></li>
                    <li role="presentation" id="checkout-volunteer"><a href="/checkout"><span class="fa fa-sign-out"></span> Checkout</a></li>
                @else

                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Local JS Files -->
<script src="/public/js/Profile.js"></script>
<script src="/public/js/Jquery_Bootstrap.js"></script>
{!! Toastr::render() !!}

</body>
</html>