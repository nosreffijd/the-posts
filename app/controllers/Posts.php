<?php
    class Posts extends Controller {
        public function __construct () {
            if (!isLoggedIn()) {
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
        }

        public function index () {
            //Get Post
            $posts = $this->postModel->getPosts();
            $data = [
                'posts' => $posts
            ];
            $this->view('posts/index', $data);
        }

        public function add () {
            if ($_SERVER['REQUEST_METHOD'] ==  'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'title_err' => '',
                    'body_err' => '' 
                ];

                // Validate data
                if (empty($data['title'])) {
                    $data['title_err'] = 'Please enter title';
                }
              
                if (empty($data['body'])) {
                    $data['body_err'] = 'Please enter body';
                }
                // Make sure no errors
                if (empty($data['title_err']) && empty($data['body_err'])) {
                    // Vlidated
                    if ($this->postModel->addPost($data)) {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    //Load views with errors
                    $this->view('posts/add', $data);
                }
            } else {
                $data = [
                    'title' => '',
                    'body' => ''
                ];
                $this->view('posts/add', $data);
            }
        }
    }