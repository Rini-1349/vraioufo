<?php

class Manager
{
    protected function dbConnect()
    {
        $db = new PDO('mysql:host=127.0.0.1;dbname=vraioufo2;charset=utf8', 'root', 'root',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}