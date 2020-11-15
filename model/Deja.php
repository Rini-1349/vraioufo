<?php

require_once('Manager.php');

class Deja extends Manager
{
    public function dejaCount()
    {
        $db = $this->dbConnect();
        $deja = $db->query('SELECT * FROM deja');

        return $deja->rowCount();
    }

    public function getDejaContent($dejaId)
    {
        $db = $this->dbConnect();
        $deja = $db->prepare('SELECT * FROM deja WHERE id = :dejaId');
        $deja->execute(array(
            'dejaId' => $dejaId
        ));

        return $deja->fetch();
    }
}