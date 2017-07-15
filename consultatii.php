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
    $link = 'user='.$user.'&';
    $table = '';
    $searchdetails1 = '';
    $searchdetails2 = '';
    $resultNotFound = '';
    $paginationStructure = '';
    $actionMessage = array("Consultatia a fost stearsa!", "Consultatia a fost adaugata!", "Consultatia a fost editata!");
    
    $sqlPacient = "SELECT `nume`, `prenume` FROM `persoane` WHERE `id` ='$user';";
    $query = mysqli_query($con, $sqlPacient);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $numeCompletPacient = $row['nume'].' '.$row['prenume'];
    
    $sql = "SELECT COUNT(`id`) FROM `consultatii` WHERE `idPersoana` ='$user';";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_row($query);
    $rows = $row[0];
    if($rows > 0) {
        $page_rows = 10;
        $last = ceil($rows/$page_rows);
        if($last < 1){
            $last = 1;
        }
        $pagenum = 1;
        if(isset($_GET['pageNr'])){
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pageNr']);
        }
        if ($pagenum < 1) {
            $pagenum = 1;
        } else if ($pagenum > $last) {
            $pagenum = $last;
        }
        $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
        $sql = "SELECT `id`, `idPersoana`, `ritm_cardiac`, `ritm_respirator`, `tensiune_sis`, `tensiune_dia`, `temperatura`, `observatii`, `adaugat` FROM `consultatii` WHERE `idPersoana` ='$user' ORDER BY `id` DESC $limit";
        $query = mysqli_query($con, $sql);
        $searchdetails1 = "Numar total consultatii: (<b>$rows</b>)";
        $searchdetails2 = "Pagina <b>$pagenum</b> din <b>$last</b>";
        $paginationStructure = '<ul class="pagination">';
        if($last != 1){
            if ($pagenum > 1) {
                $previous = $pagenum - 1;
                $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$link.'pageNr='.$previous.'">«</a></li>';
                for($i = $pagenum-4; $i < $pagenum; $i++){
                    if($i > 0){
                    $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$link.'pageNr='.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            $paginationStructure .= '<li class="active active-btn-page"><a href="">'.$pagenum.'</a></li>';
            for($i = $pagenum+1; $i <= $last; $i++){
                    $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$link.'pageNr='.$i.'">'.$i.'</a></li>';
                    if($i >= $pagenum+4){
                            break;
                    }
            }
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationStructure .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$link.'pageNr='.$next.'">»</a></li> ';
            }
            $paginationStructure .= '</ul>';
        }
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $table.='<TR>
                    <TD>'.$row["ritm_cardiac"].'</TD>
                    <TD>'.$row["ritm_respirator"].'</TD>
                    <TD>'.$row["tensiune_sis"].' / '.$row["tensiune_dia"].'</TD>
                    <TD>'.$row["temperatura"].'</TD>
                    <TD>'.$row["observatii"].'</TD>
                    <TD>'.$row["adaugat"].'</TD>
            </TR>';
        }
    } else {
        $resultNotFound = "Nu exista consultatii";
        $resultNotFound .= "!";
        $table.='<tr><td colspan="6" class="text-center medium-size-font">'.$resultNotFound.'</td></tr>';
    }
}
?>
<div id="page-wrapper" class="clearfix">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Lista consultatii <?php echo $numeCompletPacient;?> <i class="fa fa-list-alt" aria-hidden="true"></i> 
                <div class="pull-right" style="display: inline-block;">
                    <a href="pacienti-vizualizare.php?user=<?php echo $user; ?>" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a>
                    <a href="consultatii-adaugare.php?user=<?php echo $user; ?>" class="btn btn-default pull-right" style="line-height: 26px; margin-right: 5px; "><i class="fa fa-plus" aria-hidden="true"></i> Adauga consultatie</a>
                </div>
            </h1>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
		<?php
		if(isset($_GET['action'])){
		echo'
                	<div class="alert alert-success alert-dismissable fade in" id="removealert">
                    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    		<strong>Success!</strong> '.$actionMessage[$_GET['action']].'
                	</div>
			<SCRIPT LANGUAGE="JavaScript">
				setTimeout(function(){
				$("#removealert").remove();
				}, 4000);
			</SCRIPT>';
		}
		?>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-8 col-lg-offset-2"> 
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr><th>Ritm Cardiac</th><th>Ritm Respirator</th><th>Tensiune Arteriala</th><th>Temperatura</th><th style="width:390px">Observatii</th><th>Data</th></tr>
                                </thead>
                                <tbody>
                                    <?php echo $table; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center"><?php echo $paginationStructure; ?></div>
    <div class="row text-center mb15"><?php if(!$resultNotFound){echo $searchdetails2.' , '.$searchdetails1;} ?></div>
</div>
<?php
include_once 'footer.php';
?>