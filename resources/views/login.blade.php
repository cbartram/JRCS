
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Login</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../../public/css/Login.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <!-- Start Staff/Admin Login -->
    <div class="row" id="staff-login">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            {{ Form::open(array('url' => '/')) }}
            <h2 align="center">Staff Login</h2>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Error!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($errors->has('required'))
                <div class="alert alert-danger">
                    <strong>Error!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <li>Your Username or Password is incorrect</li>
                    </ul>
                </div>
            @endif

            <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>

                <p>{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}</p>

                    {{ Form::submit('Login', array('class' => 'btn btn-block btn-success')) }}

            {{ Form::close() }}
        </div>
        <div class="col-lg-4"></div>
    </div>
    <!-- End Staff Login -->


    <div class="row" id="forgot-password">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <br>
            <a href="/password/reset">Forgot your password?</a>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div> <!-- /container -->

<!-- Globally Hosted Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>

<!-- Local Libraries -->
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Login.js"></script>
</body>
</html>
