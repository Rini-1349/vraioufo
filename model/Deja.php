<?php

require_once('Manager.php');

class Deja extends Manager
{
    public function getDejaContent()
    {
        $db = $this->dbConnect();
        $deja = $db->query('SELECT * FROM deja');

        return $deja;
    }
}