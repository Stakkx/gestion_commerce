<?php
include('includes/database.php');
$modif = false;


if (isset($_POST['submit'])){
    
    //Modif de l'achat
    $update = $pdo->prepare("UPDATE produit SET quantite=quantite+? WHERE id =".$_POST['id_produit']);
    if($_POST['quantite'] > $_POST['ancienne_quantite']){
        $update->execute(array($_POST['quantite']-$_POST['ancienne_quantite']));
    } else {
        $update->execute(array(-($_POST['ancienne_quantite']-$_POST['quantite'])));
    }
    
    //Modif du stock du produit
    $update = $pdo->prepare("UPDATE achat SET id_produit=?, id_fournisseur=?, date_achat=?, prix_achat=?, quantite=? WHERE id =".$_GET['id']);
    $update->execute(array($_POST['id_produit'], $_POST['id_fournisseur'], $_POST['date_achat'], $_POST['prix_achat'], $_POST['quantite']));
    
    $modif = true;
    header("Refresh");
}

if (isset($_GET['id'])){
    $req = $pdo->query("SELECT * FROM achat WHERE id=".$_GET['id']);
    $achat = $req->fetch();
    
    $req2 = 'SELECT * FROM produit ORDER BY titre ASC';
    $result2 = $pdo->query($req2);
    $produitListe = $result2->fetchAll();
    
    $req3 = 'SELECT * FROM fournisseur ORDER BY nom ASC';
    $result3 = $pdo->query($req3);
    $fournisseurListe = $result3->fetchAll();
    
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
                            <h4 class="page-title">Modifier un achat</h4>
                    </div>
                    <p> <a href="gestion_achats.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Modifier un achat</h4>

                        <form method="POST" action="modifier_achat.php?id=<?= $achat['id'] ?>" name="modification">
                            <div class="form-group">
                                
                                <label for="produit-select">Produit</label>
                                <select class="form-control" name="id_produit">
                                    
                                    <?php 
                                    foreach ($produitListe as $produit) :
                                    ?>
                                    
                                    <option <?php if($achat['id_produit']==$produit['id']) echo "selected" ?>  value="<?= $produit['id'] ?>"> <?= $produit['titre'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                                <label for="fournisseur-select">Fournisseur</label>
                                <select class="form-control" name="id_fournisseur">
                                    
                                    <?php 
                                    foreach ($fournisseurListe as $fournisseur) :
                                    ?>
                                    
                                    <option <?php if($achat['id_fournisseur']==$fournisseur['id']) echo "selected" ?>  value="<?= $fournisseur['id'] ?>"> <?= $fournisseur['nom'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                                <label for="date_achat">Date d'achat</label>
                                <input type="datetime" name="date_achat" class="form-control" value="<?= $achat['date_achat']; ?>">
                                
                                <label for="prix_achat">Prix achat</label>
                                <input name="prix_achat" class="form-control" value="<?= $achat['prix_achat']; ?>">
                                
                                <label for="quantite">Quantite</label>
                                <input name="quantite" class="form-control" value="<?= $achat['quantite']; ?>">
                                
                                <input type="hidden" name="ancienne_quantite" class="form-control" value="<?= $achat['quantite']; ?>">
                                
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                        </form>

                        <?php
                        if ($modif) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Achat modifié avec succès.
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