<!DOCTYPE html>
<?php
include_once 'db.php';

$error = false;
if(isset($_POST['submit'])){

	$user = mysqli_real_escape_string($con, $_POST['utilizator']);
	$query = "SELECT * FROM `utilizatori` WHERE `utilizator`='$user';";


if(mysqli_num_rows(mysqli_query($con, $query))==1)
{
	$error = true;
}
else
{
	$name = mysqli_real_escape_string($con, $_POST['nume']);
	$surname = mysqli_real_escape_string($con, $_POST['prenume']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = hash('sha256', $_POST['parola']);

	$query = "INSERT INTO utilizatori (nume, prenume, email, utilizator, parola) 
	VALUES ('$name', '$surname', '$email', '$user', '$password');";
	mysqli_query($con, $query);
	mysqli_close($con);
	header('Location: login.php');
}
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>HealthMed</title>

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/metisMenu.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/font-awesome.min.css" rel="stylesheet" >
    </head>
    

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-3">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title panel-login-text"><i class="fa fa-plus-circle fa-fw" style="color: #ed4e3a;"></i>HealthMed</h3>
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="login-form" role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card fa-fw" aria-hidden="true"></i></span>
                                            <input type="text" name="nume" class="form-control input-lg" placeholder="Nume" value="<?php if(isset($_POST['submit'])){echo $_POST['nume'];}    ?>" maxlength="40" autofocus required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $_POST['nume'];    ?></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card-o fa-fw" aria-hidden="true"></i></span>
                                            <input type="text" name="prenume" class="form-control input-lg" placeholder="Prenume" value="<?php if(isset($_POST['submit'])){echo $_POST['prenume'];}    ?>" maxlength="40" autofocus required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $_POST['prenume'];    ?></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i></span>
                                            <input type="email" name="email" class="form-control input-lg" placeholder="Email" value="<?php if(isset($_POST['submit'])){echo $_POST['email'];}    ?>" maxlength="40" autofocus required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $_POST['email'];    ?></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                                            <input type="text" name="utilizator" class="form-control input-lg" placeholder="Utilizator" value="<?php if(!$error && isset($_POST['submit'])){echo $_POST['utilizator'];}    ?>" maxlength="40" autofocus required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $_POST['utilizator'];    ?></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
                                            <input type="password" name="parola" class="form-control input-lg" placeholder="Parola" maxlength="40" required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $_POST['parola'];   ?></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-block btn-danger" name="submit"><i class="fa fa-key" aria-hidden="true"></i> Inregistrare</button>
                                    </div>
                                    <?php
                                    if($error){                                    
                                            echo '<div class="alert alert-danger alert-dismissable fade in">
                                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                 <strong>Alege un alt nume de utilizator!</strong>
                                             </div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <hr />
                                    </div>
                                    <label>Ai un cont creat? <a href="login.php" class="text-danger">Logare</a></label>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
