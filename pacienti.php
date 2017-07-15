<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

$whereSearch = '';
$link = '';
$table = '';
$searchdetails1 = '';
$searchdetails2 = '';
$resultNotFound = '';
$paginationStructure = '';
$querySearch = '';
$actionMessage = array("Pacientul a fost sters!", "Pacientul a fost adaugat!", "Pacientul a fost editat!");

if(isset($_POST['delete'])){
	$id = mysqli_real_escape_string($con, $_POST['id']);
	$query = "UPDATE `persoane` SET `sters`=1 WHERE `id`='$id'";
	mysqli_query($con, $query);
	$_GET['action'] = 0;
}

if(isset($_GET['search'])){
    $querySearch = $_GET['search']; 
    $min_length = 3;
    if(strlen($querySearch) >= $min_length){
        $querySearch = htmlspecialchars($querySearch); 
        $querySearch = mysqli_real_escape_string($con, $querySearch);
        $link = empty($querySearch) ? '': 'search='.$querySearch.'&';
        $whereSearch = "AND nume LIKE '%".$querySearch."%' OR prenume LIKE '%".$querySearch."%' OR cnp LIKE '%".$querySearch."%' ";
    }
}
$sql = "SELECT COUNT(id) FROM persoane WHERE sters=0 ".$whereSearch;
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
    $sql = "SELECT `id`, `nume`, `prenume`, `cnp`, `telefon` FROM persoane WHERE `sters`=0 ". $whereSearch ."ORDER BY `nume` ASC $limit";
    $query = mysqli_query($con, $sql);
    $searchdetails1 = "Numar total pacienti: (<b>$rows</b>)";
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
		<TD>'.$row["nume"].'</TD>
		<TD>'.$row["prenume"].'</TD>
		<TD>'.$row["cnp"].'</TD>
		<TD>'.$row["telefon"].'</TD>
		<TD>
                    <a href="pacienti-vizualizare.php?user='.$row["id"].'" class="btn btn-default">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                    <a href="pacienti-editare.php?user='.$row["id"].'" class="btn btn-default">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_' . $row['id'] . '">
                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                    </button>
                    <div class="modal fade" id="modal_' . $row['id'] . '" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Stergere Pacient</h4>
                            </div>
                            <div class="modal-body">
                              <p>Doresti sa stergi pacientul ' . $row['nume'] . ' ' . $row['prenume'] . '?</p>
                            </div>
                            <div class="modal-footer">
                              <form name="delete'.$row["id"].'" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">
                                  <input type="hidden" name="id" value="'.$row["id"].'" />
                                  <button type="submit" name="delete" class="btn btn-default"><i class="fa fa-trash" aria-hidden="true"></i> Da</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo" aria-hidden="true"></i> Nu</button>
                              </form>
                              </div>
                          </div>
                        </div>
                    </div>
                </TD>
	</TR>';
    }
} else {
    $resultNotFound = "Nu exista pacienti";
    if ($querySearch) {
        $resultNotFound .= " cu numele, prenumele, sau cnpul ".$querySearch;
    }
    $resultNotFound .= "!";
    $table.='<tr><td colspan="5" class="text-center medium-size-font">'.$resultNotFound.'</td></tr>';
}

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Lista pacienti <i class="fa fa-users" aria-hidden="true"></i> <a href="pacienti-adaugare.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-plus" aria-hidden="true"></i> Adauga pacient</a></h1>
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
        <div class="row">
            <form action="" id="cautare-pacient" method="GET" accept-charset="UTF-8" class="form-wrapper">
                <input title="Cautare pacient dupa nume, prenume sau cnp..." 
                       placeholder="Cautare pacient dupa nume, prenume sau cnp..." 
                       autocomplete="off" 
                       tabindex="1" 
                       type="text" 
                       name="search" 
                       id="search"
                       value="<?php echo !empty($querySearch) ? $querySearch : '';?>" 
                       size="32" 
                       maxlength="32" 
                       class="form-control"
                       style="height: 42px;">
                <a href="javascript:{}" onclick="document.getElementById('cautare-pacient').submit(); return false;" id="submit"><i class="fa fa-search" aria-hidden="true"></i> Cauta</a>
            </form>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-8 col-lg-offset-2"> 
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr><th>Nume</th><th>Prenume</th><th>C.N.P.</th><th>Telefon</th><th style="width:160px">Actiuni</th></tr>
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