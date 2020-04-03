<?php
include('includes/database.php');

if (isset($_GET['suppr'])){
    
    $prod = $_GET['prod'];
    $sup = $_GET['suppr'];
    
    $req9 = $pdo->exec("DELETE FROM details_devis WHERE id_produit=$prod AND id_devis =$sup");
    header("Location: devis.php?devis=".$_GET['suppr']);

}

if (isset($_GET['devis'])){
    
    $req = $pdo->query('SELECT d.*, c.nom AS nomClient, c.prenom as prenomClient FROM devis d, client c WHERE c.id = d.id_client AND d.id='.$_GET['devis']);
    $devis = $req->fetch();

}

if (isset($_POST['submit'])){
    
   //CONDITION POUR UP LA QUANTITE SI LE PRODUIT EXISTE DEJA DANS LE DEVIS
   
    $selectSql = "SELECT id_produit FROM details_devis WHERE id_devis = ".$_POST['id_devis'];
    $result = $pdo->prepare($selectSql);
    $result->execute();
    $productList = $result->fetchAll(PDO::FETCH_COLUMN, 0);

    if (in_array($_POST['id_produit'], $productList)) {
        
        $dataUpdate = [
        "productId" => $_POST['id_produit'],
        "quantity"  => $_POST['quantite'],
        "devisID"  => $_POST['id_devis']
        ];
        
        $sqlUpdate = "UPDATE `details_devis` SET 
        
                quantite = quantite + :quantity
                
                WHERE id_produit = :productId
                
                AND id_devis = :devisID
                
                ";
                
        $update = $pdo->prepare($sqlUpdate);
        $update->execute($dataUpdate);
        
       
        $req = $pdo->query('SELECT d.*, c.nom AS nomClient, c.prenom as prenomClient FROM devis d, client c WHERE c.id = d.id_client AND d.id='.$_POST['id_devis']);
        $devis = $req->fetch();
        
       /* $update = $pdo->prepare("UPDATE details_devis SET quantite=quantite+? WHERE id_produit =".$_POST['id_produit']);
        $update->execute(array($_POST['quantite']));
        header("refresh");*/

    } else {
   
        $req = $pdo->query('SELECT d.*, c.nom AS nomClient, c.prenom as prenomClient FROM devis d, client c WHERE c.id = d.id_client AND d.id='.$_POST['id_devis']);
        $devis = $req->fetch();

        $req45 = $pdo->prepare('INSERT INTO details_devis(id_produit, id_devis, quantite, prix_unitaire) VALUES (?, ?, ?, ?)');
        $req45->execute(array($_POST['id_produit'], $_POST['id_devis'], $_POST['quantite'], $_POST['prix_unitaire']));
        header("refresh");
    }
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
                            <h4 class="page-title">Devis</h4>
                    </div>
                    <p> <a href="gestion_devis.php"> <i class="fas fa-arrow-left"></i> Retour </a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Devis n° <?php if (isset($devis['numero'])) echo $devis['numero']; else echo $_POST['numero_devis'];  ?> </h4>
                        <h4 class="header-title mb-3 text-right">Client : <?php if(isset($devis['prenomClient']) && isset($devis['nomClient'])) echo $devis['prenomClient']." ".$devis['nomClient'];  ?> </h4>
                        
                        
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <p class="sub-header">Devis actuel</p>
        
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Quantite</th>
                                                    <th>Prix unitaire (€)</th>
                                                    <th>Supprimer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php 
                                                if (isset($_GET['devis'])){
                                                    $id = $_GET['devis']; 
                                                    
                                                } else { 
                                                    $id = $_POST['id_devis']; 
                                                    
                                                }
                                                
                                                $req27 = $pdo->query('SELECT de.*, p.titre as nomProduit FROM details_devis de, produit p WHERE p.id=de.id_produit AND id_devis ='.$id );
                                                $details_devis = $req27->fetchAll();
                                                
                                                foreach($details_devis as $details) :?>
                                                <tr>
                                                    <td> <?= $details['nomProduit'] ?> </td>
                                                    <td><?= $details['quantite'] ?></td>
                                                    <td><?= $details['prix_unitaire'] ?></td>
                                                    <td> <a onclick="return confirmation();" href="devis.php?suppr=<?= $id ?>&prod=<?= $details['id_produit'] ?>"> <i class="fas fa-trash-alt"></i> </a> </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div> <!-- end card-box -->
                            </div>
                        </div>
                        

                        <form method="POST" action="devis.php" name="ajout">
                                
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
                                        <input type="hidden" name="id_devis" class="form-control" value="<?= $id ?>">
                                        <input type="hidden" name="numero_devis" class="form-control" value="<?= $devis['numero'] ?>">
                                    </div>
                        
                                <div class="form-group col-md-3">
                                    <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>

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