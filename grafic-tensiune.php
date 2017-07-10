<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Grafic tensiune arteriala pacienti <i class="fa fa-bar-chart" aria-hidden="true"></i></h1>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-lg-12"> 
		<DIV id="chart" style="margin-top: -30px;"></DIV>
<?php

$query = "SELECT (SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis<90) AS hipotensiune, 
		(SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis >= 90 AND C1.tensiune_sis <=120) AS normala, 
		(SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis > 120 AND C1.tensiune_sis <=139) AS prehipertensiune, 
		(SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis > 139 AND C1.tensiune_sis <=159) AS hipertensiune1, 
		(SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis > 159 AND C1.tensiune_sis <=179) AS hipertensiune2, 
		(SELECT count(*) FROM `consultatii` C1 WHERE `id` = (SELECT MAX(`id`) FROM `consultatii` C2 WHERE C1.idPersoana = C2.idPersoana ) AND C1.tensiune_sis > 179) AS urgenta;";
$row = mysqli_fetch_array(mysqli_query($con, $query), MYSQLI_ASSOC);

echo'		<script src="js/chart.js"></script>
                <SCRIPT LANGUAGE="JavaScript">

			var val=new Array('.$row['hipotensiune'].', '.$row['normala'].', '.$row['prehipertensiune'].', '.$row['hipertensiune1'].', '.$row['hipertensiune2'].', '.$row['urgenta'].');
			var cat=new Array("Hipotensiune", "Stare Normala", "Prehipertensiune" , "Hipertensiune1", "Hipertensiune2", "Urgenta");
			var bars=6;
			var s = 0;
			var useCatColors = true;
			var catColors = new Array("#19a9d5","#5cb85c","#fb3d50", "#fb3d50", "#fb3d50", "#fb3d50");

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

			chart("chart", "90%", "90%");
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