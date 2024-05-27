<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifier si les paramètres requis sont définis dans POST
    if (isset($_POST["pseudo"], $_POST["mdp"])) {
        // Récupérer les données de l'utilisateur depuis les paramètres POST
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];

        function validate_input($data) {
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

        $pseudo_safe = validate_input($pseudo);
        $mdp_safe = validate_input($mdp);

        $servername = "localhost";
        $username = "root";
        $password = "0000";
        $dbname = "forum";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $check_query = "SELECT * FROM utilisateurs WHERE pseudo_user=? AND mdp_user=?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ss", $pseudo_safe, $mdp_safe);
        $stmt->execute();
        $check_result = $stmt->get_result();

       
        $check_query_mod = "SELECT id_mod FROM moderateurs WHERE pseudo_mod=? AND mdp_mod=?";
        $stmt_mod = $conn->prepare($check_query_mod);
        $stmt_mod->bind_param("ss", $pseudo_safe, $mdp_safe);
        $stmt_mod->execute();
        $check_result_mod = $stmt_mod->get_result();

        
        if ($check_result->num_rows > 0) {
            // Rediriger l'utilisateur vers la page test1.php en cas de succès
            $user_data = $check_result->fetch_assoc();
            $_SESSION['pseudo_user'] = $pseudo_safe;
            $_SESSION['id_user'] = $user_data['id_user']; // Enregistrer l'id du modérateur
            header("Location: ../Interfaces/forumScreen.php");
            exit(); // Arrêter l'exécution du script pour des raisons de sécurité après la redirection
        } elseif ($check_result_mod->num_rows > 0) {
            $moderator_data = $check_result_mod->fetch_assoc();
            $_SESSION['pseudo_mod'] = $pseudo_safe;
            $_SESSION['id_mod'] = $moderator_data['id_mod'];
            // Rediriger l'utilisateur modérateur vers la page appropriée
             header("Location: ../Interfaces/moderateurProfil.php");
             exit();
        } else {
            // Afficher un message d'erreur si le pseudo ou le mot de passe est incorrect
            echo '<script>
                   alert("Pseudo ou mot de passe incorrect ! ");
                   window.location.href="../Interfaces/loginScreen.html";
                  </script>';
           
        }

        // Fermer les requêtes et la connexion à la base de données
        $stmt->close();
        $stmt_mod->close();
        $conn->close();
    } else {
        // Afficher un message d'erreur si tous les paramètres requis ne sont pas définis
        echo "Tous les paramètres sont requis";
    }
} else {
    // Afficher un message d'erreur si la méthode de la requête n'est pas POST
    echo  "Requête invalide";
}
?>
