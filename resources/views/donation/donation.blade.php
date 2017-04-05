
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/public/css/images/favicon.ico">

    <title>Volunteer Donation</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/public/css/Toastr_Bootstrap.css">

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

                    <p><select name="group" class="form-control" id="group">
                        <option name="JACO">JACO</option>
                        <option name="BEBCO">BEBCO</option>
                        <option name="JBC">JBC</option>
                        <option name="JRCS">JRCS</option>
                    </select></p>

                    <p><select name="donation-type" class="form-control" id="donation-type">
                      <option name="monetary">Monetary</option>
                      <option name="supplies">Supplies</option>
                      <option name="inkind">In Kind</option>
                    </select></p>

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

<!-- Local JS Files -->
<script src="/public/js/Archive.js"></script>
</body>
</html>
