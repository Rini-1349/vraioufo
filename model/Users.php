<?php

require_once('Manager.php');

class Users extends Manager
{
    // L'email ou le pseudo est-il déjà utilisés ?
    public function loginAlreadyTaken($pseudo, $eMail)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT * FROM users WHERE pseudo = ? OR email = ?');
        $user->execute([$pseudo, $eMail]);

        return (bool)$user->rowCount();
    }

    // Ajouter un utilisateur
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
        $user = $db->prepare('SELECT * FROM users WHERE pseudo = :pseudo OR email = :email');
        $user->execute([
            'pseudo' => $login,
            'email' => $login
        ]);

        return $user->fetch();
    }

    public function getUserById($userId)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT * FROM users WHERE id = :userId');
        $user->execute([
            'userId' => $userId
        ]);

        return $user->fetch();
    }



    // Back Office

    // Compte des users pour pagination
    public function countUsers()
    {
        $db = $this->dbConnect();
        $users = $db->query('SELECT * FROM users');

        return $users->rowCount();
    }
    
    public function listUsers($firstUser)
    {
        $db = $this->dbConnect();
        $users = $db->query('SELECT * FROM users
                            ORDER BY id
                            LIMIT ' . $firstUser . ', 16');
        
        return $users;
    }

    public function deleteUser($userId)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('DELETE FROM users WHERE id = :userId');

        return $user->execute(['userId' => $userId]);
    }
}