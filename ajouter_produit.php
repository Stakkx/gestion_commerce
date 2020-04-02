<?php
include('includes/database.php');
$added = false;
$notAdded = false;

$req2 = 'SELECT * FROM categorie ORDER BY titre ASC';
$result2 = $pdo->query($req2);
$allCategories = $result2->fetchAll();

if (isset($_POST['submit'])){

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM produit WHERE titre = ?');
    $stmt->execute(array($_POST['titre']));
    if ($stmt->fetchColumn() != 0) {
        $notAdded = true;
    } else {

        $req = $pdo->prepare('INSERT INTO produit(titre, id_categorie, prix_achat, prix_vente, quantite, quantite_minimal, poids, code_barre, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute(array($_POST['titre'], $_POST['categorie'], $_POST['prix_achat'], $_POST['prix_vente'], $_POST['quantite'], $_POST['quantite_minimal'], $_POST['poids'], $_POST['code_barre'], $_POST['image'] ));
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
                            <h4 class="page-title">Ajout d'un produit</h4>
                    </div>
                    <p> <a href="gestion_produits.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Ajout d'un produit</h4>

                        <form method="POST" action="ajouter_produit.php" name="ajout">
                            <div class="form-group">
                                
                                <label for="titre">Titre</label>
                                <input name="titre" class="form-control">
                                
                               <label for="pet-select">Choisir une catégorie:</label>

                                <select class="form-control" name="categorie">
                                    
                                    <?php 
                                    foreach ($allCategories as $categorie) :
                                    ?>
                                    
                                    <option value="<?= $categorie['id'] ?>"> <?= $categorie['titre'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                                <label for="titre">Prix d'achat (€)</label>
                                <input name="prix_achat" class="form-control">
                                
                                <label for="titre">Prix de vente (€)</label>
                                <input name="prix_vente" class="form-control">
                                
                                <label for="titre">Quantité</label>
                                <input name="quantite" class="form-control">
                                
                                <label for="titre">Quantité minimum à avoir en stock</label>
                                <input name="quantite_minimal" class="form-control">
                                
                                <label for="titre">Poids (gramme)</label>
                                <input  name="poids" class="form-control">
                                
                                <label for="titre">Code barre</label>
                                <input  name="code_barre" class="form-control">
                                
                                <label for="titre">URL image</label>
                                <input name="image" class="form-control">
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                        <?php if ($added) { ?>

                        <div class="alert alert-success" role="alert">
                            Produit "<?= $_POST['titre']?>" ajoutée avec succès.
                        </div>

                        <?php } else if ($notAdded) {?>

                        <div class="alert alert-danger" role="alert">
                            Le produit "<?= $_POST['titre']?>" existe déjà.
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