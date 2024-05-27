<?php
session_start(); // Démarrer la session

// Vérifier si la variable de session id_mod est définie
if(isset($_SESSION['id_mod'])) {
    $id_mod = $_SESSION['id_mod'];
} else {
    // Si la variable de session n'est pas définie, rediriger l'utilisateur vers une page appropriée ou afficher un message d'erreur
    header("Location: page_d'erreur.php");
    exit(); // Arrêter l'exécution du script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère le nom du forum depuis le formulaire
    $forumName = $_POST['forum_name'];
   
    // Vérifie si le fichier a été correctement uploadé
    if (!isset($_FILES['forum_image']) || $_FILES['forum_image']['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload du fichier.");
    }
    
    // Récupère les informations sur le fichier
    $image = $_FILES['forum_image'];
    
    // Vérifie si le fichier est une image
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        die("Le fichier n'est pas une image.");
    }
    
    // Limite la taille du fichier (ici, 5 Mo)
    if ($image['size'] > 5000000) {
        die("Désolé, votre fichier est trop volumineux.");
    }
    
    // Autorise certains formats de fichiers
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFileType = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowedFormats)) {
        die("Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
    }
    
    // Lit le contenu de l'image en base64
    $imageContent = file_get_contents($image['tmp_name']);
    $imageBase64 = $imageContent;
    
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "0000", "forum");
    
    // Vérifie la connexion
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO forums (nom_forum, image_path, id_mod) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $forumName, $imageBase64, $id_mod); // Utilisez "sss" pour trois chaînes
    
    // Exécute la requête
    if ($stmt->execute()) {
        echo '<script>
        alert("Forum créé avec succès ");
        window.location.href="../Interfaces/moderateurProfil.php";
       </script>';
    } else {
        echo "Erreur: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}    
?>
