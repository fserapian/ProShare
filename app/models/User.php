<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data)
    {
        $this->db->query('INSERT INTO users(first_name, last_name, email, password) VALUES(:first_name, :last_name, :email, :password)');
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // login user
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            /*$loggedUser = [
                'id' => $row->id,
                'email' => $row->email,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'level' => $row->level,
                'image' => $row->image,
            ];
            return $loggedUser;*/
            return $row; // return the user with hashed password
        } else {
            return false;
        }
    }

    //change user settings
    public function alterUser($data)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, level = :level WHERE id = :id; ');
        $this->db->bind(':first_name', $data['fName']);
        $this->db->bind(':last_name', $data['lName']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':level', $data['level']);
        $this->db->bind(':id', $data['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //change user password
    public function changePassword($data)
    {
        $this->db->query('UPDATE users SET password = :newPassword where id = :id');
        $this->db->bind(':newPassword', $data['newPassword']);
        $this->db->bind('id', $data['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //gets all users, admin only
    public function getUsers()
    {
        $this->db->query('SELECT 
                                users.id as userId, 
                                users.first_name as fName, 
                                users.last_name as lName, 
                                users.email as email, 
                                users.image as image, 
                                users.level as level, 
                                users.created_at as created, 
                                count(distinct posts.id) as countPosts, 
                                count(distinct comments.id) as countComments 
                                FROM users
                                LEFT JOIN posts on users.id = posts.user_id
                                LEFT JOIN comments on users.id = comments.userID
                                GROUP BY users.id order by users.level desc, users.first_name asc');

        $results = $this->db->resultSet();
        return $results;
    }

    // find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        // check row
        return $this->db->rowCount() > 0;
    }

    //get current user image
    public function getCurrentImage($userid)
    {
        $this->db->query('SELECT image from users where id = :id');
        $this->db->bind(':id', $userid);

        return $this->db->single();
    }

    // save file
    public function saveFile($filename)
    {
        $this->db->query('UPDATE users SET image = :filename WHERE id = :id');

        $this->db->bind(':filename', $filename['filename']);
        $this->db->bind(':id', $filename['user']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');

        $this->db->bind(':id', $id);

        return $this->db->single();
    }

}
