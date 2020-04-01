<?php
include('includes/database.php');
$modif = false;


if (isset($_POST['submit'])){
    $update = $pdo->prepare("UPDATE client SET nom=?, prenom=?, email=?, adresse=?, code_postal=?, id_pays=?, solde=? WHERE id =".$_GET['id']);
    $update->execute(array($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['adresse'], $_POST['code_postal'], $_POST['id_pays'], $_POST['solde']));
    $modif = true;
    header("Refresh");
}

if (isset($_GET['id'])){
    $req = $pdo->query("SELECT * FROM client WHERE id=".$_GET['id']);
    $client = $req->fetch();
    
    $req2 = 'SELECT * FROM pays ORDER BY countryName ASC';
    $result2 = $pdo->query($req2);
    $paysListe = $result2->fetchAll();
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
                            <h4 class="page-title">Modifier un client</h4>
                    </div>
                    <p> <a href="gestion_clients.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Modifier un client</h4>

                        <form method="POST" action="modifier_client.php?id=<?= $client['id'] ?>" name="modification">
                            <div class="form-group">
                                
                                <label for="nom">Nom</label>
                                <input name="nom" class="form-control" value="<?= $client['nom']; ?>">
                                
                                <label for="prenom">Prénom</label>
                                <input name="prenom" class="form-control" value="<?= $client['prenom']; ?>">
                                
                                <label for="email">Email</label>
                                <input name="email" class="form-control" value="<?= $client['email']; ?>">
                                
                                <label for="adresse">Adresse</label>
                                <input name="adresse" class="form-control" value="<?= $client['adresse']; ?>">
                                
                                <label for="code_postal">Code postal</label>
                                <input name="code_postal" class="form-control" value="<?= $client['code_postal']; ?>">
                                
                                <label for="country-select">Pays</label>

                                <select class="form-control" name="id_pays">
                                    
                                    <?php 
                                    foreach ($paysListe as $pays) :
                                    ?>
                                    
                                    <option <?php if($client['id_pays']==$pays['id']) echo "selected" ?>  value="<?= $pays['id'] ?>"> <?= $pays['countryName'] ?> </option>
                                    
                                    <?php endforeach; ?>

                                </select>
                                
                                <label for="solde">Solde</label>
                                <input name="solde" class="form-control" value="<?= $client['solde']; ?>">
                                
                                
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                        </form>

                        <?php
                        if ($modif) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Client "<?= $_POST['nom']?>" modifié avec succès.
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