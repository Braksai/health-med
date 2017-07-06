<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

function dateFormat($date)
{
    $format = "Data ".substr($date, 0, strpos($date," ")).", ora ".substr($date, strpos($date," ")+1);
    return $format;
}

$error = false;

if(!isset($_GET['user'])){
	header('Location: pacienti.php');
}
else{
	$user = mysqli_real_escape_string($con, $_GET['user']);
	$query = "SELECT `nume`, `prenume`, `telefon`, `cnp`, `email`, `adresa`, `oras`, `sex`, `varsta`, `modificat`, persoane.`adaugat`, count(consultatii.`id`) AS consultatii FROM `persoane`
	LEFT JOIN `consultatii` ON consultatii.`idpersoana` = persoane.`id` WHERE persoane.`id`=$user GROUP BY consultatii.`idPersoana`;";
	$row = mysqli_fetch_array(mysqli_query($con, $query));
}
?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Vizualizare pacient <i class="fa fa-user-circle" aria-hidden="true"></i> <a href="pacienti.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a></h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
                <form action="" method="post" id="editare-pacient-form" role="form">
                    <div class="form-group row">
                        <label for="nume" class="col-sm-2 control-label label-helper">Nume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="nume" name='nume' value='<?php echo$row['nume'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="prenume" class="col-sm-2 control-label label-helper">Prenume:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="prenume" name='prenume' value='<?php echo$row['prenume'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefon" class="col-sm-2 control-label label-helper">Telefon:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="telefon" name='telefon' value='<?php echo$row['telefon'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cnp" class="col-sm-2 control-label label-helper">Cnp:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="cnp" name='cnp' value='<?php echo $row['cnp'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 control-label label-helper">Email:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='email' id="email" name='email' value='<?php echo $row['email'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adresa" class="col-sm-2 control-label label-helper">Adresa:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="adresa" name='adresa' value='<?php echo $row['adresa'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="oras" class="col-sm-2 control-label label-helper">Oras:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="oras" name='oras' value='<?php echo $row['oras'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="col-sm-2 control-label label-helper">Sex:</label>
                        <div class="col-sm-2">
                            <input class='form-control' type='text' id="sex" name='sex' value='<?php echo $row['sex'] == 'm' ? 'Masculin' : 'Feminin'; ?>' readonly/>
                        </div>
                        <label for="varsta" class="col-sm-2 control-label label-helper">Varsta:</label>
                        <div class="col-sm-2">
                            <input class='form-control' type='number' id="varsta" name='varsta' value='<?php echo $row['varsta'] ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modificat" class="col-sm-2 control-label label-helper">Modificat in:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="" name='modificat' value='<?php echo !empty($row['modificat']) ? dateFormat($row['modificat']) : "Nu a fost modificat."; ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adaugat" class="col-sm-2 control-label label-helper">Creat in:</label>
                        <div class="col-sm-6">
                            <input class='form-control' type='text' id="adaugat" name='adaugat' value='<?php echo dateFormat($row['adaugat']) ?>' readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label label-helper"> </label>
                        <div class="col-sm-6">
                            <a href="<?php echo $row['consultatii'] > 2 ? "pacienti-evolutie.php?user=".$user : "#" ?>" class="btn btn-default" style="line-height: 26px; <?php echo $row['consultatii'] > 2 ? "" : "cursor: not-allowed; background: #eee;" ?>"><i class="fa fa-lg fa-arrow-circle-o-right" aria-hidden="true"></i> Evolutie pacient</a>
                            <a href="consultatii.php?user=<?php echo $user; ?>" class="btn btn-default" style="line-height: 26px;"><i class="fa fa-lg fa-arrow-circle-o-right" aria-hidden="true"></i> Consultatii pacient</a>
                        </div>
                    </div>
		<?php
           	if($error){                                    
                    echo '<div class="alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Nu s-a selectat nici un pacient!</strong>
                          </div>';
               	}
               	?>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
mysqli_close($con);
include_once 'footer.php';
?>