<?php
require_once('model/Users.php');
require_once('model/Posts.php');
require_once('model/Categories.php');
require_once('model/Votes.php');


function homepageAdmin($currentPage, array $message = null)
{
    $firstPost = ($currentPage * 14) - 14;

    $posts = new Posts();
    $posts = $posts->listPosts($firstPost);

    $categories = new Categories();
    $categories = $categories->listCategories();

    $users = new Users();
    $users = $users->listUsers();

    require('view/backend/homepageAdminView.php');
}

function deleteUser($userId)
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
                    homepageAdmin($message);
                }
                else
                {
                    $message[0] = 'Une erreur est apparue pendant la suppression';
                    homepageAdmin($message);
                }
            }   
            else
            {
                $message[0] = 'Une erreur est apparue pendant la suppression';
                homepageAdmin($message);
            }   
        }
        else
        {
            $message[0] = 'Une erreur est apparue pendant la suppression';
            homepageAdmin($message);
        }
    }
    else
    {
        $message[0] = 'Cet utilisateur n\'existe pas';
        homepageAdmin($message);
    }   
}


function deletePost($postId)
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
                homepageAdmin($message);
            }
            else
            {
                $message[0] = 'Une erreur est apparue pendant la suppression';
                homepageAdmin($message);
            }   
        }
        else
        {
            $message[0] = 'Une erreur est apparue pendant la suppression';
            homepageAdmin($message);
        }      
    }
    else
    {
        $message[0] = 'Cet article n\'existe pas';
        homepageAdmin($message);
    }   
}