<!DOCTYPE html>
<?php
include_once 'db.php';

$error = 0;
$errorMessage = array("", "Utilizator gresit sau parola incorecta!", "Utilizatorul nu este acceptat!");

if(isset($_SESSION['user'])){
	header('Location: index.php');
}

if(isset($_POST['submit'])){
	$user = mysqli_real_escape_string($con, $_POST['utilizator']);
	$password = hash('sha256', $_POST['parola']);

	$query = "SELECT * FROM `utilizatori` WHERE `utilizator`='$user' AND `parola`='$password';";


	if(mysqli_num_rows(mysqli_query($con, $query))==1){
		$row = mysqli_fetch_array(mysqli_query($con, $query));
		if($row['acceptat'] == 1){
			$_SESSION['user'] = $row['nume']." ".$row['prenume'];
			mysqli_free_result();
			mysqli_close($con);
			header('Location: index.php');
		}
		else{
			$error = 2;
		}
	}
	else{
		$error = 1;
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
                                            <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                                            <input type="text" name="utilizator" class="form-control input-lg" placeholder="Utilizator" value="<?php if(isset($_POST['utilizator'])){echo $_POST['utilizator'];}    ?>" maxlength="40" autofocus required/>
                                        </div>
                                        <span class="text-danger"><?php //echo $userError;    ?></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
                                            <input type="password" name="parola" class="form-control input-lg" placeholder="Parola" maxlength="40" required/>
                                            <span class="input-group-btn"><button class="btn btn-lg btn-danger" type="submit" name="submit"><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></button></span>
                                        </div>
                                    </div>
                                    <?php if($error){
                                        echo '<div class="alert alert-danger alert-dismissable fade in">
                                                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                 <strong>'.$errorMessage[$error].'</strong>
                                             </div>';
                                    }?>
                                    <div class="form-group">
                                        <hr />
                                    </div>
                                    <label>Ai nevoie de un cont? <a href="register.php" class="text-danger">Inregistrare</a></label>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>

</html>
