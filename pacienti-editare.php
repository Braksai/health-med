<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';


$error = false;

if(!isset($_GET['user'])){
	header('Location: pacienti.php');
}
else{
	$user = mysqli_real_escape_string($con, $_GET['user']);
	if(isset($_POST['submit'])){

		$name = mysqli_real_escape_string($con, htmlspecialchars($_POST['nume']));
		$surname = mysqli_real_escape_string($con, htmlspecialchars($_POST['prenume']));
		$phone = mysqli_real_escape_string($con, htmlspecialchars($_POST['telefon']));
		$cnp = mysqli_real_escape_string($con, htmlspecialchars($_POST['cnp']));
		$email = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
		$address = mysqli_real_escape_string($con, htmlspecialchars($_POST['adresa']));
		$city = mysqli_real_escape_string($con, htmlspecialchars($_POST['oras']));
		$sex = mysqli_real_escape_string($con, htmlspecialchars($_POST['sex']));
		$age = mysqli_real_escape_string($con, htmlspecialchars($_POST['varsta']));

		$query = "UPDATE `persoane` SET `nume`='$name', `prenume`='$surname', `telefon`='$phone', `cnp`='$cnp', `email`='$email', 
			 	`adresa`='$address', `oras`='$city', `sex`='$sex', `varsta`=$age WHERE `id`='$user'";
		mysqli_query($con, $query);
		mysqli_close($con);
		header('Location: pacienti.php?action=2');
	}


	$query = "SELECT * FROM `persoane` WHERE `id`='$user';";
	$row = mysqli_fetch_array(mysqli_query($con, $query));
}
?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Editare pacient <i class="fa fa-user-circle" aria-hidden="true"></i> <a href="pacienti.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a></h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
                <form action="" method="post" id="editare-pacient-form" role="form">
                    <div class="form-group row">
                        <label for="nume" class="col-sm-2 control-label label-helper">Nume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="nume" name='nume' value='<?php echo$row['nume'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prenume" class="col-sm-2 control-label label-helper">Prenume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="prenume" name='prenume' value='<?php echo$row['prenume'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefon" class="col-sm-2 control-label label-helper">Telefon:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="telefon" name='telefon' value='<?php echo$row['telefon'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cnp" class="col-sm-2 control-label label-helper">Cnp:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="cnp" name='cnp' value='<?php echo$row['cnp'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 control-label label-helper">Email:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='email' id="email" name='email' value='<?php echo$row['email'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adresa" class="col-sm-2 control-label label-helper">Adresa:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="adresa" name='adresa' value='<?php echo$row['adresa'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="oras" class="col-sm-2 control-label label-helper">Oras:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="oras" name='oras' value='<?php echo$row['oras'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="col-sm-2 control-label label-helper">Sex:</label>
                        <div class="col-sm-2">
                            <select class='form-control' id="sex" name='sex'>
                                <option value="m" <?php if($row['sex']=='m'){echo"SELECTED";} ?>>Masculin</option>
                                <option value="f" <?php if($row['sex']=='f'){echo"SELECTED";} ?>>Feminin</option>
                            </select>
                        </div>
                        <label for="varsta" class="col-sm-2 control-label label-helper">Varsta:</label>
                        <div class="col-sm-2">
                            <input class='form-control' type='number' id="varsta" name='varsta' value='<?php echo$row['varsta'] ?>'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label label-helper"> </label>
                        <div class="col-sm-2">
                            <button type="submit" class="form-control btn btn-default" name="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Editeaza</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
mysqli_close($con);
include_once 'footer.php';
?>