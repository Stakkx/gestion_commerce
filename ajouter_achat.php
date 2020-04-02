<?php
include('includes/database.php');
$added = false;

if (isset($_POST['ajout_stock'])){

        $req = $pdo->prepare('INSERT INTO achat(id_produit, id_fournisseur, date_achat, prix_achat, quantite) VALUES(?, ?, ?, ?, ?)');
        $req->execute(array($_POST['produit'], $_POST['fournisseur'], $_POST['date_achat'], $_POST['prix_achat'], $_POST['quantite'] ));
        $added = true;
        
        $reqStock = $pdo->prepare("UPDATE produit SET quantite=quantite+? WHERE id =".$_POST['produit']);
        $reqStock->execute(array($_POST['quantite']));
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
            <!-- third party css -->
        <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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


<!-- Begin page -->
<div id="wrapper">




    <!-- DEBUT CONTENU  -->

    <div class="content-page">
        <div class="content">
    
            <!-- Start Content-->
            <div class="container-fluid">
    
    
                <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Gestion des achats</h4>
                        </div>
                        <p> <a href="index.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                    </div>
                </div> 
    
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Ajouter une entrée</h4>
    
                            <form method="POST" action="ajouter_achat.php" name="ajout">
                                <div class="form-group">
                                    
                                <label for="produit-select">Produit</label>
                                <select class="form-control" name="produit">
                                    
                                    <?php 
                                    $req = 'SELECT * FROM produit ORDER BY titre ASC';
                                    $result = $pdo->query($req);
                                    $produits = $result->fetchAll();
                                    
                                    foreach ($produits as $produit) :
                                    ?>
                                    
                                    <option value="<?= $produit['id'] ?>"> <?= $produit['titre'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                    
                                <label for="fournisseur-select">Fournisseur</label>
                                <select class="form-control" name="fournisseur">
                                    
                                    <?php 
                                    $req2 = 'SELECT * FROM fournisseur ORDER BY nom ASC';
                                    $result2 = $pdo->query($req2);
                                    $fournisseurs = $result2->fetchAll();
                                    
                                    foreach ($fournisseurs as $fournisseur) :
                                    ?>
                                    
                                    <option value="<?= $fournisseur['id'] ?>"> <?= $fournisseur['nom'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                    
                                    <label for="date_achat">Date d'achat</label>
                                    <input name="date_achat" id="date" data-date-format="DD MMMM YYYY" type="date" required="" class="form-control" value="">
                                    
                                    <label for="prix_achat">Prix d'achat</label>
                                    <input name="prix_achat" class="form-control">
                                    
                                    <label for="quantite">Quantité</label>
                                    <input name="quantite" class="form-control">
                                    
                                    
                                </div>
                                <button type="submit" name="ajout_stock" class="btn btn-primary">Ajouter</button>
                            </form>
                            
                            <?php if ($added) { ?>
    
                            <div class="alert alert-success" role="alert">
                                Achat pour le produit "<?= $produit['titre']?>" ajouté avec succès.
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