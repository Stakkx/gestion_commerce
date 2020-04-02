<?php
include('includes/database.php');
$added = false;
$notAdded = false;

if (isset($_POST['submit'])){

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM fournisseur WHERE nom = ?');
    $stmt->execute(array($_POST['nom']));
    if ($stmt->fetchColumn() != 0) {
        $notAdded = true;
    } else {
        $req = $pdo->prepare('INSERT INTO fournisseur(nom, adresse, code_postal, id_pays) VALUES (?, ?, ?, ?)');
        $req->execute(array($_POST['nom'], $_POST['adresse'], $_POST['code_postal'], $_POST['id_pays']));
        $added = true;
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
                            <h4 class="page-title">Ajout d'un fournisseur</h4>
                    </div>
                    <p> <a href="gestion_fournisseurs.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Ajout d'un fournisseur</h4>

                        <form method="POST" action="ajouter_fournisseur.php" name="ajout">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input name="nom" class="form-control">
                                
                                <label for="adresse">Adresse</label>
                                <input name="adresse" class="form-control">
                                
                                <label for="code_postal">Code Postal</label>
                                <input name="code_postal" class="form-control">
                                
                                <label for="country-select">Pays</label>

                                <select class="form-control" name="id_pays">
                                    
                                    <?php 
                                    $req2 = 'SELECT * FROM pays ORDER BY countryName ASC';
                                    $result2 = $pdo->query($req2);
                                    $paysListe = $result2->fetchAll();
                                    
                                    foreach ($paysListe as $pays) :
                                    ?>
                                    
                                    <option value="<?= $pays['id'] ?>"> <?= $pays['countryName'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                        <?php if ($added) { ?>

                        <div class="alert alert-success" role="alert">
                            Fournisseur "<?= $_POST['nom']?>" ajouté avec succès.
                        </div>

                        <?php } else if ($notAdded) {?>

                        <div class="alert alert-danger" role="alert">
                            Le fournisseur "<?= $_POST['nom']?>" existe déjà.
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