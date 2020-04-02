<?php
include('includes/database.php');
$deleted = false;

if (isset($_GET['suppr'])){
    
    $reqProduit = 'SELECT achat.*, produit.quantite AS quantiteAchat FROM achat, produit WHERE achat.id_produit = produit.id AND achat.id='.$_GET['suppr'];
    $resultProduit = $pdo->query($reqProduit);
    $achat = $resultProduit->fetch();
    
    $reqStock = $pdo->prepare("UPDATE produit SET quantite=quantite-? WHERE id =".$achat['id_produit']);
    $reqStock->execute(array($achat['quantite']));
    
    
    $req = $pdo->exec("DELETE FROM achat WHERE id =".$_GET['suppr']);
    header('gestion_achats.php');
    $deleted = true;
    

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
                
                <?php if($deleted) {?>
                    <div id="message_suppression" class="alert alert-success" role="alert">
                     Achat supprimé avec succès.
                    </div>
                <?php } ?>
    
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Choisir un produit</h4>
    
                            <form method="POST" action="gestion_achats.php" name="ajout">
                                
                                <label for="article">Produit</label>

                                <select class="form-control" name="article">
                                    
                                    <?php 
                                    $req2 = 'SELECT * FROM produit ORDER BY titre ASC';
                                    $result = $pdo->query($req2);
                                    $produits = $result->fetchAll();
                                    
                                    foreach ($produits as $produit) :
                                    ?>
                                    
                                    <option value="<?= $produit['id'] ?>"> <?= $produit['titre'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                                <button type="submit" name="submit" class="btn btn-primary">Valider</button>
                            </form>
                            
                        </div> <!-- end card-box -->
                        
                    </div> <!-- end col -->
                    
                </div> <!-- end row -->
                
                <?php if(isset($_POST['submit'])){ ?>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Historique d'achats </h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Code barre</th>
                                    <th>Fournisseur</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Dernier achat</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                </thead>
                                <tbody>
    
                                <?php 
                                    $req = $pdo->query('SELECT achat.*,produit.titre AS nomProduit, fournisseur.nom AS nomFourbnisseur, produit.code_barre AS code_barre FROM achat,produit, fournisseur WHERE achat.id_produit=produit.id AND achat.id_fournisseur=fournisseur.id AND produit.id='.$_POST['article']);
                                    $achats = $req->fetchAll();
                                    foreach($achats as $achat) :
                                ?>
                               
                                <tr>
                                    <td> <?= $achat['id'] ?> </td>
                                    <td> <?= $achat['nomProduit'] ?> </td>
                                    <td> <?= $achat['code_barre'] ?> </td>
                                    <td> <?= $achat['nomFourbnisseur'] ?> </td>
                                    <td> <?= $achat['quantite'] ?> </td>
                                    <td> <?= $achat['prix_achat'] ?> </td>
                                    <td> <?= $achat['date_achat'] ?> </td>
                                    <td> <a href="modifier_achat.php?id=<?= $achat['id'] ?>"><i class="fas fa-edit"></i> </a> </td>
                                    <td> <a onclick="return confirmation();" href="gestion_achats.php?suppr=<?= $achat['id'] ?>"> <i class="fas fa-trash-alt"></i> </a> </td>
                                </tr>                         
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
                
                    <?php } ?>
            
            </div>
        </div>
    </div>
</div>

<script>
    //FONCTION POUR CONFIRMER LA SUPRESSION
    function confirmation(){
        if ( confirm( "Êtes-vous sûre de vouloir supprimer cette entrée ?" ) ) {
            return true;
        } else {
            return false;
        }
    }
</script>


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