<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // get all posts
    public function getPosts()
    {
        $this->db->query('SELECT *, 
                                posts.id as postId, 
                                users.id as userId, 
                                users.image as userImage,
                                posts.created_at as postDate, 
                                users.created_at as userDate, 
                                count(comments.id) as nbrComments, 
                                avg(comments.note) as avgNote,
                                categories.name as categorie
                                FROM posts 
                                INNER JOIN users on posts.user_id = users.id 
                                LEFT JOIN comments on comments.postid = posts.id
                                INNER JOIN categories on posts.categories = categories.id
                                GROUP BY posts.id
                                ORDER BY posts.created_at DESC
                            ');

        $results = $this->db->resultSet();

        return $results;
    }

    // get all posts of a category
    public function getPostsByCategory($id)
    {
        $this->db->query('SELECT *, 
                                posts.id as postId, 
                                users.id as userId, 
                                users.image as userImage,
                                posts.created_at as postDate, 
                                users.created_at as userDate, 
                                count(comments.id) as nbrComments, 
                                avg(comments.note) as avgNote,
                                categories.name as categorie
                                FROM posts 
                                INNER JOIN users on posts.user_id = users.id 
                                LEFT JOIN comments on comments.postid = posts.id
                                INNER JOIN categories on posts.categories = categories.id
                                WHERE categories.id = :id
                                GROUP BY posts.id
                                ORDER BY posts.created_at DESC
                            ');

        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();

        return $results;
    }

    // get all categories
    public function getCategories()
    {
        $this->db->query('SELECT * FROM categories ORDER BY name');
        $results = $this->db->resultSet();

        return $results;
    }

    // add a post
    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts(user_id, title, body, content, categories)
                            VALUES(:user_id, :title, :body, :content, :categories)');
        // bind the values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':categories', $data['categsel']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // add a comment
    public function addComment($data)
    {
        $this->db->query('INSERT INTO comments(content, note, userID, postid)
							VALUES(:content, :note, :userID, :postid)');

        $this->db->bind(':content', $data['content']);
        $this->db->bind(':note', $data['note']);
        $this->db->bind(':userID', $data['userid']);
        $this->db->bind(':postid', $data['postid']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // get comments of a post
    public function showPostComments($postId)
    {
        $this->db->query('SELECT comments.id as commentId,
								users.first_name as fname,
								users.last_name as lname,
								comments.postId as postId,
								comments.content as content,
								comments.note as note,
								comments.dateComment as dateComment
								FROM comments, users
								WHERE postId = :postId
								AND comments.userId = users.id
								ORDER BY comments.dateComment DESC');

        $this->db->bind(':postId', $postId);
        $results = $this->db->resultSet();
        return $results;
    }

    // get post by id
    public function getPostById($id)
    {
        $this->db->query('SELECT 
                            posts.id as postId,
                            posts.title as title,
                            posts.body as body,
                            posts.content as content,
                            users.id as userId,
                            users.first_name as first_name,
                            users.last_name as last_name,
                            users.level as userLevel,
                            posts.created_at as postDate,
                            users.created_at as userDate,
                            categories.id as categorieId,
                            categories.name as categorie
                            FROM posts
                            INNER JOIN users ON posts.user_id = users.id
                            INNER JOIN categories on posts.categories = categories.id
                            WHERE posts.id = :id
                            ORDER BY posts.created_at DESC
                            ');

        $this->db->bind(':id', $id);

        // get single row
        $row = $this->db->single();
        if ($this->db->rowcount() == 0) {
            return null;
        } else {
            return $row;
        }
    }

    // update a post
    public function updatePost($data)
    {

        $this->db->query('UPDATE posts SET title = :title, body = :body, content = :content, categories = :categories WHERE id = :id');
        // bind the values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':categories', $data['categorie']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // delete post by id
    public function deletePostById($id)
    {

        $this->db->query('DELETE FROM posts WHERE id = :id');

        $this->db->bind(':id', $id);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // find a reaction by postid and userid
    public function findReactionByPostAndUser($data)
    {
        $this->db->query('SELECT * FROM reactions 
                            WHERE post_id = :post_id AND user_id = :user_id');

        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);

        return $this->db->single();
    }

    // get dislikes count
    public function getDislikesCount($postId)
    {
        $this->db->query('SELECT count(*) as count FROM reactions WHERE 
                            post_id = :post_id
                            AND type = -1');

        $this->db->bind(':post_id', $postId);

        return $this->db->single();
    }

    // get likes count
    public function getLikesCount($postId)
    {
        $this->db->query('SELECT count(*) as count FROM reactions WHERE 
                            post_id = :post_id
                            AND type = 1');

        $this->db->bind(':post_id', $postId);

        return $this->db->single();
    }

    // create reaction (like or dislike)
    public function createReaction($data)
    {
        $this->db->query('INSERT INTO reactions (type, post_id, user_id) 
                            VALUES (:type, :post_id, :user_id)');

        $this->db->bind(':type', $data['type']);
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // update reaction (like or dislike)
    public function updateReaction($data)
    {
        $this->db->query('UPDATE reactions SET type = :type 
                            WHERE post_id = :post_id AND user_id = :user_id');

        $this->db->bind(':type', $data['type']);
        $this->db->bind(':post_id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);

        // execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
