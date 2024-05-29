<?php

session_start();

// Vérifier si la session contenant l'ID de l'utilisateur est initialisée
if(isset($_SESSION['id_user'])) {
    // Attribuer la valeur de la session à la variable $id_user
    $id_user = $_SESSION['id_user'];
}else {
    // Afficher un message d'erreur si le pseudo ou le mot de passe est incorrect
    echo '<script>
           alert("Veuillez vous connectez ");
           window.location.href="../Interfaces/loginScreen.html";
          </script>';
   
}


$con = mysqli_connect("localhost", "root", "0000", "forum"); 
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $forum_id = intval($_GET['id']); // Sécurisation de l'entrée

    // Requête SQL pour obtenir le nom du forum
    $sql = "SELECT nom_forum FROM forums WHERE id_forum = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $forum_id);
    $stmt->execute();
    $stmt->bind_result($nom_forum);
    $stmt->fetch();

    // Afficher le nom du forum
    // if ($nom_forum) {
    //     echo "Le nom du forum est : " . htmlspecialchars($nom_forum);
    // } else {
    //     echo "Aucun forum trouvé avec cet ID.";
    // }

    // Fermer la requête
    $stmt->close();
} else {
    echo "ID du forum non spécifié.";
}

if(isset($_POST["subm"])){
    $nom = mysqli_real_escape_string($con, $_POST["nom"]);
    $text = mysqli_real_escape_string($con, $_POST["monText"]);
    $date = date("Y-m-d H:i:s"); // Obtenir la date et l'heure actuelle

    $sql = "INSERT INTO sujets (nom_sujet, text_sujet, date_sujet,lien,id_user,id_forum) VALUES ('$nom', '$text', '$date','','$id_user','$forum_id')";

    if (mysqli_query($con, $sql)) {
        $message = "Nouveau sujet créé avec succès";
    } else {
        $message = "Erreur: " . $sql . "<br>" . mysqli_error($con);
    }
}
    $sql_1 = "SELECT * FROM forums";


    // $result_sql_1 = $con->query($sql_1);
                                    
    // $forum_id = "";
    // if ($result_sql_1->num_rows > 0){
    //     while($sujet = $result_sql_1->fetch_assoc()) {
    //              $forum_id = $sujet['id_forum'];
    //         $forum_name = htmlspecialchars($sujet['nom_forum']);
    //         $forum_url = "STIC.php?id=$forum_id";
    //     }
    // }
    if (isset($_GET['id'])) {
        $forum_id = intval($_GET['id']); 
    
        $sql = "SELECT nom_forum FROM forums WHERE id_forum = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $forum_id);
        $stmt->execute();
        $stmt->bind_result($nom_forum);
        $stmt->fetch();
    
    
        $stmt->close();
    } else {
        echo "ID du forum non spécifié.";
    }


?>

<!DOCTYPE html>
<html lang="e="let rejoignerNous.png>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="STIC.css">
    <link rel="stylesheet" href="footer.css">
    <script src="theme.js"></script>
</head>

