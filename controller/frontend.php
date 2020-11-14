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
        //header('Location: index.php?action=homepage');
        connection($user['email'], $user['password']);
        }
    }
    else
    {
        connectionForm('Pseudo ou adresse mail déjà utilisé(e)');
    }
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