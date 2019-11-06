<?php

class Posts extends Controller
{

    public function __construct()
    {
        /*if (!isLoggedIn()) {
            redirect('users/login');
        }*/

        // load Post model
        $this->postModel = $this->model('Post');

        // load User model
        $this->userModel = $this->model('User');
    }

    public function index($id = null)
    {

        if (is_null($id)) {
            redirect('posts/0');
        }
        if ($id == 0) {
            $posts = $this->postModel->getPosts();
        } else if ($id < 99 && $id > 0) {
            $posts = $this->postModel->getPostsByCategory($id);
        } else {
            redirect('posts/0');
        }

        $categories = $this->postModel->getCategories();

        if (isset($_SESSION['user_id'])) {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
        } else {
            $user = '';
        }

        $data = [
            'posts' => $posts,
            'user' => $user,
            'categories' => $categories,
        ];

        // load the view
        $this->view('posts/index', $data);
    }

    public function add()
    {
        // if user not logged in go to login page with message
        if (!isLoggedIn()) {
            flash(
                'info_message',
                'Connectez-vous et profitez de toutes les fonctionnalités de ProShare',
                'card-panel orange white-text'
            );
            redirect('users/login');
        }

        // check if it is a post request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // get categories
            $categories = $this->postModel->getCategories();

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'content' => trim($_POST['content']),
                'user_id' => $_SESSION['user_id'],
                'categsel' => trim($_POST['categorie']),
                'title_err' => '',
                'body_err' => '',
                'content_err' => '',
                'categorie_err' => '',
                'categories' => $categories,
            ];

            // validate if data exists
            if (empty($data['title'])) {
                $data['title_err'] = 'Le titre est vide';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'La description est vide';
            }

            if (empty($data['content'])) {
                $data['content_err'] = 'Le contenu est vide';
            }

            if ($data['categsel'] == 0) {
                $data['categorie_err'] = 'style="color: red;"';
            }

            if (empty($data['title_err']) && empty($data['body_err']) && empty($data['content_err']) && empty($data['categorie_err'])) {
                // all valid

                // flash message
                if ($this->postModel->addPost($data)) {
                    flash('message', 'Projet ajouté');
                    redirect('posts/0');
                } else {
                    flash('message', "Une erreur s'est produite.");
                    redirect('posts/0');
                }
            } else {
                // load the view with errors
                $this->view('posts/add', $data);
            }
        } else {
            $categories = $this->postModel->getCategories();

            $data = [
                'title' => '',
                'body' => '',
                'content' => '',
                'categsel' => '',
                'categorie_err' => '',
                'categories' => $categories,
            ];

            // load the view
            $this->view('posts/add', $data);
        }
    }

    public function edit($id)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        // check if it is a post request
        $categories = $this->postModel->getCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'content' => trim($_POST['content']),
                'categorie' => trim($_POST['categorie']),
                'categories' => $categories,
                'title_err' => '',
                'body_err' => '',
                'content_err' => ''
            ];

            // validate if data exists
            if (empty($data['title'])) {
                $data['title_err'] = 'Le titre est vide';
            }

            if (empty($data['body'])) {
                $data['body_err'] = 'La description est vide';
            }

            if (empty($data['content'])) {
                $data['content_err'] = 'Le contenu est vide';
            }

            if (empty($data['title_err']) && empty($data['body_err']) && empty($data['content_err'])) {
                // all valid

                // flash message
                if ($this->postModel->updatePost($data)) {
                    flash('message', 'Projet modifi&eacute;');
                    redirect('posts/0');
                } else {
                    die("Une erreur s'est produite.");
                }
            } else {
                // load the view with errors
                $this->view('posts/edit', $data);
            }
        } else {

            // fetch the post
            $post = $this->postModel->getPostById($id);

            // check for owner or moderator
            if ($post->userId == $_SESSION['user_id'] || $_SESSION['level'] >= 2) {
                $data = [
                    'id' => $id,
                    'userid' => $post->userId,
                    'title' => $post->title,
                    'body' => $post->body,
                    'content' => $post->content,
                    'categorie' => $post->categorieId,
                    'categories' => $categories,
                ];

                // load the view
                $this->view('posts/edit', $data);
            } else {
                redirect('posts');
            }
        }
    }

    public function show($id)
    {
        $comment_err = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $comment = [
                'content' => trim($_POST['content']),
                'note' => trim($_POST['note']),
                'userid' => $_SESSION['user_id'],
                'postid' => $id
            ];

            if (strlen($comment['content']) < 30 && !empty($comment['content'])) {
                $comment_err = 'Ce commentaire est trop court';
            } else if (empty($comment['content'])) {
                $comment_err = 'Vous ne pouvez pas entrer un commentaire vide.';
            } else if ($comment['note'] == 0) {
                $comment_err = 'Veuillez ajouter une note';
            }

            if (empty($comment_err)) { //Le commentaire est satisfaisant
                if ($this->postModel->addComment($comment)) {
                    flash('message', 'Commentaire ajouté');
                } else {
                    die("Une erreur s'est produite.");
                }
            }
        }
        $post = $this->postModel->getPostById($id);
        $comments = $this->postModel->showPostComments($id);
        $likes = $this->postModel->getLikesCount($id);
        $dislikes = $this->postModel->getDislikesCount($id);

        $data = [
            'post' => $post,
            'comments' => $comments,
            'comment_err' => $comment_err,
            'likesCount' => $likes->count,
            'dislikesCount' => $dislikes->count
        ];

        // load the view
        if ($post === null) {
            redirect('posts');
        } else {
            $this->view('posts/show', $data);
        }
    }

    public function delete($id)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // get current post from model
            $post = $this->postModel->getPostById($id);

            // check for owner
            if ($post->userId !== $_SESSION['user_id'] || $_SESSION['level'] < 2) {
                redirect('posts');
            }

            if ($this->postModel->deletePostById($id)) {
                flash('message', 'Projet supprimé');
                redirect('posts/0');
            } else {
                die("Une erreur s'est produite.");
            }
        } else { // not a post request
            redirect('posts/0');
        }
    }

    public function react($type, $postId)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // sanitize the post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'type' => $type,
                'post_id' => $postId,
                'user_id' => $_SESSION['user_id']
            ];

            if ($this->postModel->findReactionByPostAndUser($data)) { // if reaction already exists
                // udpate reaction
                $this->postModel->updateReaction($data);

                $likesCount = $this->postModel->getLikesCount($postId);
                $dislikesCount = $this->postModel->getDislikesCount($postId);

                echo json_encode([
                    'status' => 'updated',
                    'type' => $type,
                    'likes' => $likesCount->count,
                    'dislikes' => $dislikesCount->count
                ]);
            } else {
                // create reaction
                $this->postModel->createReaction($data);

                $likesCount = $this->postModel->getLikesCount($postId);
                $dislikesCount = $this->postModel->getDislikesCount($postId);

                echo json_encode([
                    'status' => 'inserted',
                    'type' => $type,
                    'likes' => $likesCount->count,
                    'dislikes' => $dislikesCount->count
                ]);
            }
        }
    }

    // for testing
    private function pre_r($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}
