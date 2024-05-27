 <?php
                           
                            // Vérifiez si l'utilisateur est connecté
                            if(isset($_SESSION['id_user'])) {
                                // Détruire toutes les variables de session
                                $_SESSION = array();

                                // Effacez le cookie de session s'il est présent
                                if (isset($_COOKIE[session_name()])) {
                                    setcookie(session_name(), '', time()-42000, '/');
                                }

                                // Détruisez la session
                                session_destroy();

                                // Redirigez l'utilisateur vers la page d'accueil ou une autre page de votre choix
                                header("Location: loginScreen.html"); // Remplacez index.php par l'URL de votre choix
                                exit();
                            } else {
                                // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion ou une autre page de votre choix
                                header("Location: loginScreen.html"); // Remplacez login.php par l'URL de votre page de connexion
                                exit();
                            }
 ?>