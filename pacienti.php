<?php
include_once 'db.php';
if (!isset($_SESSION['user']))
    header('Location: login.php');

include_once 'header.php';
?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header">Lista pacienti <i class="fa fa-users" aria-hidden="true"></i> <a href="pacienti-adaugare.php" class="btn btn-default pull-right" style="line-height: 26px;"><i class="fa fa-plus" aria-hidden="true"></i> Adauga pacient</a></h1>
            
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12"> 
            </div>
        </div>
    </div>

</div>
<?php
include_once 'footer.php';
?>