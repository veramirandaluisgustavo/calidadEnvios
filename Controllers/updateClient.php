<?php
include 'connexion.php';

$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$status = $_POST['status']; // Captura el nuevo estado

$sql = "UPDATE client 
SET nom_client = '$nom', 
prenom_client = '$prenom', 
adresse_client = '$adresse', 
telephone_client = '$telephone', 
status = '$status' 
WHERE Id_client = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: ../views/allClients.php');
} else {
    echo "Error updating record: " . $conn->error;
}
?>
