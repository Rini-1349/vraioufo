<?php
require_once('model/Users.php');
require_once('model/Posts.php');
require_once('model/Categories.php');
require_once('model/Votes.php');
require_once('model/Deja.php');


function listPosts($currentPage, $message, $categoryId = null)
{
    $post = new Posts();

    // Elaboration pagination
    $numberOfPosts = $post->countPosts($categoryId);
    $numberOfPages = ceil($numberOfPosts / 16);
    $firstPost = ($currentPage * 16) - 16;

    $categories = new Categories();

    if ($categoryId)
    {
        $posts = $post->listPosts($firstPost, $categoryId);
        $foundPosts = $post->listPosts($firstPost, $categoryId);
        $category = $categories->getCategory($categoryId);
    }
    else
    {
        $posts = $post->listPosts($firstPost);
        $foundPosts = $post->listPosts($firstPost);
        $categoriesList = $categories->listCategories();
    }
    
    $responses = [];

    foreach ($foundPosts as $post)
    {
        $votes = new Votes();
        $votes = $votes->getVotesByPost($post['id']);

        $trueResponses = 0;
        $falseResponses = 0;

        foreach ($votes as $vote)
        {
            if ($vote['value'] == 1)
            {
                $trueResponses++;
            }
            else
            {
                $falseResponses++;
            }
        }

        $responses[$post['id']] = [$falseResponses, $trueResponses];
    }

    $deja = new Deja();
    $dejaContent = $deja->getDejaContent();
    $dejaElements = '';

    foreach ($dejaContent as $dejaElement)
    {
        $dejaElements .= $dejaElement['content'] . ';';
    }

        require('view/frontend/listPostsView.php');
}



function connectionForm($message = null)
{
    require('view/frontend/connectionView.php');
}

function subscriptionForm($message = null)
{
    require('view/frontend/subscriptionView.php');
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
        if (password_verify($pass, $foundUser['password']))
        {
            $votes = new Votes();
            $userVotes = $votes->getVotesFromUser($foundUser['id']);
            $trueResponses = 0;
            $falseResponses = 0;
            foreach ($userVotes as $vote)
            {
                if ($vote['value'] == $vote['true_value'])
                {
                    $trueResponses++;
                }
                else
                {
                    $falseResponses++;
                }
            }
            session_start();
            $_SESSION = [
                'id' => $foundUser['id'],
                'name' => $foundUser['name'],
                'first_name' => $foundUser['first_name'],
                'pseudo' => $foundUser['pseudo'],
                'role' => $foundUser['role'],
                'trueResponses' => $trueResponses,
                'falseResponses' => $falseResponses
            ];
            header('Location: index.php?action=homepage');
        }
        else
        {
            $message[0] = 'Login ou mot de passe incorrect';
            connectionForm($message);
        }
    }
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
        else
        {
            $message[0] = 'Une erreur est survenue. Merci de réessayer';
            require('view/frontend/subscriptionView.php');
        }
    }
    else
    {
        $message[0] = 'Pseudo ou adresse mail déjà utilisé(e)';
        require('view/frontend/subscriptionView.php');
    }
}

function sendConfirmationMail(array $user)
{
    $subject = '=?UTF-8?B?'.base64_encode('Inscription validée').'?=';

    $mailContent = 'Salut ' . $user['first_name'] . ',' . "\n" . "\n";
    $mailContent .= 'Ton inscription sur le site Vré ù Fô a bien été prise en compte.' . "\n"; 
    $mailContent .= 'Tu peux te connecter sur le site avec ton pseudo ou ton adresse mail.' . "\n" . "\n";
    $mailContent .= 'Pour rappel, voici tes informations personnelles : ' . "\n";
    $mailContent .= 'Pseudo : ' . $user['pseudo'] . "\n";
    $mailContent .= 'Adresse mail : ' . $user['email'] . "\n" . "\n";
    $mailContent .= 'A très bientôt !' . "\n";

    $headers = ['From' => 'confirmation@vreufo.com',
    'Reply-To' => 'confirmation@vreufo.com',
    'Content-Type: text/plain; charset="utf-8"',
    'Content-Transfer-Encoding: 8bit',
    'X-Mailer' => 'PHP/' . phpversion()];

    return mail($user['email'], $subject, $mailContent, $headers);
}

function postForm($message = null)
{
    $categories = new Categories();
    $categories = $categories->listCategories();
    
    require('view/frontend/postFormView.php');
}

function createPost(array $newPost, $currentPage)
{
    $post = new Posts();
    if ($post->addPost($newPost))
    {
        $message[1] = 'Merci ! Ton article a bien été ajouté';
        listPosts($currentPage, $message);
    }
    else
    {
        $message[0] = 'Un problème est apparu pendant l\'enregistrement de ton article. Merci de réessayer';
        require('view/frontend/postFormView.php');
    }
}

function submitVote(array $vote, $currentPage)
{
    $posts = new Posts();
    $postIsMine = $posts->postIsMine($vote);

    if (!$postIsMine)
    {   
        $votes = new Votes();
        if ($votes->addVote($vote))
        {
            $post = $posts->getPostById($vote['postId']);
            if ($post['true_value'] == $vote['value'])
            {
                $_SESSION['trueResponses']++;
            }
            else
            {
                $_SESSION['falseResponses']++;
            }
            header('Location: index.php?action=homepage&page=' . $currentPage . '#article-' . $vote['postId']);
        }
        else
        {
            header('Location: index.php?action=homepage&page=' . $currentPage . '#article-' . $vote['postId']);
        }
    }
    else
    {
        header('Location: index.php?action=homepage&page=' . $currentPage);
    }
}

