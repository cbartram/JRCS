
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Login</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../../public/css/global_login.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="btn-group btn-group-justified" role="group">
        <div class="btn-group" role="group">
            <button type="button" id="staff-login-btn" class="btn btn-md btn-primary">Staff Login</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="volunteer-login-btn" class="btn btn-md btn-primary">Volunteer Check In</button>
        </div>
    </div>
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

    <!-- Volunteer Login -->
    <div class="row" id="volunteer-login">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form class="form-signin">
                <h2 class="form-signin-heading" align="center">Volunteer Login</h2>
                <!-- Alerts will show up in this dialog -->
                <div id="alert-cico"></div>
                <!-- //todo input is not in the proper bootstrap form needs to be fixed -->
                <input type="email" class="form-control" placeholder="Email" id="volunteer-email">
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>

                    <!-- Volunteer type selector -->
                    <div class="form-group">
                        <select class="form-control" id="volunteer-type">
                            <option name="default" selected>Select Volunteer Type</option>
                            <option name="program">Program</option>
                            <option name="board">Board</option>
                            <option name="general">General</option>
                        </select>
                    </div>

                    <!-- Hidden form only visible to program volunteers -->
                    <div class="form-group" id="volunteer-program">
                        <label for="program">Select Volunteer Program</label>
                        <select class="form-control" id="program">
                            <option name="default" selected>Select Program</option>
                            <option name="SAT">SAT Prep</option>
                            <option name="ACT">ACT Prep</option>
                            <option name="Career">Career Counseling</option>
                        </select>
                    </div>

                    <!-- Submit & back buttons -->
                    <div class="row">
                        <div class="col-md-12" style="height:25px;"></div>
                        <div class="col-md-12">
                            <button class="btn btn-block btn-success" id="volunteer-cico-submit" type="submit">Check-in</button>
                        </div>
                        <div class="col-md-12" style="height:25px;"></div>
                        <div class="col-md-12">
                            <button class="btn btn-block btn-danger" type="button">Back</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <!-- Volunteer Login end -->

</div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/global_login.js"></script>
</body>
</html>
