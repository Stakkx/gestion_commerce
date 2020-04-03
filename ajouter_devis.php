<?php
include('includes/database.php');
$added = false;

if (isset($_POST['submit'])){
    
    $req78 = $pdo->query('SELECT MAX(id) AS id FROM devis');
    $dernierDevis = $req78->fetch();
    
    
    //Insert du devis
    $req = $pdo->prepare('INSERT INTO devis(id_client, numero, date, montant, deleted) VALUES (?, ?, ?, ?, ?)');
    $req->execute(array($_POST['id_client'], $dernierDevis['id'], $_POST['date'], $_POST['montant'], $_POST['deleted']));
    $added = true;

    $j =  $pdo->lastInsertId();
    
    //insert du détails devis
    $req5 = $pdo->prepare('INSERT INTO details_devis(id_produit, id_devis, quantite, prix_unitaire) VALUES (?, ?, ?, ?)');
    $req5->execute(array($_POST['id_produit'], $j, $_POST['quantite'], $_POST['prix_unitaire']));
    header("Location: devis.php?devis=$j");
    

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <!-- Plugins css -->
        <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet">
        <link href="assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" />
        <link href="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
        <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />        

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
                            <h4 class="page-title">Ajout d'un devis</h4>
                    </div>
                    <p> <a href="gestion_devis.php"> <i class="fas fa-arrow-left"></i> Gestion devis</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Ajout d'un produit au devis</h4>

                        <form method="POST" action="ajouter_devis.php" name="ajout">
                            <div class="form-group">
                                
                                
                                <label for="client-select">Client</label>
                                <select class="form-control" data-toggle="select2" name="id_client">
                                    <?php 
                                    $req2 = 'SELECT * FROM client ORDER BY nom ASC';
                                    $result2 = $pdo->query($req2);
                                    $clientListe = $result2->fetchAll();
                                    
                                    foreach ($clientListe as $client) :
                                    ?>
                                    
                                    <option value="<?= $client['id'] ?>"> <?= $client['prenom']." ".$client['nom'] ?> </option>
                                    
                                    <?php endforeach; ?>
                                </select>
                                </div>
                                
                                <div class="form-row align-items-center">
                                    <div class="form-group col-md-3">
                                        <label for="produit-select">Produit</label>
                                        <select class="form-control" data-toggle="select2" name="id_produit">
                                            <?php 
                                            $req3 = 'SELECT * FROM produit ORDER BY titre ASC';
                                            $result3 = $pdo->query($req3);
                                            $produitListe = $result3->fetchAll();
                                            
                                            foreach ($produitListe as $produit) :
                                            ?>
                                            
                                            <option value="<?= $produit['id'] ?>"> <?= $produit['titre']?> </option>
                                            
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label for="quantite">Quantité</label>
                                        <input type="number" name="quantite" class="form-control">
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label for="prix_unitaire">Prix unitaire</label>
                                        <input type="number" name="prix_unitaire" class="form-control">
                                    </div>
                                    
                                    <input type="hidden" name="date" class="form-control" value="<?= date("Y-m-d H:i:s"); ?>">
                                    
                                    <input type="hidden" name="numero" class="form-control" value="<?= $produit['id']; ?>">
                                    <input type="hidden" name="deleted" class="form-control" value="0">
                                    <input type="hidden" name="montant" class="form-control" value="10">
                                
                                    
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>

                        <?php if ($added) { ?>

                        <div class="alert alert-success" role="alert">
                            Devis ajouté avec succès.
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

<!-- select2 js -->
<script src="assets/libs/select2/select2.min.js"></script>
<script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/libs/switchery/switchery.min.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<!-- Mask input -->
<script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
<!-- Bootstrap Select -->
<script src="assets/libs/bootstrap-select/bootstrap-select.min.js"></script>

<script src="assets/libs/moment/moment.min.js"></script>
<script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<script src="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

<script src="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script src="assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Init js-->
<script src="assets/js/pages/form-advanced.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>

</html>