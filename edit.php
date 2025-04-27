<?php
include("database.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch();

        if (!$user) {
            echo "<div class='alert alert-warning'>Utilisateur non trouvé.</div>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-warning'>Aucun ID spécifié.</div>";
    exit();
}

// Traitement du formulaire de modification
if (isset($_POST['update'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $cin = $_POST['cin'];

    try {
        $stmt = $conn->prepare("UPDATE utilisateur SET firstname = :firstname, lastname = :lastname, email = :email, cin = :cin WHERE id = :id");
        $stmt->bindParam(':firstname', $prenom);
        $stmt->bindParam(':lastname', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cin', $cin);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        header("Location: show.php");
        exit();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour : " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Modifier Utilisateur</h3>

    <form method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width: 500px;">
        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['firstname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['lastname']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>CIN :</label>
            <input type="text" name="cin" class="form-control" value="<?= htmlspecialchars($user['cin']) ?>" required>
        </div>

        <div class="form-group">
            <input type="submit" name="update" value="Mettre à jour" class="btn btn-primary btn-block">
        </div>

        <div class="form-group text-center">
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
</body>
</html>
