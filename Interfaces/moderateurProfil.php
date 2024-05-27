<?php
session_start(); 
if(!isset($_SESSION['id_mod'])) {
   header("location: exit.php");
   die();
}

// Vérifier si la session contenant l'ID de l'utilisateur est initialisée
if(!isset($_SESSION['pseudo_mod']) || empty($_SESSION['pseudo_mod'])) {
    // Rediriger vers la page de profil des modérateurs
    header("location: userProfil.php");
    // Arrêter l'exécution du script
    die();
} else {
    // L'utilisateur est un modérateur, vous pouvez continuer l'exécution du script
    // Attribuer la valeur de la session à la variable $pseudo_safe
    $pseudo_safe = $_SESSION['pseudo_mod'];
}


$con = mysqli_connect("localhost", "root", "0000", "forum");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$datas = mysqli_query($con, "SELECT * FROM moderateurs ");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="moderateurProfil.css">
    <script src="moderateurProfil.js"></script>
</head>

<body>
    <div class="profilInfoContainer">
        <div class="infoLeft">
            <div class="userInfo">
                <?php
                    // Requête SQL pour sélectionner les données
                    $sql = "SELECT pseudo_mod FROM  moderateurs
                    LIMIT 1";
                                    $result = mysqli_query($con, $sql);

                                    // Vérification des résultats
                                    if ($result && mysqli_num_rows($result) > 0) {
                                    // Affichage des données
                                    while ($sujet = mysqli_fetch_assoc($result)) {
                                    echo "  <h1> " . $sujet["pseudo_mod"] . " </h1> ";
                                }                                
                                    } 
                        ?>
                <span class="levelUser">
                    <p> Etudiant en &nbsp;</p>
                    <p class="moderateurData">
                    <?php
                    
                     $sql = "SELECT niveau_mod FROM moderateurs
                     LIMIT 1";
                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "<p>" .   $sujet["niveau_mod"]    ."</p>";
                     }
                    }
                     ?>
                    </p>
                    <p>&nbsp; de l'ESP Antsiranana.</p>
                </span>
                <span class="parcUser">
                    <p> Qui fait carrière dans le parcours&nbsp;  </p>
                    <?php
                     $sql = "SELECT mention_mod FROM moderateurs
                     LIMIT 1";

                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "\t"," <p> "  . $sujet["mention_mod"]." </p> ";
                     }
                    }
                     ?>
                    <p>.</p>
                </span>
            </div>
            <div class="userE-mail">
                <h3> E-mail: </h3>
                <p> <?php
                     $sql = "SELECT * FROM moderateurs
                     LIMIT 1";

                     $result = mysqli_query($con, $sql);

                     // Vérification des résultats
                     if ($result && mysqli_num_rows($result) > 0) {
                     // Affichage des données
                     while ($sujet = mysqli_fetch_assoc($result)) {
                        echo "<p>"  . $sujet["mail_mod"]."</p>";
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
                        <form action="déconnexion.php" method="post">
                        <p>Se déconnecter</p>
                       
                        </form>
                    </button>
                </a>
                <button class="createForumBtn" onclick="add()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13 9h-2v3H8v2h3v3h2v-3h3v-2h-3z" />
                        <path
                            d="M20 5h-8.586L9.707 3.293A.996.996 0 0 0 9 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2zM4 19V7h16l.002 12H4z" />
                    </svg>
                    <p>Créer un forum</p>
                  
                </button>
            </div>
        </div>
        <div class="infoRight">
            <div>
                <img src="/Images/profil.jpg" alt=" ">
            </div>
        </div>
        <div id="createForum" class="desactive">
            <div>
                <button class="backToProfil" onclick="remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                    </svg>
                </button>
                <h3>Créer un forum</h3>
                <form id="createForumForm" action="../script/Upload.php"  method="POST" enctype="multipart/form-data">
                    <input type="text" name="forum_name" placeholder="Saisir le nom du forum" required>
                    <div class="boutons">
                        <label for="forumImage" class="addPhoto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z" />
                                <path d="m8 11-3 4h11l-4-6-3 4z" />
                                <path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z" />
                            </svg>
                        </label>
                        <input type="file" id="forumImage" name="forum_image" accept="image/*" style="display:none;" onchange="previewImage(event)">
                        <button type="submit" class="addForum">
                            <p>Créer</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M2.002 9.63c-.023.411.207.794.581.966l7.504 3.442 3.442 7.503c.164.356.52.583.909.583l.057-.002a1 1 0 0 0 .894-.686l5.595-17.032c.117-.358.023-.753-.243-1.02s-.66-.358-1.02-.243L2.688 8.736a1 1 0 0 0-.686.894zm16.464-3.971-4.182 12.73-2.534-5.522a.998.998 0 0 0-.492-.492L5.734 9.841l12.732-4.182z" />
                            </svg>
                        </button>
                    </div>
                    <p class="aperçue">Aperçue du fond du forum.</p>
                    <img id="imagePreview" class="forumPhoto" src="/Images/beach.jpeg" alt="">
                </form>
            </div>
        </div>
    </div>
   
</body>
               
<script>
    function add() {
        document.getElementById('createForum').classList.remove('desactive');
    }
    
    function remove() {
        document.getElementById('createForum').classList.add('desactive');
    }
    
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    
</script>
</html>