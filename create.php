<?php
try {
    $sql = "CREATE TABLE IF NOT EXISTS utilisateur (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        cin VARCHAR(10) NOT NULL,
        password VARCHAR(30)
    )";
    $conn->exec($sql);
} catch(PDOException $e) {
    echo "Erreur lors de la création : " . $e->getMessage();
}
?>
