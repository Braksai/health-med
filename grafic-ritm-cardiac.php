<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Grafic ritm cardiac pacienti <i class="fa fa-bar-chart" aria-hidden="true"></i></h1>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-lg-12"> 
		<DIV id="chart" style="margin-top: -7%;"></DIV>
<?php

$query = "SELECT (SELECT count(*) FROM `consultatii` C1 INNER JOIN `persoane` ON persoane.id=C1.idPersoana WHERE C1.id = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND persoane.sters=0 AND C1.ritm_cardiac<60) AS bradicardie, 
		(SELECT count(*) FROM `consultatii` C1 INNER JOIN `persoane` ON persoane.id=C1.idPersoana WHERE C1.id = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND persoane.sters=0 AND C1.ritm_cardiac >= 60 AND C1.ritm_cardiac <=100) AS normala, 
		(SELECT count(*) FROM `consultatii` C1 INNER JOIN `persoane` ON persoane.id=C1.idPersoana WHERE C1.id = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND persoane.sters=0 AND C1.ritm_cardiac > 100) AS tahicardie;";
$row = mysqli_fetch_array(mysqli_query($con, $query), MYSQLI_ASSOC);

echo'		<script src="js/chart.js"></script>
                <SCRIPT LANGUAGE="JavaScript">

			var val=new Array('.$row['bradicardie'].', '.$row['normala'].', '.$row['tahicardie'].');
			var cat=new Array("Bradicardie", "Stare normala", "Tahicardie");
			var bars=3;
			var s = 0;
			var useCatColors = true;
			var catColors = new Array("#19a9d5","#5cb85c","#fb3d50");

			var useValColors = false;
			var valColors = new Array("#19a9d5","#1cec41","#fb3a3a");
			var neutralVal = new Array(18, 25);

			var useMultipleVal = false;

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

			chart("chart", "70%", "70%");
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