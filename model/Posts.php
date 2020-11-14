<?php

require_once('Manager.php');

class Posts extends Manager
{

    public function listPosts()
    {
        $userId = 0;
        if (isset($_SESSION['id']))
        {
            $userId = $_SESSION['id'];
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
                            votes.value AS vote
                            FROM posts
                            LEFT JOIN categories ON categories.id = posts.category_id
                            LEFT JOIN users ON users.id = posts.user_id
                            LEFT JOIN votes ON (votes.post_id = posts.id AND votes.user_id = ' . $userId . ')
                            ORDER BY created DESC');
                                                        
        return $posts;
    }

    public function isMine(array $vote)
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
}