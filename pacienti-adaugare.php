<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

$error = false;
if(isset($_POST['submit'])){
	if(!isset($_POST['sex'])){
		$error = true;
	}
	else{
		$name = mysqli_real_escape_string($con, $_POST['nume']);
		$surname = mysqli_real_escape_string($con, $_POST['prenume']);
		$phone = mysqli_real_escape_string($con, $_POST['telefon']);
		$cnp = mysqli_real_escape_string($con, $_POST['cnp']);
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$address = mysqli_real_escape_string($con, $_POST['adresa']);
		$city = mysqli_real_escape_string($con, $_POST['oras']);
		$sex = mysqli_real_escape_string($con, $_POST['sex']);
		$age = mysqli_real_escape_string($con, $_POST['varsta']);

		$query = "INSERT INTO persoane (nume, prenume, telefon, cnp, email, adresa, oras, sex, varsta) 
		VALUES ('$name', '$surname', '$phone', '$cnp', '$email', '$address', '$city', '$sex', '$age');";
		mysqli_query($con, $query);
		mysqli_close($con);
		header('Location: pacienti.php?action=1');
	}
}
?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Adaugare pacient <i class="fa fa-user-circle" aria-hidden="true"></i> <a href="pacienti.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a></h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="adaugare-pacient-form" role="form">
                    <div class="form-group row">
                        <label for="nume" class="col-sm-2 control-label label-helper">Nume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="nume" name='nume'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prenume" class="col-sm-2 control-label label-helper">Prenume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="prenume" name='prenume'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefon" class="col-sm-2 control-label label-helper">Telefon:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="telefon" name='telefon'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cnp" class="col-sm-2 control-label label-helper">Cnp:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="cnp" name='cnp'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 control-label label-helper">Email:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='email' id="email" name='email'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adresa" class="col-sm-2 control-label label-helper">Adresa:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="adresa" name='adresa'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="oras" class="col-sm-2 control-label label-helper">Oras:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="oras" name='oras'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="col-sm-2 control-label label-helper">Sex:</label>
                        <div class="col-sm-2">
                            <select class='form-control' id="sex" name='sex'>
                                <option selected disabled>Selecteaza sexul</option>
                                <option value="m">Masculin</option>
                                <option value="f">Feminin</option>
                            </select>
                        </div>
                        <label for="varsta" class="col-sm-2 control-label label-helper">Varsta:</label>
                        <div class="col-sm-2">
                            <input class='form-control' type='number' id="varsta" name='varsta'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label label-helper"> </label>
                        <div class="col-sm-2">
                            <button type="submit" class="form-control btn btn-default" name="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Adauga</button>
                        </div>
                    </div>
		<?php
           	if($error){                                    
                        echo '<div class="alert alert-danger alert-dismissable fade in">
                          	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        	<strong>Ati uitat sa selectati sexul!</strong>
                          	</div>';
               	}
               	?>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include_once 'footer.php';
?>