<?php
include('includes/database.php');
$deleted = false;

if (isset($_GET['suppr'])){
    
    $req = $pdo->exec("DELETE FROM devis WHERE id =".$_GET['suppr']);
    header('gestion_devis.php');
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
                                <h4 class="page-title">Gestion des devis</h4>
                        </div>
                        <p> <a href="index.php"> <i class="fas fa-arrow-left"></i> Retour</a> </p>
                    </div>
                </div> 
                
                <?php if($deleted) {?>
                    <div id="message_suppression" class="alert alert-success" role="alert">
                     Devis supprimé avec succès.
                    </div>
                <?php } ?>
    
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Tous les devis </h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                </thead>
                                <tbody>
    
                                <?php 
                                    $req = $pdo->query('SELECT devis.* ,client.nom AS nomClient, client.prenom AS prenomClient FROM devis, client WHERE devis.id_client=client.id');
                                    $deviss = $req->fetchAll();
                                    foreach($deviss as $devis) :
                                ?>
                               
                                <tr>
                                    <td> <?= $devis['numero'] ?> </td>
                                    <td> <?= $devis['prenomClient']." ".$devis['nomClient'] ?> </td>
                                    <td> <?= $devis['montant'] ?> </td>
                                    <td> <?= $devis['status'] ?> </td>
                                    <td> <?= $devis['date'] ?> </td>
                                    <td> <a href="devis.php?devis=<?= $devis['id'] ?>"><i class="fas fa-edit"></i> </a> </td>
                                    <td> <a onclick="return confirmation();" href="gestion_devis.php?suppr=<?= $devis['id'] ?>"> <i class="fas fa-trash-alt"></i> </a> </td>
                                </tr>                         
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            
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