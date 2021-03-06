<?php 
session_start();

require('controller/frontend.php');
require('controller/backend.php');

try 
{
    if (isset ($_GET['action']) AND !empty($_GET['action']))
    {
        $action = $_GET['action'];

        if(isset($_GET['page']) && !empty($_GET['page']) AND (int)$_GET['page'] > 0)
        {
            $currentPage = (int)$_GET['page'];
        }
        else
        {
            $currentPage = 1;
        }
        
        $message = [];

        if ($action == 'connection')
        {
            if (isset($_POST['login']) AND isset($_POST['pass']) AND !empty($_POST['login']) AND !empty($_POST['pass']))
            {
                connection($_POST['login'], $_POST['pass']);
            }
            else
            {
                connectionForm();
            }
        }  
        elseif ($action == 'subscription')
        {
            if (isset ($_POST['name']) AND isset ($_POST['first_name']) AND isset ($_POST['pseudo']) AND isset ($_POST['email']) AND isset ($_POST['pass']) and isset ($_POST['pass_confirm'])
                    AND !empty($_POST['name']) AND !empty($_POST['first_name']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['pass']) and !empty($_POST['pass_confirm']))
            {
                if (!preg_match("#^[a-z0-9_.-]+@[a-z0-9_.-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
                {
                    $message[0] = 'Format d\'adresse email non valide';
                    subscriptionForm($message);
                }
                elseif (!preg_match("#^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[0-9])(?=\S*[\W])\S{8,20}$#", $_POST['pass']))
                {
                    $message[0] = 'Le mot de passe doit contenir entre 8 et 20 caractères dont 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial';
                    subscriptionForm($message);
                }
                elseif ($_POST['pass'] != $_POST['pass_confirm'])
                {
                    $message[0] = 'Confirmation de mot de passe incorrecte';
                    subscriptionForm($message);
                }
                else
                {
                    $hashedPassword = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    $user = [
                        'name' => $_POST['name'],
                        'first_name' => $_POST['first_name'],
                        'pseudo' => $_POST['pseudo'],
                        'email' => $_POST['email'],
                        'password' => $_POST['pass'],
                        'hashedPassword' => $hashedPassword
                    ];
                    addUser($user);
                }              
            }
            else
            {
                subscriptionForm();
            }
        }
        elseif ($action == 'logout')
        {
            session_unset();
            session_destroy();

            $message[1] = 'Vous êtes déconnecté(e)';
            listPosts($currentPage, $message);
        }
        elseif ($action == 'addPost')
        {
            if (array_key_exists('title', $_POST) AND array_key_exists('content', $_POST) AND array_key_exists('id', $_SESSION)
                AND array_key_exists('category', $_POST) AND array_key_exists('true_value', $_POST))
            {
                if (!empty($_POST['title']) AND !empty($_POST['content']) AND !empty($_POST['category'])
                    AND ((int)$_POST['category'] > 0) AND (strlen($_POST['true_value']) == 1) AND strlen($_POST['content']) <= 255 )
                {
                    $newPost = [
                        'title' => $_POST['title'], 
                        'content' => $_POST['content'], 
                        'userId' => $_SESSION['id'], 
                        'categoryId' => $_POST['category'], 
                        'true_value' => $_POST['true_value']
                    ];
                    
                    createPost($newPost, $currentPage);
                }  
                else
                {
                    $message[0] = 'Merci de remplir les champs demandés';
                    postForm($message);
                }
            }
            else
            {
                postForm();
            }
        }
        elseif ($action == 'vote')
        {
            if (isset($_POST['vote']) 
                AND array_key_exists('id', $_SESSION)
                AND isset($_GET['postId']) AND !empty($_GET['postId']) AND ((int)$_GET['postId'] > 0))
            {
                $vote = [
                    'userId' => $_SESSION['id'],
                    'postId' => (int)$_GET['postId'],
                    'value' => (int)$_POST['vote']
                ];
                submitVote($vote, $currentPage);
            }
            else
            {
                $message[0] = 'Votre vote n\'a pas pu être enregistré';
                listPosts($currentPage, $message);
            }         
        }
        elseif ($action == 'category')
        {
            if (isset($_GET['categoryId']) AND ((int)$_GET['categoryId'] > 0))
            {
                listPosts($currentPage, $message, (int)$_GET['categoryId']);
            }
            else
            {
                listPosts($currentPage, $message);
            }
        }
        elseif ($action == 'admin')
        {
            if (isset($_SESSION['role']) AND $_SESSION['role'] == 1)
            {
                if (isset($_GET['operation']) AND !empty($_GET['operation']))
                {
                    $operation = $_GET['operation'];

                    if ($operation == 'postsView')
                    {
                        postsViewAdmin($currentPage, $message);                           
                    }
                    elseif ($operation == 'usersView')
                    {
                        usersViewAdmin($currentPage, $message);                           
                    }
                    elseif ($operation == 'deleteUser' AND isset($_GET['userId']) AND (int)$_GET['userId'] > 0)
                    {
                        if ($_GET['userId'] !== $_SESSION['id'])
                        {
                            deleteUser((int)$_GET['userId'], $currentPage);
                        }
                        else
                        {
                            $message[0] = 'Vous ne pouvez pas supprimer votre propre compte';
                            usersViewAdmin($currentPage, $message);
                        }              
                    }
                    elseif ($operation == 'deletePost' AND isset($_GET['postId']) AND (int)$_GET['postId'] > 0)
                    {
                        deletePost((int)$_GET['postId'], $currentPage);
                    }
                    else
                    {
                        homepageAdmin($currentPage, $message);
                    }
                }
                else
                {
                    homepageAdmin($currentPage, $message);
                }               
            }
            else
            {
                $message[0] = 'Accès refusé';
                listPosts($currentPage, $message);
            }
        }
        else
        {
            if ($action !== 'homepage')
            {
                $message[0] = 'Cette page n\'existe pas';
            }
            listPosts($currentPage, $message);
        }      
    }
    else 
    {
        listPosts(1, $message);
    }
}
catch(Exception $e)
{
    if ($e->getCode() == 23000) // (Erreurs SQL, notamment lancement nouvelle requête en rafraichissant la page)
    {
        listPosts(1, $message);
    }
    else
    {
        echo 'Erreur : ' . $e->getMessage() . "\n" . $e->getCode() . '. Merci de contacter le propriétaire du site';
    }
}