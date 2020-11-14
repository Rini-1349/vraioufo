<?php

require_once('Manager.php');

class Categories extends Manager
{

    public function listCategories()
    {
        $db = $this->dbConnect();
        $categories = $db->query('SELECT * FROM categories');
        
        return $categories;
    }

    public function getCategory($categoryId)
    {
        $db = $this->dbConnect();
        $category = $db->query('SELECT * FROM categories 
                                WHERE id = ' . $categoryId);
        
        return $category->fetch();
    }
}