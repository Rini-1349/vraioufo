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

    public function getUser($login)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT * FROM users WHERE pseudo= :pseudo OR email= :email');
        $user->execute(array(
            'pseudo' => $login,
            'email' => $login
        ));
        $foundUser = $user->fetch();

        return $foundUser;
    }

    public function getUserById($userId)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT * FROM users WHERE id = :userId');
        $user->execute(array(
            'userId' => $userId
        ));
        $foundUser = $user->fetch();

        return $foundUser;
    }

    public function listUsers()
    {
        $db = $this->dbConnect();
        $users = $db->query('SELECT * FROM users');
        
        return $users;
    }

    public function deleteUser($userId)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('DELETE FROM users WHERE id = :userId');
        $deletedUser = $user->execute(['userId' => $userId]);

        return $deletedUser;
    }
}