<body id="body">
    <header>
        <div class="headerContainer">
            <div class="navBar">
                <div class="insigne">
                    <img src="../Images/ESP_removebg.png" alt="">
                    <h5>Ecole Supérieur Polytechique d'Antsiranana</h5>
                </div>
                <div class="icons">
                    <a href="userProfil.php">
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
            <div class="cover">
            <?php $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

         
            $img =mysqli_query($con,"SELECT image_path FROM forums WHERE id_forum = $forum_id
            ");

            if ($img) {
                while ($img_1 = mysqli_fetch_assoc($img)) {
                    echo '<img src="data:image/png;base64,'.base64_encode( $img_1['image_path'] ).'"/>';
                }
            }
                    ?>
                <div class="coverVide"></div>
                <div class="coverWidget">
                <?php $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

          
            $img =mysqli_query($con,"SELECT nom_forum FROM forums WHERE id_forum = $forum_id
            ");

            if ($img) {
                while ($img_1 = mysqli_fetch_assoc($img)) {
                    echo " <h1>".$img_1["nom_forum"]."</h1>";
                }
            }
                    ?>
                    <a href="#creatSubject">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M19 15v-3h-2v3h-3v2h3v3h2v-3h3v-2h-.937zM4 7h11v2H4zm0 4h11v2H4zm0 4h8v2H4z" />
                            </svg>
                            <p>Nouveau Sujet</p>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="sectionLeft">
            <span class="animeText">
                <p class="welcomText">Bienvenue dans le forum dédier au étudiant dans le parcours STIC.&nbsp;&nbsp;</p>
                <p class="welcomText">Bienvenue dans le forum dédier au étudiant dans le parcours STIC.&nbsp;&nbsp;</p>
                <p class="welcomText">Bienvenue dans le forum dédier au étudiant dans le parcours STIC.&nbsp;&nbsp;</p>
                <p class="welcomText">Bienvenue dans le forum dédier au étudiant dans le parcours STIC.&nbsp;&nbsp;</p>
            </span>
            <h1 class="forumName">Forum <?php $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

          
            $img =mysqli_query($con,"SELECT nom_forum FROM forums WHERE id_forum = $forum_id
            ");

            if ($img) {
                while ($img_1 = mysqli_fetch_assoc($img)) {
                    echo "{$img_1['nom_forum']}";
                }
            }
                    ?></h1>
            <?php
            $comments_sql = "SELECT u.image_user,s.id_sujet, s.nom_sujet, s.text_sujet, s.date_sujet, u.pseudo_user, COUNT(c.id_coms) AS nb_coms, s.id_forum
            FROM sujets s
            JOIN utilisateurs u ON u.id_user = s.id_user
            LEFT JOIN commentaires c ON c.id_sujet = s.id_sujet 
            WHERE id_forum = $forum_id
            GROUP BY s.id_sujet, s.nom_sujet, s.text_sujet, s.date_sujet, u.pseudo_user
            ORDER BY nb_coms DESC

            ";
    
            $sujet_id = "";

            $comments_result = mysqli_query($con, $comments_sql);
           
                                
           
            if ($comments_result && mysqli_num_rows($comments_result) > 0) {
                while ($comment = mysqli_fetch_assoc($comments_result)) {
                    $sujet_id = $comment['id_sujet'];
                                
                    $sujet_name = htmlspecialchars($comment['nom_sujet']);
                    $sujet_url = "sujet.php?id=$sujet_id";


                    echo "<a href='sujet.php?id=$sujet_id' class='subject'>
                    <div class='subjectHeader'>
                        <img src='data:image/jpeg;base64," . base64_encode($comment['image_user']) . "' />
                        <h2>{$comment['pseudo_user']}</h2>
                        <p>{$comment['date_sujet']}</p>
                    </div>
                    <h1>{$comment['nom_sujet']}</h1>
                    <p class='subjectText' style='text-align:center;'>{$comment['text_sujet']}</p>
                    <div class='commentNbr'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M20 2H4c-1.103 0-2 .897-2 2v18l5.333-4H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14H6.667L4 18V4h16v12z'/><circle cx='15' cy='10' r='2'/><circle cx='9' cy='10' r='2'/></svg>
                        <p> {$comment['nb_coms']}</p>
                    </div>
                </a>";
                }
            }
            ?>
            <div class="creatSubject" id="creatSubject">
                <h1>CREER UN SUJET</h1>
                    <?php if (isset($message)): ?>
                       
                    <?php endif; ?>
                <form method="POST" action="">
                    <div class="creatSubjectContent">
                        <div class="creatSubjectContentHeader">
                            <div>
                                <h3>Votre sujet sera placer dans le Forum <?php $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

          
            $img =mysqli_query($con,"SELECT nom_forum FROM forums WHERE id_forum = $forum_id
            ");

            if ($img) {
                while ($img_1 = mysqli_fetch_assoc($img)) {
                    echo "{$img_1["nom_forum"]}";
                }
            } ?></h3>
                                <input type="text" name="nom"  placeholder="Saisir le titre du sujet" required>
                            </div>
                        </div>
                        <div class="creatSubjectContentBody">
                            <div>
                                <textarea name="monText" cols="40" rows="4" oninput="updateTextareaHeight(this);"
                                    placeholder="Saisir le contenu de votre sujet en restant poli en respectant la charte d'utilisation. Tout message discriminatoire ou incitant la haine sera suppimé et son auteur sanctionné."
                                    required></textarea>
                                <button  type="submit" name="subm" class="shareButton">
                                    <P>Poster</P>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            d="m21.426 11.095-17-8A.999.999 0 0 0 3.03 4.242L4.969 12 3.03 19.758a.998.998 0 0 0 1.396 1.147l17-8a1 1 0 0 0 0-1.81zM5.481 18.197l.839-3.357L12 12 6.32 9.16l-.839-3.357L18.651 12l-13.17 6.197z" />
                                    </svg></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="oneSection">
                <h1>LISTE DES SUJETS</h1>
                <ul class="subjectTable">
                    <li class="tableHeader">
                        <span class="subjectRow">SUJETS</span>
                        <span class="authorRow">AUTEUR</span>
                        <span class="commentNbrRow">COMMENTAIRE</span>
                    </li>
                         
                    <?php
                       $sql_top_sujets = "SELECT s.lien, s.id_sujet, s.nom_sujet, f.nom_forum, COUNT(c.id_coms) AS nb_coms, u.pseudo_user, f.id_forum
                       FROM sujets s
                       JOIN forums f ON s.id_forum = f.id_forum
                       LEFT JOIN commentaires c ON s.id_sujet = c.id_sujet
                       JOIN utilisateurs u ON u.id_user = s.id_user
                       GROUP BY s.id_sujet, s.nom_sujet, f.nom_forum, c.nb_coms
                       ORDER BY c.nb_coms DESC
                       
                       ";
    
                        $result_top_sujets = $con->query($sql_top_sujets);
                                    
                        $forum_id = "";
                        if ($result_top_sujets->num_rows > 0) {
                            while($sujet = $result_top_sujets->fetch_assoc()) {
                        $forum_id = $sujet['id_forum'];
                                
                                
                                $forum_name = htmlspecialchars($sujet['nom_forum']);
                                $forum_url = "STIC.php?id=$forum_id";

                                echo "<li>";
                                echo "<a href='STIC.php?id=$forum_id''" . $sujet['lien'] . "' class='tableBody'>";
                                echo "<span class='subjectRow'><span class='subjectText'>" . $sujet['nom_sujet'] . "</span></span>";
                                echo "<span class='authorRow'>" . $sujet['pseudo_user'] . "</span>";
                                echo "<span class='commentNbrRow'>" . $sujet['nb_coms'] . "</span>";
                                echo "</a>";
                                echo "</li>";
                            }
                        } else {
                            echo "<li><p>Aucun sujet trouvé.</p></li>";
                        }
                        ?>

                </ul>
            </div>
        </div>
    </section>
    <footer class="footer">
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
                <a href="forumScreen.php">Accueil</a>
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
    <script>
        function updateTextareaHeight(input) {
            input.style.height = 'auto'
            input.style.height = input.scrollHeight + 'px';
        }
    </script>
</body>

</html>