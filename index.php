<?php
include_once 'db.php';
if(!isset($_SESSION['user']))header('Location: login.php');

include_once 'header.php';

$sqlNrPacienti = "SELECT (SELECT COUNT(*) FROM `persoane`) AS NrTotal, "
                      . "(SELECT COUNT(*) FROM `persoane` WHERE sex = 'm') AS NrTotalBarbati , "
                      . "(SELECT COUNT(*) FROM `persoane` WHERE sex = 'f') AS NrTotalFemei";
$query = mysqli_query($con, $sqlNrPacienti);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$nrTotal = $row["NrTotal"];
$nrTotalBarbati = $row["NrTotalBarbati"];
$nrTotalFemei = $row["NrTotalFemei"];

$sqlConsultatiiRecente = "SELECT c.`id`, p.`nume`, p.`prenume`, c.`ritm_cardiac`, c.`ritm_respirator`, c.`tensiune_sis`, c.`tensiune_dia`, c.`temperatura`, c.`observatii`, c.`adaugat` "
        . "FROM `consultatii` c "
        . "INNER JOIN `persoane` p ON c.`idPersoana`=p.`id` ORDER BY c.`id` DESC LIMIT 8";
$query = mysqli_query($con, $sqlConsultatiiRecente);

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Bun venit in aplicatia HealthMed!</h1>
        </div>
    </div>
    <div class="row" style="margin-top: 30px;">
        <div class="col-lg-12">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <div class="huge"><span class="counter"><?php echo $nrTotal; ?></span> Pacienti</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center" style="background: #fff">
                        <span class="medium-size-font">Numar total pacienti</span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-male fa-5x" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <div class="huge"><span class="counter"><?php echo $nrTotalBarbati; ?></span> Barbati</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center" style="background: #fff">
                        <span class="medium-size-font">Numar total barbati</span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-female fa-5x" aria-hidden="true"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <div class="huge"><span class="counter"><?php echo $nrTotalFemei; ?></span> Femei</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center" style="background: #fff">
                        <span class="medium-size-font">Numar total femei</span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading " style="color: #FFF; font-size: 18px;">
                    Cele mai recente consultatii adaugate <i class="fa fa-address-book" aria-hidden="true"></i>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover" style="margin-bottom: 0px;">
                            <thead>
                                <tr><th>Nr. Crt.</th><th>Nume</th><th>Prenume</th><th>Ritm Cardiac</th><th>Ritm Respirator</th><th>Tensiune Arteriala</th><th>Temperatura</th><th style="width:390px">Observatii</th><th>Data</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $counter = 1;
                                while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                    echo '<tr>'
                                            .'<td>'.$counter.'</td>'
                                            .'<td>'.$row["nume"].'</td>'
                                            .'<td>'.$row["prenume"].'</td>'
                                            .'<td>'.$row["ritm_cardiac"].'</td>'
                                            .'<td>'.$row["ritm_respirator"].'</td>'
                                            .'<td>'.$row["tensiune_sis"].' / '.$row["tensiune_dia"].'</td>'
                                            .'<td>'.$row["temperatura"].'</td>'
                                            .'<td>'.$row["observatii"].'</td>'
                                            .'<td>'.$row["adaugat"].'</td>'
                                        .'</tr>';
                                    $counter++;
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>