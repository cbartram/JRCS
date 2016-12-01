
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Donation</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/Toastr_Bootstrap.css">

</head>

<body>

<div class="container">
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">Submit Donation Information <i class="fa fa-money"></i></div>
            <div class="panel-body">

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
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                <form action="/donation" method="post">
                    {{Form::token()}}
                    <p><input type="email" name="email" class="form-control" placeholder="Email"></p>

                    <p><select name="group" class="form-control" id="group"></p>
                        <option name="JACO">JACO</option>
                        <option name="BEBCO">BEBCO</option>
                        <option name="JBC">JBC</option>
                    </select>

                    <p><select name="donation-type" class="form-control" id="donation-type"></p>
                      <option name="monetary">Monetary</option>
                      <option name="supplies">Supplies</option>
                      <option name="inkind">In Kind</option>
                    </select>

                    <p><input type="text" class="form-control" name="amount" id="amount" placeholder="Amount"></p>
                    <p><input type="text" class="form-control" name="type" id="type" placeholder="Type of Supplies"></p>
                    <p><input type="text" class="form-control" name="inkind" id="inkind" placeholder="Type of Work"></p>
                    <div class="row">
                        <div class="col-lg-5 col-lg-offset-3">
                            <p><button type="submit" class="btn btn-block btn-primary"><span class="fa fa-plus"></span> Submit</button></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

            <div class="row">
                <div class="col-lg-12">
                    <a href="/"><button class="btn btn-block btn-default">Home</button></a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->

<!-- Globally Hosted Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>

<!-- Local JS Files -->
<script src="../../public/js/archive.js"></script>
</body>
</html>
