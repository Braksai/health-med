<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Grafic temperatura pacienti <i class="fa fa-user-circle" aria-hidden="true"></i></h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12"> 
		<DIV id="chart1"></DIV>
		<DIV id="chart2"></DIV>
<?php

if(!isset($_GET['user'])){
	header('Location: pacienti.php');
}

$user = mysqli_real_escape_string($con, $_GET['user']);
$limit = 3;
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
	$cat = '"'.$row['adaugat'].'"';
}
while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
{
	$i++;
	$val .= ', '.$row['tensiune_sis'];
	$val2 .= ', '.$row['tensiune_dia'];
	$val3 .= ', '.$row['ritm_cardiac'];
	$cat .= ', "'.$row['adaugat'].'"';
}



$chart .='
		<script src="js/chart.js"></script>
                <SCRIPT LANGUAGE="JavaScript">

			var val=new Array($val);
			var cat=new Array($cat);
			var val2 = new Array($val2);
			var val3 = new Array($val3);
			var bars=$i;
			var s = 0;
			var useCatColors = false;
			console.log(val);
			console.log(val2);
			console.log(val3);
			console.log(cat);
			console.log(bars);
			var catColors = new Array("#19a9d5","#5cb85c","#fb3d50");

			var useValColors = true;
			var valColors = new Array("#19a9d5","#1cec41","#fb3a3a");
			var neutralVal = new Array(18, 25);

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

			chart("chart1");

			val=new Array($val);
			useMultipleVal = false;
			var title = "Evolutia  pacientului (Ritm cardiac)";
			chart("chart2");
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