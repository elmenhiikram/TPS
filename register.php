<?php 
    include("database.php");
    include("create.php");

    if (isset($_POST['register'])) { 
        // Récupération des données
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $CIN = $_POST['CIN'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = array();

        // Vérification des champs obligatoires
        if (empty($prenom) || empty($nom) || empty($email) || empty($CIN) ||
            empty($password) || empty($confirm_password)) {
            array_push($errors, "All fields are required!");
        }

        // Email valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid.");
        }

        // Longueur du mot de passe
        if (strlen($password) < 6) {
            array_push($errors, "Password must be at least 6 characters long!");
        }

        // Confirmation mot de passe
        if ($password != $confirm_password) {
            array_push($errors, "Passwords do not match!");
        }

        // Vérifier si l'email existe déjà
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            array_push($errors, "Email already exists!");
        }

        // Affichage des erreurs ou insertion
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // Hasher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertion des données
            $stmt = $conn->prepare("INSERT INTO utilisateur (firstname, lastname, email, cin, password)
                                    VALUES (:firstname, :lastname, :email, :cin, :password)");

            $stmt->bindParam(':firstname', $prenom);
            $stmt->bindParam(':lastname', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cin', $CIN);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();
            header("Location: show.php");
            exit(); 

            echo "<div class='alert alert-success'>Utilisateur ajouté avec succès !</div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <title>Registration Form</title>
</head>
<body>
    <div class="container mt-5">
        <form action="register.php" method="post" class="border p-4 rounded shadow-sm mx-auto" style="max-width: 500px;">
            <h3 class="text-center mb-4">Register</h3>

            <div class="form-group">
                <input type="text" name="prenom" class="form-control" placeholder="Prenom :" required>
            </div>

            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom :" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email :" required>
            </div>

            <div class="form-group">
                <input type="text" name="CIN" class="form-control" placeholder="CIN :" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password :" required>
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password :" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary btn-block" name="register">
            </div>
        </form>
    </div>
</body>
</html>
