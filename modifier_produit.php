<?php
include('includes/database.php');
$modif = false;


if (isset($_POST['titre'])){
    $update = $pdo->prepare("UPDATE produit SET titre= ?, id_categorie=?, id_fournisseur=?, prix_achat=?, prix_vente=?, quantite=?, quantite_minimal=?, poids=?, code_barre=?, image=? WHERE id =".$_GET['id']);
    $update->execute(array($_POST['titre'], $_POST['categorie'], $_POST['fournisseur'], $_POST['prix_achat'], $_POST['prix_vente'], $_POST['quantite'], $_POST['quantite_minimal'], $_POST['poids'], $_POST['code_barre'], $_POST['image']));
    $modif = true;
    header("Refresh");
}

if (isset($_GET['id'])){
    $req = $pdo->query("SELECT * FROM produit WHERE id=".$_GET['id']);
    $produit = $req->fetch();
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
                            <h4 class="page-title">Modifier un produit</h4>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Modifier un produit</h4>

                        <form method="POST" action="modifier_produit.php?id=<?= $produit['id'] ?>" name="modification">
                            <div class="form-group">
                                
                                <label for="titre">Titre</label>
                                <input type="titre" name="titre" class="form-control" value="<?= $produit['titre']; ?>">
                                
                                <label for="titre">Catégorie</label>
                                <input type="titre" name="categorie" class="form-control" value="<?= $produit['id_categorie']; ?>">
                                
                                <label for="titre">Fournisseur</label>
                                <input type="titre" name="fournisseur" class="form-control" value="<?= $produit['id_fournisseur']; ?>">
                                
                                <label for="titre">Prix d'achat (€)</label>
                                <input type="titre" name="prix_achat" class="form-control" value="<?= $produit['prix_achat']; ?>">
                                
                                <label for="titre">Prix de vente (€)</label>
                                <input type="titre" name="prix_vente" class="form-control" value="<?= $produit['prix_vente']; ?>">
                                
                                <label for="titre">Quantité</label>
                                <input type="titre" name="quantite" class="form-control" value="<?= $produit['quantite']; ?>">
                                
                                <label for="titre">Quantité minimum à avoir en stock</label>
                                <input type="titre" name="quantite_minimal" class="form-control" value="<?= $produit['quantite_minimal']; ?>">
                                
                                <label for="titre">Poids (gramme)</label>
                                <input type="titre" name="poids" class="form-control" value="<?= $produit['poids']; ?>">
                                
                                <label for="titre">Code barre</label>
                                <input type="titre" name="code_barre" class="form-control" value="<?= $produit['code_barre']; ?>">
                                
                                <label for="titre">URL image</label>
                                <input type="titre" name="image" class="form-control" value="<?= $produit['image']; ?>">
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                        </form>

                        <?php
                        if ($modif) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Produit "<?= $_POST['titre']?>" modifiée avec succès.
                        </div>
                        <?php
                        }
                        ?>      

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