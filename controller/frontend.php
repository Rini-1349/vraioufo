<?php
require_once('model/Users.php');
require_once('model/Posts.php');
require_once('model/Categories.php');
require_once('model/Votes.php');



function homepage($message = null)
{
    $posts = new Posts();
    $posts = $posts->listPosts();

    $categories = new Categories();
    $categories = $categories->listCategories();

    require('view/frontend/homepageView.php');
}


function connectionForm($message = null)
{
    require('view/frontend/connectionView.php');
}

function subscriptionForm($message = null)
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
        $message[0] = 'Pseudo ou adresse mail déjà utilisé(e)';
        connectionForm($message);
    }
}


function sendConfirmationMail(array $user)
{
    $subject = '=?UTF-8?B?'.base64_encode('Inscription validée').'?=';

    $mailContent = 'Salut ' . $user['first_name'] . ',' . "\n" . "\n";
    $mailContent .= 'Ton inscription sur le site Vrai Oufo a bien été prise en compte.' . "\n"; 
    $mailContent .= 'Tu peux te connecter sur le site avec ton pseudo ou ton adresse mail.' . "\n" . "\n";
    $mailContent .= 'Pour rappel, voici tes informations personnelles : ' . "\n";
    $mailContent .= 'Pseudo : ' . $user['pseudo'] . "\n";
    $mailContent .= 'Adresse mail : ' . $user['email'] . "\n" . "\n";
    $mailContent .= 'A très bientôt !' . "\n";

    $headers = ['From' => 'vraioufo@solangebaron.com',
    'Reply-To' => 'vraioufo@solangebaron.com',
    'Content-Type: text/plain; charset="utf-8"',
    'Content-Transfer-Encoding: 8bit',
    'X-Mailer' => 'PHP/' . phpversion()];

    return mail($user['email'], $subject, $mailContent, $headers);
}

function connection($login, $pass)
{
    $user = new Users();
    $foundUser = $user->getUser($login);

    if (!$foundUser)
    {
        $message[0] = 'Login ou mot de passe incorrect';
        connectionForm($message);
    }
    else
    {
        $isPasswordCorrect = password_verify($pass, $foundUser['password']);
        if ($isPasswordCorrect)
        {
            session_start();
            $_SESSION = array(
                'id' => $foundUser['id'],
                'name' => $foundUser['name'],
                'first_name' => $foundUser['first_name'],
                'pseudo' => $foundUser['pseudo'],
                'role' => $foundUser['role']
            );
            header('Location: index.php?action=homepage');
        }
        else
        {
            $message[0] = 'Login ou mot de passe incorrect';
            connectionForm($message);
        }
    }
}


function postForm($message = null)
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
        $message[0] = 'Impossible de voter sur mon article';
        connectionForm($message);
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