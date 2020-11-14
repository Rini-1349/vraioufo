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

    protected function viewCategory($id)
    {

    }

    protected function editCategory($id)
    {

    }

    protected function addCategory()
    {

    }

    protected function deleteCategory($id)
    {
        
    }
}