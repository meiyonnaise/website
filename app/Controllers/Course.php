<?php


namespace App\Controllers;

use CodeIgniter\Email\Email;

class Course extends BaseController
{
    protected $username;
    protected $password;
    protected $userID;

    protected $postModel;
    protected $commentsModel;
    protected $userModel;
    protected $postFileModel;

    protected $uri;
    protected $course;

    public function __construct()
    {
        $session  = session();
        $this->username = $session->get('username');
        $this->password = $session->get('password');

        $this->postModel = new \App\Models\Post_model();
        $this->commentsModel = new \App\Models\Comment_model();
        $this->userModel = new \App\Models\User_model();
        $this->postFileModel = new \App\Models\PostFile_model();

        $this->uri = uri_string();
        $this->course = explode("/", $this->uri)[1];
    }

    public function index()
    {
        $allPosts = $this->postModel->getPosts($this->course);

        echo view('template/header');
        echo view("course", ['id' => $allPosts, 'specifcPost'=> ""]); // pass in data about the course. get the data from dashboard view.
        echo view("template/footer");
        return;
    }

    //returning posts in a json format
    public function getPostsAsJson()
    {
        $allPosts = $this->postModel->getPosts($this->course);

        return $this->response->setJSON($allPosts);
    }

    //returning comments in a json format 
    public function getCommentsAsJson()
    {
        $allComments = $this->commentsModel->getComments($this->course);
        return $this->response->setJSON($allComments);
    }

    //add a comment to a course Post    
    public function addComment()
    {
        $userDetails = $this->userModel->getProfile($this->username);
        $userID = $userDetails['id'];
        $comment = $this->request->getPost('addComment');
        $postID = explode("/", $this->uri)[3];

        $this->commentsModel->addComment($postID, $comment, $userID);
        return redirect()->to(base_url() . "course/" . $this->course);
    }

    public function showForm()
    {
        $data['course'] = $this->course;
        $data['postID'] = explode("/", $this->uri)[3];

        $formContent = view('commentForm', $data);
        $response    = $this->response->setBody($formContent);
        $response->setHeader('Content-Type', 'text/html');
        return $response;
    }

    public function showCreatePostForm()
    {
        return view('createPostForm');
    }

    // Adds post to database and post files to database.
    public function processCreatePostForm()
    {
        $rules = [
            'files.*' => 'permit_empty|uploaded[files]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif]',
            'title' => 'required',
            'question' => 'required',
        ];

        if ($this->validate($rules)) {

            // Insert all post data, except files to Post table. 
            $userDetails = $this->userModel->getProfile($this->username);
            $userid = $userDetails['id'];
            $courseid = $this->course;
            $title = $this->request->getPost('title');
            $question = $this->request->getPost('question');
            var_dump($question);

            $this->postModel->createPost($courseid, $userid, $title, $question);
            $postInformation = $this->postModel->getPostId($courseid, $userid, $title, $question);
            $postId = $postInformation['id'];

            // Insert files to postFile table.
            $files = $this->request->getFiles();
            if ($files) {
                foreach ($files['files'] as $file) {
                    if ($file) {
                        $newName = $file->getRandomName();
                        $path = ROOTPATH . 'writable/uploads/';
                        $file->move($path . $newName);
                        $this->postFileModel->uploadFile($postId, $newName);
                    }
                }
            }
        }

        $this->notify_users_of_new_post($title, $question);
        return $this->index();
    }

    public function notify_users_of_new_post($title, $postMessage)
    {
        $email = new Email();
        $emailList = $this->userModel->getAllEmailsForCourse($this->course);

        foreach ($emailList as $userEmail) {
            $fromEmail = "unitalk3202@gmail.com";
            $subject = "UniTalk Your classmate Has Created a New Post";
            $message = "Title: ".$title . ".   Question: " . $postMessage;

            $emailConf = [
                'protocol' => 'smtp',
                'wordWrap' => true,
                'SMTPHost' => 'mailhub.eait.uq.edu.au',
                'SMTPPort' => 25,
            ];

            $email->initialize($emailConf);
            $email->setFrom($fromEmail);
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->setTo($userEmail['email']);

            if ($email->send()) {
                log_message('error', $userEmail['email'] . "email sent");
                $email->clear();
            } else {
                log_message('error', $userEmail['email'] . "email not sent");
            }
        }
    }

    public function showSpecificPost() {
        $postid = explode("/", $this->uri)[3];
        $post = $this->postModel->getPost($postid);
        $allPosts = $this->postModel->getPosts($this->course);
        
        echo view('template/header');
        echo view("course", ['id' => $allPosts, 'specificPost' => $post]); // pass in data about the course. get the data from dashboard view.
        echo view("template/footer");
        $this->postModel->incrementPostViews($postid);
    }

    public function incrementViewsByAjax() {
        $postid = explode("/", $this->uri)[3];
        $this->postModel->incrementPostViews($postid);
    }
}

