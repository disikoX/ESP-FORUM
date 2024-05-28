<?php
session_start(); 
 

// Vérifier si la session contenant l'ID de l'utilisateur est initialisée
if(isset($_SESSION['id_user'])) {
    // Attribuer la valeur de la session à la variable $id_user
    $id_user = $_SESSION['id_user'];
  
}
 
$con = mysqli_connect("localhost", "root", "0000", "forum"); // Connect to the database
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$datas = mysqli_query($con, "SELECT * FROM forums");

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./forumScreen.css">
    <link rel="stylesheet" href="footer.css">
    <script src="theme.js"></script>
</head>

<body id="body">
    <header>
        <div class="logoESP">
            <img src="../Images/ESP_removebg.png" alt="">
            <p>Ecole Supérieur Polytechnique d'Antsiranana</p>
        </div>
        <div class="navBar">
            <div>
                <a class="seeProfil" href="userProfil.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12 10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36 7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8 8.1 8.1 0 0 1 8 8 8 8 0 0 1-2.39 5.64z" />
                        <path
                            d="M12 6a3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2z" />
                    </svg>
                </a>
                <button id="toggleThemeBtn" onclick="toggle()">
    
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
    <section>
        <div class="sectionLeft">
            <h1 class="welcomeText" id="welcomeTextFromFirstPage">Bienvenu sur les forums dédiés aux étudiant de l'ESP Antsiranana</h1>
            <h1 class="title">FORUMS</h1>
                            <?php

                $datas = mysqli_query($con, "SELECT * FROM forums");


                ?>
            <div class="listForum">
                    <?php
                    if ($datas) {
                        while ($row = mysqli_fetch_assoc($datas)) {
                                // Générer une URL propre basée sur l'ID du forum
                                $forum_id = $row['id_forum'];
                                $forum_name = htmlspecialchars($row['nom_forum']);
                                $forum_url = "STIC.php?id=$forum_id"; 
        
                                echo '<a href="' . $forum_url . '" class="forum">';
                            
                            echo '<img src="data:image/png;base64,'.base64_encode( $row['image_path'] ).'"/>'; 
                            echo '<div>';
                            echo '<p>' . htmlspecialchars($row['nom_forum']) . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>Aucun forum trouvé</p>';
                    }
                  
                    ?>
            </div>
            <div class="SectionsContainer">
                <main class="oneSection">
                    <h1>TOP SUJET</h1>
                    <ul class="subjectTable">
                        <li class="tableHeader">
                            <span class="subjectRow">SUJETS</span>
                            <span class="forumRow">FORUMS</span>
                            <span class="commentNbrRow">COMMENTAIRE</span>
                        </li>
                        <?php
                       $sql_top_sujets = " SELECT 
                       s.lien, 
                       s.id_sujet, 
                       s.nom_sujet, 
                       f.nom_forum, 
                       COUNT(c.id_coms) AS nb_coms, 
                       f.id_forum
                   FROM 
                       sujets s
                   JOIN 
                       forums f ON s.id_forum = f.id_forum
                   LEFT JOIN 
                       commentaires c ON s.id_sujet = c.id_sujet
                   GROUP BY 
                       s.id_sujet, s.nom_sujet, f.nom_forum, f.id_forum
                   ORDER BY 
                       nb_coms DESC
                   ";
    
                        $result_top_sujets = $con->query($sql_top_sujets);
                                    

                        if ($result_top_sujets->num_rows > 0) {
                            while($sujet = $result_top_sujets->fetch_assoc()) {
                                $forum_id = $sujet['id_forum'];
                                $forum_name = htmlspecialchars($sujet['nom_forum']);
                                $forum_url = "STIC.php?id=$forum_id"; // Vous pouvez utiliser des routes différentes selon votre structure
        
                                echo "<li>";
                                echo "<a href='" . $forum_url . "' class='tableBody'>";
                                echo "<span class='subjectRow'><span class='subjectText'>" . $sujet['nom_sujet'] . "</span></span>";
                                echo "<span class='forumRow'>" . $sujet['nom_forum'] . "</span>";
                                echo "<span class='commentNbrRow'>" . $sujet['nb_coms'] . "</span>";
                                echo "</a>";
                                echo "</li>";
                            }
                        } else {
                            echo "<li><p>Aucun sujet trouvé.</p></li>";
                        }
                        ?> 
                    </ul>        
                </main>
            </div>
        </div>
    </section>
                        
    <div class="imageBottom">
        <div class="imageBottomContenair">
            <h2>Encore le bienvenu sur les forums de l'ESP-D</h2>
            <p>Les forums de l'ESP-D est un espace virtuel dédié à l'entraide et de partage.</p>
            <P>Posez des questions, partagez vos connaissances, discutez et trouvez du soutien.</P>
            <P>Créez des sujets sur vos passions, vos idées ou vos préoccupations.</P>
            <P>Rejoignez la communauté et contribuez à un forum riche et bénéfique pour tous !</P>
            <p>N'attendez plus, créez votre premier sujet dès aujourd'hui !</p>
        </div>
    </div>
    <footer>
        <div class="footer1">
            <span>
                <img src="../Images/rejoignerNous.png" alt="">
            </span>
            <div class="iconMedia">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z" />
                    <circle cx="16.806" cy="7.207" r="1.078" />
                    <path
                        d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z" />
                </svg>
            </div>
            <div class="links">
                <a href="ForumScreen.php">Accueil</a>
                <a href="a_propos.html">A propos</a>
                <a href="l_equipe1.html">L'équipe</a>
                <a href="regles.html">Règles</a>
                <a href="ESP-A.html">ESP-A</a>
            </div>
        </div>
        <div class="footer2">
            <p>Copyright © 2024 - Tous droits réservés.&nbsp;</p>
            <a href="#">Mentions légales</a>
        </div>
    </footer>
</body>

</html>
   