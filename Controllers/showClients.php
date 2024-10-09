<?php
include 'connexion.php';
ob_start();

// Captura el término de búsqueda
$searchTerm = $conn->real_escape_string(isset($_POST['search']) ? $_POST['search'] : '');

// Separamos el término de búsqueda en palabras
$searchTerms = explode(" ", $searchTerm);
$sql = "SELECT * FROM client WHERE ";
$conditions = [];

foreach ($searchTerms as $term) {
    // Escapamos cada término para evitar inyecciones SQL
    $term = $conn->real_escape_string($term);
    $conditions[] = "(nom_client LIKE '%$term%' OR prenom_client LIKE '%$term%')";
}
$sql .= implode(" AND ", $conditions); 

// Ordena por nombre del cliente
$sql .= " ORDER BY nom_client ASC";



$result = $conn->query($sql);

// Verifica si la consulta se ejecutó correctamente
if (!$result) {
    echo "Error executing query: " . $conn->error;
    exit;
}

// Si hay resultados, los mostramos en una tabla
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
                <th>Status</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        // Obtener el total de órdenes y la cantidad total
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
                <td>" . $row["status"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No clients found.";
}

$conn->close();
$output = ob_get_clean();

?>
