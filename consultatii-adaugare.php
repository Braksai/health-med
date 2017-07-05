<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

$error = false;
if(!isset($_GET['user'])){
	header('Location: consultatii.php');
}
else{
	$user = mysqli_real_escape_string($con, $_GET['user']);
	if(isset($_POST['submit'])){

	$ritm_cardiac = mysqli_real_escape_string($con, $_POST['ritm_cardiac']);
	$ritm_respirator = mysqli_real_escape_string($con, $_POST['ritm_respirator']);
	$tensiune_sis = mysqli_real_escape_string($con, $_POST['tensiune_sis']);
	$tensiune_dia = mysqli_real_escape_string($con, $_POST['tensiune_dia']);
	$temperatura = mysqli_real_escape_string($con, $_POST['temperatura']);
	$observatii = mysqli_real_escape_string($con, $_POST['observatii']);
	

	$query = "INSERT INTO consultatii (idPersoana, ritm_cardiac, ritm_respirator, tensiune_sis, tensiune_dia, temperatura, observatii) 
	VALUES ($user, $ritm_cardiac, $ritm_respirator, $tensiune_sis, $tensiune_dia, $temperatura, '$observatii');";
	mysqli_query($con, $query);
	mysqli_close($con);
	header('Location: consultatii.php?action=1');
	}
}
?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Adaugare consultatie <i class="fa fa-user-circle" aria-hidden="true"></i> <a href="consultatii.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a></h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
                <form action="" method="post" id="adaugare-consultatie-form" role="form">
                    <div class="form-group row">
                        <label for="ritm_cardiac" class="col-sm-2 control-label label-helper">Ritm cardiac:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="ritm_cardiac" name='ritm_cardiac'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ritm_respirator" class="col-sm-2 control-label label-helper">Ritm respirator:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="ritm_respirator" name='ritm_respirator'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tensiune_sis" class="col-sm-2 control-label label-helper">Tensiune sistolica:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="tensiune_sis" name='tensiune_sis'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tensiune_dia" class="col-sm-2 control-label label-helper">Tensiune diastolica:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="tensiune_dia" name='tensiune_dia'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="temperatura" class="col-sm-2 control-label label-helper">Temperatura:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="temperatura" name='temperatura'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="observatii" class="col-sm-2 control-label label-helper">Observatii:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="observatii" name='observatii'/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label label-helper"> </label>
                        <div class="col-sm-2">
                            <button type="submit" class="form-control btn btn-default" name="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Adauga</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include_once 'footer.php';
?>