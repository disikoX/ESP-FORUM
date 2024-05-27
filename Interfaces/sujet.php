<?php
session_start();

 if(isset($_GET['id'])) {
     $sujet_id = $_GET['id'];

     $con = mysqli_connect("localhost", "root", "0000", "forum");

     $stmt = $con->prepare("SELECT id_sujet FROM sujets WHERE id_sujet= ?");
     $stmt->bind_param("i", $sujet_id);
     $stmt->execute();
     $stmt->store_result();
 }

// Vérifier si la session contenant l'ID de l'utilisateur est initialisée
if(isset($_SESSION['id_user'])) {
    // Attribuer la valeur de la session à la variable $id_user
    $id_user = $_SESSION['id_user'];
}

$con = mysqli_connect("localhost", "root", "0000", "forum");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sujet.css">
    <script src="theme.js"></script>
</head>

<body> <header>
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
            </div>
        </div>
            <div class="cover">
           <?php $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

         
            $img =mysqli_query($con,"SELECT image_path FROM forums LIMIT 1
            ");

            if ($img) {
                while ($img_1 = mysqli_fetch_assoc($img)) {
                    echo '<img src="data:image/png;base64,'.base64_encode( $img_1['image_path'] ).'"/>';
                }
            }
                    ?>
                <div class="coverVide"></div>
                <div class="coverWidget">
                    <h1>STIC</h1>
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

                <div class="widgets">
                    <div class="colorCover">
                        <div class="widgetsTop">
                            <a href="STIC.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M19 15v-3h-2v3h-3v2h3v3h2v-3h3v-2h-.937zM4 7h11v2H4zm0 4h11v2H4zm0 4h8v2H4z" />
                                </svg>
                                <p>Nouveau Sujet</p>
                            </a>
                        </div>
                        <div class="widgetsBottom">
                            <a href="forumScreen.html">
                                <span></span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <path
                                            d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1 1 1 0 0 0-.29-.71zM6 20v-9.59l6-6 6 6V20z" />
                                    </svg>
                                </div>
                            </a>
                        
                        </div>
                    </div>
                </div>
                <?php
            $con = mysqli_connect("localhost", "root", "0000", "forum");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $comments_sql = "SELECT s.id_sujet, s.nom_sujet, s.text_sujet, u.image_user, s.date_sujet, u.pseudo_user, COUNT(c.id_coms) AS nb_coms
                FROM sujets s
                JOIN utilisateurs u ON u.id_user = s.id_user
                LEFT JOIN commentaires c ON c.id_sujet = s.id_sujet 
                WHERE s.id_sujet = ?
                GROUP BY s.id_sujet, u.image_user, s.date_sujet, u.pseudo_user, s.nom_sujet, s.text_sujet
                ORDER BY nb_coms DESC
                LIMIT 1
            ";

            $stmt = $con->prepare($comments_sql);
            $stmt->bind_param("i", $sujet_id);
            $stmt->execute();
            $comments_result = $stmt->get_result();

            if ($comments_result && $comments_result->num_rows > 0) {
                while ($comment = $comments_result->fetch_assoc()) {
                    echo "<a href='' class='subject'>
                        <div class='subjectHeader'>
                            <img src='data:image/jpeg;base64," . base64_encode($comment['image_user']) . "' />
                            <h2>{$comment['pseudo_user']}</h2>
                            <p> {$comment['date_sujet']}</p>
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
            $stmt->close(); // Fermeture du statement ?>
        
        <div id="comments_section">
                <?php
                        $comments_sql = "SELECT c.text_coms, c.id_sujet, u.pseudo_user, c.date_coms, s.nom_sujet, s.text_sujet, u.mention_user, u.image_user, u.niveau_user
                        FROM commentaires c
                        JOIN sujets s ON s.id_sujet = c.id_sujet
                        JOIN utilisateurs u ON u.id_user = c.id_user 
                        WHERE c.id_sujet = ?
                        ORDER BY c.date_coms DESC
                        ";
                
                $stmt = $con->prepare($comments_sql);
                $stmt->bind_param("i", $sujet_id);
                $stmt->execute();
                $comments_result = $stmt->get_result();

                if ($comments_result && $comments_result->num_rows > 0) {
                    while ($comment = $comments_result->fetch_assoc()) {
                        echo "<div class='oneComment'>
                                <div class='commentAutorProfil'>
                                <img src='data:image/jpeg;base64," . base64_encode($comment['image_user']) . "' />
                                </div>
                                <div class='commentContent'>
                                    <div class='commentContentHeader'>
                                        <h3>{$comment['pseudo_user']}</h3>
                                        <p>{$comment['date_coms']}</p>
                                    </div>
                                    <div class='commentContentText'>{$comment['text_coms']}</div>
                                </div>
                            </div>";
                    }
                }
                $stmt->close(); 
                $con->close(); 
                ?>
        <div class="creatComment">
            <div class="creatCommentContent">
                <div class="creatCommentContentHeader">
                    <div>
                        <h1>Répondre</h1>
                    </div>
                </div>
                <div class="creatCommentContentBody">
                    <div>
                                    <?php 
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $comment_text = $_POST['comment_text'];

                        $con = mysqli_connect("localhost", "root", "0000", "forum");
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $insert_comment_sql = "INSERT INTO commentaires (id_sujet, date_coms, text_coms, id_user) 
                            VALUES (?, NOW(), ?, ?)
                        ";

                        $stmt = $con->prepare($insert_comment_sql);
                        $stmt->bind_param("isi", $sujet_id, $comment_text, $id_user);

                        if ($stmt->execute()) {
                            echo "<script>
                            window.location.href='sujet.php?id=$sujet_id?>';
                            </script>";
                        } else {
                            echo "Erreur lors de l'ajout du commentaire: " . $stmt->error;
                        }

                        $stmt->close(); 
                        $con->close(); 
                            }
                            ?>
                        <form method="post" >
                            <textarea name="comment_text" id="comment_text" cols="40" rows="2" placeholder="Saisir votre commentaire." required></textarea>

                            <button type="submit" class="shareButton">
                                <p>Poster</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="m21.426 11.095-17-8A.999.999 0 0 0 3.03 4.242L4.969 12 3.03 19.758a.998.998 0 0 0 1.396 1.147l17-8a1 1 0 0 0 0-1.81zM5.481 18.197l.839-3.357L12 12 6.32 9.16l-.839-3.357L18.651 12l-13.17 6.197z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>