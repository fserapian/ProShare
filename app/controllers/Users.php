<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            redirect('posts');
        }
        // check for post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // process the form

            // sanitize post data as string (at top of prepared statements)
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // init data
            $data = [
                'first_name' => trim($_POST['firstName']),
                'last_name' => trim($_POST['lastName']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirmPassword']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // validate first name
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Le pr&eacute;nom est un champ requis';
            }

            // validate last name
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Le nom est un champ requis';
            }

            // validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Le courriel est un champ requis';
            } else {
                // check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Ce courriel est d&eacute;j&agrave; utilis&eacute; par un autre utilisateur';
                }
            }

            // validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Entrez le mot de passe';
            } else if (strlen($data['password']) < 6) {
                $data['password_err'] = 'Le mot de passe doit contenir au moins 6 caract&egrave;res';
            }

            // validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Confirmez le mot de passe';
            } else if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Les mots de passe entr&eacute; ne se correspondent pas';
            }

            // make sure there is no errors
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // all valid

                // hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // register user in database
                if ($this->userModel->register($data)) { // user created
                    // display success message
                    flash('register_message', 'Bienvenu à ProShare. Connectez-vous!');
                    // redirect to login page
                    redirect('users/login');
                } else { // error
                    die('Something went wrong!');
                }
            } else {
                // load view with errors
                $this->view('users/register', $data);
            }
        } else {
            //init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // load the view
            $this->view('users/register', $data);
        }
    }
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            redirect('posts');
        }
        // check for post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // process the form

            // sanitize post data as string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Entrez l\'adresse courriel';
                // check if user exists (his email exists)
            } else if (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Aucun utilisateur ne correspond &agrave; ce courriel.';
            }

            // validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Entrez le mot de passe';
            }

            // make sure there is no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // all valid

                // check and set logged in user
                $loggedIn = $this->userModel->login($data['email'], $data['password']);

                if ($loggedIn) {
                    // create session

                    $this->createUserSession($loggedIn);
                } else {
                    $data['password_err'] = 'Mot de passe incorrect';

                    $this->view('users/login', $data);
                }
            } else {
                // load the view with errors
                $this->view('users/login', $data);
            }
        } else {
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // load the view with errors
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        // store info in session variables
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_first_name'] = $user->first_name;
        $_SESSION['user_last_name'] = $user->last_name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_password'] = $user->password;
        $_SESSION['member_since'] = $user->created_at;
        $_SESSION['level'] = $user->level;
        $_SESSION['user_image'] = $user->image;

        redirect('posts/0');
    }

    public function settings($user)
    {

        if (!isLoggedIn() || !isset($user) || ($user != $_SESSION['user_id'] && $_SESSION['level'] < 3)) {
            redirect('pages');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $newSettings = [
                    'id' => $user,
                    'fName' => trim($_POST['firstName']),
                    'first_name_err' => '',
                    'lName' => trim($_POST['lastName']),
                    'last_name_err' => '',
                    'email' => trim($_POST['email']),
                    'email_err' => '',
                    'level' => trim($_POST['level']),
                    'image' => $this->userModel->getCurrentImage($user)->image,
                    'password' => trim($_POST['password']),
                    'password_err' => '',
                    'passwordConfirm' => trim($_POST['confirmPassword']),
                    'confirm_password_err' => '',
                ];

                if (empty($newSettings['fName'])) {
                    $newSettings['first_name_err'] = 'Le pr&eacute;nom est un champ requis';
                }

                if (empty($newSettings['lName'])) {
                    $newSettings['last_name_err'] = 'Le nom est un champ requis';
                }

                if (empty($newSettings['email'])) {
                    $newSettings['email_err'] = 'Le courriel est un champ requis';
                }

                if (!empty($newSettings['password'])) {
                    if (strlen($newSettings['password']) < 6) {
                        $newSettings['password_err'] = 'Le mot de passe doit contenir au moins 6 caract&egrave;res';
                    } elseif ($newSettings['password'] != $newSettings['passwordConfirm']) {
                        $newSettings['password_err'] = 'Les mots de passe entr&eacute; ne se correspondent pas';
                    }

                    if (empty($newSettings['password_err'])) {
                        $hashedPassword =  password_hash($newSettings['password'], PASSWORD_DEFAULT);
                    }
                }

                if (!empty($newSettings['first_name_err']) || !empty($newSettings['last_name_err']) || !empty($newSettings['email_err']) || !empty($newSettings['password_err'])) {
                    $this->view('users/settings', $newSettings);
                } else {
                    $flashMessage = '';
                    if ($this->userModel->alterUser($newSettings)) {
                        $flashMessage .= 'Les informations de l\'utilisateur ';
                        if ($_SESSION['user_id'] == $newSettings['id']) {
                            $_SESSION['user_first_name'] = $newSettings['fName'];
                            $_SESSION['user_last_name'] = $newSettings['lName'];
                            $_SESSION['user_email'] = $newSettings['email'];
                        }

                        if (isset($hashedPassword)) {
                            $passChange = [
                                'id' => $newSettings['id'],
                                'newPassword' => $hashedPassword,
                            ];
                            if ($this->userModel->changePassword($passChange)) {
                                $flashMessage .= 'et son mot de passe ';
                            }
                        }
                    } else {
                        die("Une erreur s'est produite.");
                    }

                    if (!empty($flashMessage)) {
                        flash('message', $flashMessage . 'ont &eacute;t&eacute; chang&eacute;es avec succ&egrave;s! ');
                    }
                    $this->view('users/settings', $newSettings);
                }
            } else {
                $userInfo = $this->userModel->getUserById($user);
                $data = [
                    'id' => $userInfo->id,
                    'fName' => $userInfo->first_name,
                    'first_name_err' => '',
                    'lName' => $userInfo->last_name,
                    'last_name_err' => '',
                    'email' => $userInfo->email,
                    'email_err' => '',
                    'level' => $userInfo->level,
                    'image' => $userInfo->image
                ];

                $this->view('users/settings', $data);
            }
        }
    }

    public function admin()
    {
        if ($_SESSION['level'] != 3) {
            redirect('pages');
        } else {
            $data = [
                'users' => $this->userModel->getUsers(),
            ];
            $this->view('users/admin', $data);
        }
    }

    public function upload($userid)
    {
        if (isset($_POST['upload'])) {

            $file = $_FILES['file']; // unused
            $fileName = $_FILES['file']['name'];
            $fileType = $_FILES['file']['type']; //unused
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileError = $_FILES['file']['error'];
            $fileSize = $_FILES['file']['size'];

            $fileParts = explode('.', $fileName);
            $fileExt = strtolower(end($fileParts));

            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($fileExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 3000000) {
                        $fileNewName =
                            [
                                'filename' => uniqid('', true) . '.' . $fileExt,
                                'user' => $userid,
                            ];
                        $fileDestination = 'img/' . $fileNewName['filename'];

                        move_uploaded_file($fileTmpName, $fileDestination);
                        // get old picture name
                        $oldpic = 'img/' . $this->userModel->getCurrentImage($userid)->image;

                        // save file name in database
                        if ($this->userModel->saveFile($fileNewName)) {
                            if ($oldpic != 'img/anonymous.jpg') {
                                unlink($oldpic);
                            }
                            flash('message', 'Photo de profil changé');
                            $_SESSION['user_image'] = $fileNewName['filename'];
                            redirect('posts/0');
                        } else {
                            die('Erreur !');
                        }

                        // redirect('posts?uploaded');
                    } else {
                        flash(
                            'upload_message',
                            'Fichier trop large. Il ne doit pas dépasser 3Mo',
                            'card-panel white-text red'
                        );
                        redirect('users/settings/' . $_SESSION['user_id']);
                    }
                } else {
                    echo "Une erreur s'est produite";
                }
            } else {
                flash('upload_message', 'Extension invalide. Entrez jpg, jpeg ou png', 'card-panel white-text red');
                redirect('users/settings/' . $_SESSION['user_id']);
            }
        }
    }

    public function logout()
    {
        // unset session variables
        unset($_SESSION['user_id']);
        unset($_SESSION['user_first_name']);
        unset($_SESSION['user_last_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_password']);
        unset($_SESSION['member_since']);
        unset($_SESSION['level']);
        unset($_SESSION['user_image']);

        session_destroy();

        redirect('users/login');
    }
}
