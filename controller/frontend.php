<?php
require_once('model/Users.php');
require_once('model/Posts.php');
require_once('model/Categories.php');
require_once('model/Votes.php');



function homepage($success = null)
{
    $posts = new Posts();
    $listPosts = $posts->listPosts();

    $categories = new Categories();
    $categories = $categories->listCategories();

    require('view/frontend/homepageView.php');
    
    // Lister les posts
}


function connectionForm($error = null)
{
    require('view/frontend/connectionView.php');
}

function subscriptionForm($error = null)
{
    require('view/frontend/subscriptionView.php');
}


function addUser(array $user)
{
    $newUser = new Users();
    $isTaken = $newUser->loginAlreadyTaken($user['pseudo'], $user['email']);
    if (!$isTaken)
    {
        if ($newUser->addUser($user))
        {
        sendConfirmationMail($user);
        connection($user['email'], $user['password']);
        }
    }
    else
    {
        connectionForm('Pseudo ou adresse mail déjà utilisé(e)');
    }
}


function sendConfirmationMail(array $user)
{
    $subject = 'Inscription validée';

    $message = 'Salut ' . $user['first_name'] . "\n" . "\n";
    $message .= 'Ton inscription sur le site Vrai Oufo a bien été prise en compte' . "\n"; 
    $message .= 'Tu peux te connecter sur le site avec ton pseudo ou ton adresse mail' . "\n" . "\n";
    $message .= 'Pour rappel, voici tes informations personnelles : ' . "\n";
    $message .= 'Pseudo : ' . $user['pseudo'] . "\n";
    $message .= 'Adresse mail : ' . $user['email'] . "\n" . "\n";
    $message .= 'A très bientôt !' . "\n";

    $headers = ['From' => 'vraioufo@solangebaron.com',
    'Reply-To' => 'vraioufo@solangebaron.com',
    'X-Mailer' => 'PHP/' . phpversion()];

    return mail($user['email'], $subject, $message, $headers);
}

function connection($login, $pass)
{
    $user = new Users();
    $foundPlayer = $user->getPlayer($login);

    if (!$foundPlayer)
    {
        connectionForm('Login ou mot de passe incorrect');
    }
    else
    {
        $isPasswordCorrect = password_verify($pass, $foundPlayer['password']);
        if ($isPasswordCorrect)
        {
            session_start();
            $_SESSION = array(
                'id' => $foundPlayer['id'],
                'name' => $foundPlayer['name'],
                'first_name' => $foundPlayer['first_name'],
                'pseudo' => $foundPlayer['pseudo'],
            );
            header('Location: index.php?action=homepage');
        }
        else
        {
            connectionForm('Login ou mot de passe incorrect');
        }
    }
}


function postForm($error = null)
{
    $categories = new Categories();
    $categories = $categories->listCategories();
    
    require('view/frontend/postFormView.php');
}

function createPost(array $newPost)
{
    $post = new Posts();
    $createdPost = $post->addPost($newPost);
    header('Location: index.php?action=homepage');
}

function submitVote(array $vote)
{
    $posts = new Posts();
    $postIsMine = $posts->isMine($vote);

    if (!$postIsMine)
    {
        $votes = new Votes();
        if ($newVote = $votes->addVote($vote))
        {
            homepage();
        }
        else
        {
            echo 'Non';
        }
    }
    else
    {
        echo 'C\'est mon article';
    }
}

function listPostsByCategory($categoryId)
{
    $posts = new Posts();
    $postsByCategory = $posts->listPosts($categoryId);

    
    $categories = new Categories();
    $category = $categories->getCategory($categoryId);

    require('view/frontend/categoryView.php');
}