<?php
include('includes/database.php');
$added = false;
$notAdded = false;

if (isset($_POST['titre'])){

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM categorie WHERE titre = ?');
    $stmt->execute(array($_POST['titre']));
    if ($stmt->fetchColumn() != 0) {
        $notAdded = true;
    } else {
        $titre = $_POST['titre'];
        $req = $pdo->prepare('INSERT INTO categorie(titre) VALUES (:titre)');
        $req->execute(array('titre'=>$titre));
        $added = true;
        header( "refresh:2 ;url=gestion_categories.php" );
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
            <!-- third party css -->
        <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />    

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
include('includes/topbar.php');
include('includes/leftsidebar.php');
?>

<div id="wrapper">




<!-- DEBUT CONTENU CATEGORIE -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">


            <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Ajout d'une catégorie</h4>
                    </div>
                    <p> <a href="gestion_categories.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Ajout d'une catégorie</h4>

                        <form method="POST" action="ajout_categorie.php" name="ajout">
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input type="titre" name="titre" class="form-control" id="titre" placeholder="Entrer titre">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                        <?php if ($added) { ?>

                        <div class="alert alert-success" role="alert">
                            Catégorie "<?= $_POST['titre']?>" ajoutée avec succès.
                        </div>

                        <?php } else if ($notAdded) {?>

                        <div class="alert alert-danger" role="alert">
                            La catégorie "<?= $_POST['titre']?>" existe déjà.
                        </div>

                        <?php } ?>

                    </div> <!-- end card-box -->
                </div>
            <!-- end col -->
            </div>



        </div>
    </div>
</div>
</div>
        
     

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- datatable js -->
<script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/buttons.html5.min.js"></script>
<script src="assets/libs/datatables/buttons.flash.min.js"></script>
<script src="assets/libs/datatables/buttons.print.min.js"></script>

<script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables/dataTables.select.min.js"></script>

<!-- Datatables init -->
<script src="assets/js/pages/datatables.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>

</html>