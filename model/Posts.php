<?php

require_once('Manager.php');

class Posts extends Manager
{
    // Compte des posts pour pagination
    public function countPosts($categoryId = null)
    {
        if ($categoryId)
        {
            $whereCategory = 'WHERE posts.category_id = ' . $categoryId . ' ';
        }
        else
        {
            $whereCategory = '';
        }

        $db = $this->dbConnect();
        $posts = $db->query('SELECT * FROM posts ' . $whereCategory);

        return $posts->rowCount();
    }

    // Récupération des posts
    public function listPosts($firstPost, $categoryId = null)
    {     
        if (isset($_SESSION['id']))
        {
            $userId = $_SESSION['id'];
        } 
        else
        {
            $userId = 0;
        }
        
        if ($categoryId)
        {
            $whereCategory = 'WHERE posts.category_id = ' . $categoryId . ' ';
        }
        else
        {
            $whereCategory = '';
        }
   
        $db = $this->dbConnect();
        $posts = $db->query('SELECT posts.id AS id,
                            posts.title AS title,
                            posts.content AS content,
                            posts.true_value AS true_value,
                            posts.created AS created,
                            users.pseudo AS pseudo,
                            users.id AS user_id,
                            categories.id AS category_id,
                            categories.title AS category_title,
                            votes.value AS vote
                            FROM posts
                            LEFT JOIN categories ON categories.id = posts.category_id
                            LEFT JOIN users ON users.id = posts.user_id
                            LEFT JOIN votes ON (votes.post_id = posts.id AND votes.user_id = ' . $userId . ') ' .
                            $whereCategory .
                            'ORDER BY created DESC
                            LIMIT ' . $firstPost . ', 16');
                                                        
        return $posts;
    }

    // Le post est-il celui de l'utilisateur courant ?
    public function postIsMine(array $vote)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('SELECT * FROM posts WHERE (id = :postId AND user_id = :userId)');
        $post->execute([
            'postId' => $vote['postId'],
            'userId' => $vote['userId']
        ]);

        $postIsMine = $post->rowCount();
        
        return (bool)$postIsMine;
    }

    // Ajouter un post
    public function addPost($newPost)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('INSERT INTO posts (user_id, category_id, title, content, true_value, created) VALUES (:userId, :category_id, :title, :content, :true_value, NOW())');
        $post = $post->execute([
            'userId' => $newPost['userId'],
            'title' => $newPost['title'],
            'content' => $newPost['content'],
            'category_id' => $newPost['categoryId'],
            'true_value' => $newPost['true_value']
        ]);
        
        return $post;
    }

    public function getPostById($postId)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('SELECT * FROM posts WHERE id = :postId');
        $post->execute(array(
            'postId' => $postId
        ));
        $foundPost = $post->fetch();

        return $foundPost;
    }

    


    // Back Office

    public function getPostsFromUser($userId)
    {
        $db = $this->dbConnect();
        $posts = $db->prepare('SELECT * FROM posts WHERE user_id = :userId');
        $posts->execute(array(
            'userId' => $userId
        ));

        return $posts;
    }

    public function deletePost($postId)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('DELETE FROM posts WHERE id = :postId');
        $deletedPost = $post->execute(['postId' => $postId]);

        return $deletedPost;
    }

    public function deletePostsFromUser($userId)
    {
        $db = $this->dbConnect();
        $posts = $db->prepare('DELETE FROM posts WHERE user_id = :userId');
        $deletedPosts = $posts->execute(['userId' => $userId]);

        return $deletedPosts;
    }
}