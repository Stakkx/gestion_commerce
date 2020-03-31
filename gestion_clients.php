<?php
include('includes/database.php');
$deleted = false;

if (isset($_GET['suppr'])){
    $req = $pdo->exec("DELETE FROM client WHERE id =".$_GET['suppr']);
    header('gestion_clients.php');
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


<!-- DEBUT CONTENU CATEGORIE -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">


        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Gestion des clients</h4>
                </div>
             </div>
        </div> 

        <?php if($deleted) {?>
            <div id="message_suppression" class="alert alert-success" role="alert">
                 Client supprimé avec succès.
            </div>
        <?php } ?>
                
            <div class="row">
                <div class="col-12">
                    <div class="card-box">

                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Code postal</th>
                                <th>Pays</th>
                                <th>Solde</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php 
                                $req = 'SELECT * FROM client';
                                $result = $pdo->query($req);
                                $clients = $result->fetchAll();
                                
                                foreach($clients as $client) :
                            ?>
                           
                            <tr>
                                <td> <?= $client['id'] ?> </td>
                                <td> <?= $client['nom'] ?> </td>
                                <td> <?= $client['prenom'] ?> </td>
                                <td> <?= $client['email'] ?> </td>
                                <td> <?= $client['adresse'] ?> </td>
                                <td> <?= $client['code_postal'] ?> </td>
                                <td> <?= $client['id_pays'] ?> </td>
                                <td> <?= $client['solde'] ?> </td>
                                <td> <a href="modifier_client.php?id=<?= $client['id'] ?>"><i class="fas fa-edit"></i> </a> </td>
                                <td> <a onclick="return confirmation();" href="gestion_clients.php?suppr=<?= $client['id'] ?>"> <i class="fas fa-trash-alt"></i> </a> </td>
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
    //FONCTION EN JS POUR CONFIRMER LA SUPRESSION
    function confirmation(){
        if ( confirm( "Êtes-vous sûre de vouloir supprimer cette entrée ?" ) ) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script> 
    let temp=document.getElementById('message_suppression');
    setTimeout('temp.style.display="none"',3000);
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
