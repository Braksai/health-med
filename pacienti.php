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
            <form action="" id="cautare-pacient" method="GET" accept-charset="UTF-8" class="form-wrapper">
<!--                <div>
                    <div class="col-lg-6 col-lg-offset-3">-->
                        <input title="Cautare pacient dupa nume, prenume sau cnp..." 
                               placeholder="Cautare pacient dupa nume, prenume sau cnp..." 
                               autocomplete="off" 
                               tabindex="1" 
                               type="text" 
                               name="search" 
                               id="search"
                               value="<?php echo !empty($querySearch) ? $querySearch : '';?>" 
                               size="32" 
                               maxlength="128" 
                               class="form-control"
                               style="height: 42px;">
                        <!--<input type="submit" value="go" id="submit">-->
                        <a href="javascript:{}" onclick="document.getElementById('cautare-pacient').submit(); return false;" id="submit"><i class="fa fa-search" aria-hidden="true"></i> Cauta</a>
                        <!--<button type="submit" id="submit" name="submit"><i class="fa fa-search" aria-hidden="true"></i> Cauta</button>-->
<!--                    </div>
                </div>-->
            </form>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr><th>Nume</th><th>Prenume</th><th>C.N.P.</th><th>Telefon</th><th>Actiuni</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>s</td><td>s</td><td>s</td><td>s</td><td>s</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include_once 'footer.php';
?>