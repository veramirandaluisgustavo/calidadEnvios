<?php
include 'connexion.php';
ob_start();

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

$sql = "SELECT * FROM client WHERE Id_user = " . $_SESSION['logged_user']['Id_user'];
if ($searchTerm) {
    $sql .= " AND (nom_client LIKE '%$searchTerm%' OR prenom_client LIKE '%$searchTerm%')";
}
$sql .= " ORDER BY nom_client ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Family Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Number of Orders</th>
                <th>Total Quantity</th>
                <th>Status</th>  <!-- Nueva columna de estado -->
                <th>Actions</th>  <!-- Acciones: Editar y Eliminar -->
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $sql_orders = "SELECT COUNT(Id_commande) AS total FROM commande WHERE Id_client = " . $row["Id_client"];
        $query_orders = $conn->query($sql_orders);
        $count_orders = $query_orders->fetch_assoc();

        $sql_quantity = "SELECT SUM(quantite) AS total FROM commande WHERE Id_client = " . $row["Id_client"];
        $query_quantity = $conn->query($sql_quantity);
        $count_quantity = $query_quantity->fetch_assoc();

        echo "<tr>
                <td>" . $row["Id_client"] . "</td>                
                <td>" . $row["nom_client"] . "</td>
                <td>" . $row["prenom_client"] . "</td>
                <td>" . $row["adresse_client"] . "</td>
                <td>" . $row["telephone_client"] . "</td>
                <td>" . $count_orders['total'] . "</td>
                <td>" . $count_quantity['total'] . "</td>
                <td>" . $row["status"] . "</td> <!-- Mostrar el estado aquí -->
                <td>
                    <form method='post' action='../views/editClient.php'>
                        <button type='submit' name='edit' value='".$row["Id_client"]."'>Edit</button>
                    </form>
                    <form method='post' action='../controllers/deleteClient.php'>
                        <button type='submit' name='delete' value='".$row["Id_client"]."'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
$output = ob_get_clean();
?>
