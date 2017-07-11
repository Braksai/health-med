<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

if(!isset($_GET['user'])){
	header('Location: pacienti.php');
}
$user = mysqli_real_escape_string($con, $_GET['user']);

$sqlPacient = "SELECT `nume`, `prenume` FROM `persoane` WHERE `id` ='$user';";
$query = mysqli_query($con, $sqlPacient);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
$numeCompletPacient = $row['nume'].' '.$row['prenume'];

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Grafic evolutie pentru pacientul <?php echo$numeCompletPacient; ?> <i class="fa fa-user-circle" aria-hidden="true"></i><a href="pacienti-vizualizare.php?user=<?php echo$user;?>" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Inapoi</a></h1>
        </div>
    </div>
    <div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
		<DIV id="chart1"></DIV>
		<DIV id="chart2"></DIV>
<?php

$limit = 10;
$query = "SELECT `tensiune_sis`, `tensiune_dia`, `ritm_cardiac`, `adaugat` FROM `consultatii` WHERE `idPersoana` = $user ORDER BY `id` DESC LIMIT $limit;";


$i = 0;
$val = "";
$val2 = "";
$val3 = "";
$cat = "";

$sql = mysqli_query($con, $query);
if($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
{
	$i++;
	$val = $row['tensiune_sis'];
	$val2 = $row['tensiune_dia'];
	$val3 = $row['ritm_cardiac'];
	$cat = '"'.substr($row['adaugat'], 0 , strpos($row['adaugat'], " ")).'"';
}
while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
{
	$i++;
	$val .= ', '.$row['tensiune_sis'];
	$val2 .= ', '.$row['tensiune_dia'];
	$val3 .= ', '.$row['ritm_cardiac'];
	$cat .= ', "'.substr($row['adaugat'], 0 , strpos($row['adaugat'], " ")).'"';
}



echo'
		<script src="js/chart.js"></script>
                <SCRIPT LANGUAGE="JavaScript">

			var val=new Array('.$val.');
			var cat=new Array('.$cat.');
			var val2 = new Array('.$val2.');
			var val3 = new Array('.$val3.');
			var bars='.$i.';
			var s = 0;
			var useCatColors = false;
			var catColors = new Array("#19a9d5","#5cb85c","#fb3d50");

			var useValColors = true;
			var valColors = new Array("#19a9d5","#5cb85c","#fb3d50");
			var neutralVal = new Array(90, 120);

			var useMultipleVal = true;
		
			var title = "Evolutia  pacientului (Tensiune arteriala)";
			var category = [ ];

			for(var j =0;j<cat.length;j++){
				var words = [ ];
				while(cat[j].indexOf(" ") > 0){
					var str = cat[j].substring(0, cat[j].indexOf(" "));
					if(str.length > s){
						s = str.length;
					}
				words.push(str);
				cat[j] = cat[j].substr(cat[j].indexOf(" ")+1);
				}
			words.push(cat[j]);
			if(cat[j].length > s){
				s = cat[j].length;
			}
			category.push({words: words});
			}

			chart("chart1", "40%", "40%");

			val=new Array('.$val3.');
			useMultipleVal = false;
			var title = "Evolutia  pacientului (Ritm cardiac)";
			s -=21;
			s = Math.floor(s / 6);
			neutralVal = new Array(60, 100);
			chart("chart2", "40%", "40%");
</SCRIPT>';
?>
            </div>
        </div>
    </div>

</div>
<LINK REL="stylesheet" TYPE="text/css" HREF="css/chart.css" />
<?php

mysqli_close($con);
include_once 'footer.php';
?>