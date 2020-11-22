<?php
require_once('model/Users.php');
require_once('model/Posts.php');
require_once('model/Categories.php');
require_once('model/Votes.php');


function homepageAdmin($currentPage, array $message = null)
{
    require('view/backend/homepageAdminView.php');
}

function postsViewAdmin($currentPage, array $message = null)
{
    $post = new Posts();

    $numberOfPosts = $post->countPosts();
    $numberOfPages = ceil($numberOfPosts / 16);
    $firstPost = ($currentPage * 16) - 16;

    $posts = $post->listPosts($firstPost);

    require('view/backend/postsView.php');
}

function usersViewAdmin($currentPage, array $message = null)
{
    $user = new Users();
    $numberOfUsers = $user->countUsers();
    $numberOfPages = ceil($numberOfUsers / 16);
    $firstUser = ($currentPage * 16) - 16;

    $users = $user->listUsers($firstUser);
    require('view/backend/usersView.php');
}

function deleteUser($userId, $currentPage)
{
    $users = new Users();
    $foundUser = $users->getUserById($userId);

    if ($foundUser)
    {
        $votes = new Votes();
        
        if ($votes->deleteVotesFromUser($userId))
        {
            $posts = new Posts();
            $postsFromUser = $posts->getPostsFromUser($userId);
            
            foreach($postsFromUser as $postFromUser)
            {
                $votes = new Votes();
                $votes->deleteVotesOfPost($postFromUser['id']);
            }

            if ($posts->deletePostsFromUser($userId))
            {
                if ($users->deleteUser($userId))
                {
                    $message[1] = 'Utilisateur supprimé';
                    usersViewAdmin($currentPage, $message);
                }
                else
                {
                    $message[0] = 'Une erreur est apparue pendant la suppression';
                    usersViewAdmin($currentPage, $message);
                }
            }   
            else
            {
                $message[0] = 'Une erreur est apparue pendant la suppression';
                usersViewAdmin($currentPage, $message);
            }   
        }
        else
        {
            $message[0] = 'Une erreur est apparue pendant la suppression';
            usersViewAdmin($currentPage, $message);
        }
    }
    else
    {
        $message[0] = 'Cet utilisateur n\'existe pas';
        usersViewAdmin($currentPage, $message);
    }   
}


function deletePost($postId, $currentPage)
{
    $posts = new Posts();
    $foundPost = $posts->getPostById($postId);

    if ($foundPost)
    {
        $votes = new Votes();

        if ($votes->deleteVotesOfPost($postId))
        {
            if ($posts->deletePost($postId))
            {
                $message[1] = 'Article supprimé';
                postsViewAdmin($currentPage, $message);
            }
            else
            {
                $message[0] = 'Une erreur est apparue pendant la suppression';
                postsViewAdmin($currentPage, $message);
            }   
        }
        else
        {
            $message[0] = 'Une erreur est apparue pendant la suppression';
            postsViewAdmin($currentPage, $message);
        }      
    }
    else
    {
        $message[0] = 'Cet article n\'existe pas';
        postsViewAdmin($currentPage, $message);
    }   
}