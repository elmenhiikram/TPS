<?php
include("database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Redirection vers la liste après suppression
        header("Location: show.php");
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression : " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Aucun ID spécifié pour la suppression.</div>";
}
?>
