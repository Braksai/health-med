<?php
include_once 'db.php';
if(!isset($_SESSION['user']))header('Location: login.php');

include_once 'header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Bun venit pe pagina de administrare.</h1>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
?>