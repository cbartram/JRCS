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
                JRCS
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
                    <!-- Volunteer Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span> Volunteers <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Volunteer Actions</li>
                            <li><a href="#" id="add-volunteer" data-toggle="modal" data-target="#add-volunteer-modal"><span class="fa fa-user-plus"></span> New Volunteer</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#search-modal"><span class="fa fa-search"></span> Volunteer Search</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Volunteer Archive</a></li>
                        </ul>
                    </li>

                    <!-- Event Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-calendar"></span> Events <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Event Actions</li>
                            <li><a href="#" id="events" data-toggle="modal" data-target="#event-modal"><span class="fa fa-calendar"></span> Create Event</a></li>
                            <li><a href="#" id="log" data-toggle="modal" data-target="#log-event-modal"><span class="fa fa-pencil"></span> Log Event</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Event Archive</a></li>
                        </ul>
                    </li>

                    <!-- Donation Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-money"></span> Donations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Donation Actions</li>
                            <li><a href="#" data-toggle="modal" data-target="#add-donation"><span class="fa fa-plus-square"></span> New Donation</a></li>
                            <li><a href="#" id="profile" data-toggle="modal" data-target="#pending-donations"><span class="fa fa-exclamation-triangle"></span> Pending Donations</a></li>
                            <li><a href="/archive"><span class="fa fa-history"></span> Donation History</a></li>
                        </ul>
                    </li>

                    <!-- Programs Dropdown -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list"></span> Programs <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Program Actions</li>
                            <li><a href="#" data-toggle="modal" data-target="#add-program"><span class="fa fa-plus-square"></span> Add Program</a></li>
                            @if($defaultGroup == "ADMIN" || $defaultGroup == "JRCS")
                            <li><a href="#" id="profile" data-toggle="modal" data-target="#delete-program"><span class="fa fa-trash"></span> Delete Program</a></li>
                            <li><a href="/archive"><span class="fa fa-archive"></span> Archived Programs</a></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Export Dropdown -->
                    <li role="presentation"><a href="#" data-toggle="modal" data-target="#export-modal"><span class="fa fa-file-excel-o"></span> Export</a></li>

                    <!-- Switch Dropdown -->
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-random"></span>
                            &nbsp; Switch Organizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Organizations</li>
                            @foreach($groups as $group)
                                @if($group->getAuth())
                                    @if($defaultGroup == $group->getName())
                                        <li class="disabled"><a href="#"><div class="group-color" style="height:15px; width:15px; border-radius:50%; background-color:{{$group->getColor()}};"></div> {{$group->getName()}} - Current Organization</a></li>
                                    @else
                                        <li><a href="/switch/{{$group->getName()}}"><div class="group-color" style="height:15px; width:15px; border-radius:50%; background-color:{{$group->getColor()}};"></div> {{$group->getName()}}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li role="presentation" id="checkout-volunteer"><a href="/checkout"><span class="fa fa-sign-out"></span> Checkout</a></li>
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
@include('components.modals.excel-export')
@include('components.modals.search')


@yield('content')

<!-- Local JS Files -->
<script src="/public/js/Profile.js"></script>
{!! Toastr::render() !!}

</body>
</html>