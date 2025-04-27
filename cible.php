<?php
$firstname = $lastname = $email = $phonenumber = $age = "";
$uploaded_file_path = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phonenumber = htmlspecialchars(trim($_POST['phonenumber']));
    $age = htmlspecialchars(trim($_POST['age']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    $upload_dir = "uploads/";

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_name = uniqid('img_') . "." . $file_ext;
            $destination = $upload_dir . $new_name;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($file_tmp, $destination)) {
                $uploaded_file_path = $destination;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .info {
            text-align: left;
            font-size: 16px;
        }

        .info p {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
            margin: 8px 0;
        }

        .info img {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Data Received</h2>
    <div class="info">
        <p><strong>First Name:</strong> <?= $firstname ?></p>
        <p><strong>Last Name:</strong> <?= $lastname ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <p><strong>Phone Number:</strong> <?= $phonenumber ?></p>
        <p><strong>Age:</strong> <?= $age ?></p>

        <?php if ($uploaded_file_path): ?>
            <p><strong>Profile Picture:</strong><br>
                <img src="<?= $uploaded_file_path ?>" alt="Profile Picture">
            </p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

