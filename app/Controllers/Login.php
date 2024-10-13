<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index() {
        $data['error']= "";
        // if user has a cookie then go to dashboard.  
        if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
            return redirect()->to(base_url()."dashboard");
        }
       
        else {
            $session = session();
            $username = $session->get("username");
            $password= $session->get("password");

            if ($username && $password) {
                 // if user does not have a cookie but is in a session, then redirect them to dashboard.
                return redirect()->to(base_url()."dashboard"); 
            } else {
                echo view('template/header');
                echo view('login', $data);
                echo view('template/footer');
                return;
        }
           
    }
}

    public function check_login() {
        $data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new \App\Models\User_model();
        $check = $model->login($username, $password);
        $if_remember = $this->request->getPost("remember");

        if ($check) {
            # Create a session
            $session = session();
            $session->set('username', $username);
            $session->set('password', $password);
            
            if ($if_remember) {
                #Create a cookie
                setcookie("username", $username, time() + (86400 * 30 ), "/");
                setcookie("password", $password, time() + (86400 * 30), "/");
            }

            return redirect()->to(base_url()."dashboard"); // redirect to dashboard
            
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
		}
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        // Destory the cookie 
        setcookie("username", "", time() - 3600, "/");
        setcookie("password", "", time() - 3600, "/");
        return redirect()->to(base_url());
    }
}
?>
