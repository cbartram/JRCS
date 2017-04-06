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

                    <!-- Checkout --->
                        <a href="/profile"><button type="button" class="btn btn-default navbar-btn">Dashboard <span class="fa fa-undo"></span></button></a>
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