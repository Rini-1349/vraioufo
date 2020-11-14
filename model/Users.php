<?php

require_once('Manager.php');

class Users extends Manager
{
    private $_name;
    private $_fisrtName;
    private $_pseudo;
    private $_email;
    private $_password;

    public function loginAlreadyTaken($pseudo, $eMail)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT * FROM users WHERE pseudo=? OR email=?');
        $user->execute(array($pseudo, $eMail));
        $foundLines = $user->rowCount();
        //var_dump("boolean foundLines : ", $foundLines);
        //die;

        return (bool)$foundLines;
    }

    public function addUser(array $user)
    {
        $db = $this->dbConnect();
        $newUser = $db->prepare('INSERT INTO users(name, first_name, pseudo, email, password) VALUES(:name, :first_name, :pseudo, :email, :password)');
        $newUser->execute([
            'name' => $user['name'],
            'first_name' => $user['first_name'],
            'pseudo' => $user['pseudo'],
            'email' => $user['email'],
            'password' => $user['hashedPassword']
        ]);

        return $newUser;
    }

    public function getPlayer($login)
    {
        $db = $this->dbConnect();
        $player = $db->prepare('SELECT * FROM users WHERE pseudo= :pseudo OR email= :email');
        $player->execute(array(
            'pseudo' => $login,
            'email' => $login
        ));
        $foundPlayer = $player->fetch();

        return $foundPlayer;
    }
}