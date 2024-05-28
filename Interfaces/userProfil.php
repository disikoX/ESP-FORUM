<?php
session_start(); 

if(isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
}

$con = mysqli_connect("localhost", "root", "0000", "forum"); // Connect to the database
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$datas = mysqli_query($con, "SELECT * FROM utilisateurs ");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="userProfil.css">
</head>

<body>
    <div class="profilInfoContainer">
        <div class="infoLeft">
            <div class="userInfo">
            <?php
                    // Requête SQL pour sélectionner les données
                    $sql = "SELECT * FROM utilisateurs  WHERE id_user = $id_user";
                                    $result = mysqli_query($con, $sql);

                                    // Vérification des résultats
                                    if ($result && mysqli_num_rows($result) > 0) {
                                    // Affichage des données
                                    while ($sujet = mysqli_fetch_assoc($result)) {
                                    echo "  <h1> " . $sujet["pseudo_user"] . " </h1> ";
                                }                                
                                    } 
                        ?>
                        <span class="levelUser">
                    <p> Etudiant en &nbsp;</p>
                    <p class="moderateurData">
                    <?php
                    
                     $sql = "SELECT niveau_user FROM utilisateurs WHERE id_user = $id_user";
                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "<p>" .   $sujet["niveau_user"]    ."</p>";
                     }
                    }
                     ?>
                    </p>
                    <p>&nbsp; de l'ESP Antsiranana.</p>
                </span>
                <span class="parcUser">
                <p> Qui fait carrière dans le parcours&nbsp;  </p>
                    <?php
                     $sql = "SELECT mention_user FROM utilisateurs WHERE id_user = $id_user";

                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "\t"," <p> "  . $sujet["mention_user"]." </p> ";
                     }
                    }
                     ?>
                      <p>.</p>
                </span>
            </div>
            <div class="userE-mail">
            <h3> E-mail: </h3>
                <p> <?php
                     $sql = "SELECT * FROM utilisateurs WHERE id_user = $id_user";

                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "<p>"  . $sujet["Email"]."</p>";
                     }
                    }
                     ?></p>
            </div>
            <div class="userWidgets">
                <a href="loginScreen.html">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M5 5v14a1 1 0 0 0 1 1h3v-2H7V6h2V4H6a1 1 0 0 0-1 1zm14.242-.97-8-2A1 1 0 0 0 10 3v18a.998.998 0 0 0 1.242.97l8-2A1 1 0 0 0 20 19V5a1 1 0 0 0-.758-.97zM15 12.188a1.001 1.001 0 0 1-2 0v-.377a1 1 0 1 1 2 .001v.376z" />
                        </svg>
                        <form action="../script/déconnexion.php" method="post">
                        <p>Se déconnecter</p>
                    </button>
                </a>
            </div>
        </div>
        <div class="infoRight">
            <div>
            <?php
                     $sql = "SELECT * FROM utilisateurs WHERE id_user = $id_user";

                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo '<img src="data:image/png;base64,'.base64_encode( $sujet['image_user'] ).'"/>'; 
                     }
                    }
                     ?>
            </div>
        </div>
    </div>
</body>

</html>