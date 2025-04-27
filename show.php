<?php
include("database.php");

try {
    $sql = "SELECT * FROM utilisateur";
    $stmt = $conn->query($sql);
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur lors de la récupération des données : " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Liste des utilisateurs</h3>

    <?php if (count($utilisateurs) > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>CIN</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['firstname']) ?></td>
                        <td><?= htmlspecialchars($user['lastname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['cin']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning mr-2">
                                Modifier
                            </a>
                            <a href="delete.php?id=<?= $user['id'] ?>" 
                               onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"
                               class="btn btn-sm btn-danger">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">Aucun utilisateur trouvé.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="register.php" class="btn btn-success">Ajouter un utilisateur</a>
    </div>
</div>
</body>
</html>
