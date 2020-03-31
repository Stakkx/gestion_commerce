<?php
include('includes/database.php');
$added = false;
$notAdded = false;

if (isset($_POST['prenom'])){

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM client WHERE nom = ? AND prenom= ?');
    $stmt->execute(array($_POST['nom'], $_POST['prenom']));
    if ($stmt->fetchColumn() != 0) {
        $notAdded = true;
    } else {
        $req = $pdo->prepare('INSERT INTO client(email, nom, prenom, adresse, code_postal, id_pays, solde) VALUES(?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($_POST['email'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['code_postal'], $_POST['id_pays'], $_POST['solde'] ));
        $added = true;
        header( "refresh:2 ;url=gestion_clients.php" );
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
                            <h4 class="page-title">Ajout d'un client</h4>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Ajout d'un client</h4>

                        <form method="POST" action="ajouter_client.php" name="ajout">
                            <div class="form-group">
                                
                                <label for="nom">Nom</label>
                                <input name="nom" class="form-control">
                                
                                <label for="prenom">Prénom</label>
                                <input name="prenom" class="form-control">
                                
                                <label for="email">Email</label>
                                <input name="email" class="form-control">
                                
                                <label for="adresse">Adresse</label>
                                <input name="adresse" class="form-control">
                                
                                <label for="code_postal">Code postal</label>
                                <input name="code_postal" class="form-control">
                                
                                <label for="pays">Pays</label>
                                <input name="id_pays" class="form-control">
                                
                                <label for="solde">Solde</label>
                                <input name="solde" class="form-control">
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                        <?php if ($added) { ?>

                        <div class="alert alert-success" role="alert">
                            Client "<?= $_POST['nom']?>" ajoutée avec succès.
                        </div>

                        <?php } else if ($notAdded) {?>

                        <div class="alert alert-danger" role="alert">
                            Le client "<?= $_POST['nom']?>" existe déjà.
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