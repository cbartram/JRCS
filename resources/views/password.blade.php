<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/public/css/images/favicon.ico">

    <title>Volunteer Checkout</title>

    <link rel="stylesheet" href="/public/css/Toastr_Bootstrap.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2 align="center">Make sure you write your new password down!</h2>
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                    @endif
                @endforeach
            </div>

            {{ Form::open(array('url' => '/change', 'method' => 'post')) }}

            <input type="password" class="form-control" name="password" placeholder="New Password">
            <br>
            <input type="password" class="form-control" name="password-confirm" placeholder="Confirm Password">
            <br>
            <input type="hidden" name="email" value="{{Input::get('email')}}">

            {{ Form::submit('Reset Password', array('class' => 'btn btn-block btn-success')) }}

            {{ Form::close() }}

        </div>
        <div class="col-lg-4"></div>
    </div>


    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="margin-top:15px;">
            <a href="/"><button class="btn btn-block btn-default">Home</button></a>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div> <!-- /container -->

<script src="/public/js/Jquery_Bootstrap.js"></script>
</body>
</html>