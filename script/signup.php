<?php


if (isset($_POST["email"]) && isset($_POST["mention"]) && isset($_POST["niveau"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"])) {

    $email = $_POST['email'];
    $mention = $_POST['mention'];
    $niveau = $_POST['niveau'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    function escape_output($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    $email_safe = escape_output($email);
    $mention_safe = escape_output($mention);
    $niveau_safe = escape_output($niveau);
    $pseudo_safe = escape_output($pseudo);
    $mdp_safe = escape_output($mdp);

    
    $servername = "localhost";
    $username = "root";
    $password = "0000";
    $dbname = "forum";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT * FROM utilisateurs WHERE Email=? AND pseudo_user=? AND niveau_user=? AND mention_user=? AND mdp_user=?";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $email_safe, $pseudo_safe, $niveau_safe, $mention_safe, $mdp_safe);

    
    $stmt->execute();

    
    $stmt->store_result();

 
    if ($stmt->num_rows > 0) {
        echo "L'utilisateur existe déjà.";
    } else {
      
        $stmt->close();

       
        $sql_insert = "INSERT INTO utilisateurs (Email, mention_user, niveau_user, pseudo_user, mdp_user, image_user) VALUES (?, ?, ?, ?, ?, NULL)";
        $stmt_insert = $conn->prepare($sql_insert);

        // Bind parameters for insert
        $stmt_insert->bind_param("sssss", $email_safe, $mention_safe, $niveau_safe, $pseudo_safe, $mdp_safe);

       
        if ($stmt_insert->execute() === TRUE) {
            header("location: ../Interfaces/forumScreen.php");
            die();
        } else {
            echo "Erreur lors de l'inscription: " . $conn->error;
        }

       
        $stmt_insert->close();
    }

  
    $conn->close();
} else {
    echo "Tous les paramètres sont requis";
}

?>
