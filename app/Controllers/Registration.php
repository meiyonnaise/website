<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class Registration extends BaseController
{
    protected $session;
    protected $userModel;
    protected $userDetails;

    public function __construct()
    {
        $this->session = session();
        $this->userModel = new \App\Models\User_model();
    }

    public function index()
    {
        $data['errors'] = "";
        echo view('template/header');
        echo view('registration');
        echo view('template/footer');
        return;
    }

    public function register()
    {
        $data["errors"] = "";

        $verificationCode = md5(uniqid(rand(), true));

        $validationRules = [
            'username'    => 'required|is_unique[users.username, true]',
            'phoneNumber' => 'required|regex_match[/^[0-9]{10}$/]',
            'email'       => 'required|valid_email|is_unique[users.email, true]',
            'password'    => 'required|min_length[6]|max_length[25]|is_password_strong',
        ];

        if (!$this->validate($validationRules)) {
            $data['validation'] = $this->validator;
            echo view('template/header');
            echo view('registration', $data);
            echo view('template/footer');
            return;
        }

        $data = [
            'username'              => $this->request->getPost('username'),
            'password'              => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email'                 => $this->request->getPost('email'),
            'sex'                   => $this->request->getPost('sex'),
            'phoneNumber'           => $this->request->getPost('phoneNumber'),
            'firstName'             => $this->request->getPost('firstName'),
            'lastName'              => $this->request->getPost('lastName'),
            'emailVerificationCode' => $verificationCode,       // REFERENCE: https://stackoverflow.com/q/2088969
        ];

        $this->userModel->addUser($data);
        echo "<p>user successfully added to database";

        $email = new Email();

        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25,
        ];

        $email->initialize($emailConf);
        $email->setFrom("unitalk3202@gmail.com");
        $email->setTo($this->request->getPost('email'));
        $email->setSubject('Email Verification for UniTalk');
        $email->setMessage('Please log in to your account, click on profile and enter this verification code:   ' . $verificationCode);

        if (!$email->send()) {
            echo "email didn't send";
        }

        return redirect()->to(base_url() . "register/verify_email");
        // model->updateDatabase.
        // make username, phone number and email unique in phpmyadmin.
        // add more rules for username, email, phone number
    }

    public function verifyEmail()
    {
        echo view('template/header');
        echo view('verifyEmailMessage');
        echo view('template/footer');
    }
}
