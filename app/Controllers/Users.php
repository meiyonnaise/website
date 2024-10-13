<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class Users extends BaseController
{   
    protected $session;
    protected $username;
    protected $password;

    protected $userModel;
    protected $userFavouritesModel;
    protected $userDetails;
    protected $enrolmentModel;
    protected $uri;

    public function __construct() {
        $this->session = session();
        $this->username = $this->session->get('username');
        $this->password = $this->session->get('password');
        
        $this->userModel = new \App\Models\User_model();
        $this->userDetails = $this->userModel->getProfile($this->username);
        $this->userDetails['error'] = "";

        $this->enrolmentModel = new \App\Models\Enrolment_model();
        $this->userFavouritesModel = new \App\Models\UserFavourites_model();

        $this->uri = uri_string();
    }

    public function index() {
        $this->userDetails['error'] = "";
        
        if (empty($this->username)) {
            return redirect()->to(base_url());
        }

        if ($this->userDetails['emailVerified']) {
            $this->userDetails['emailVerifiedString'] = "Your email has been verified";
        } else {
            $this->userDetails['emailVerifiedString'] = "Your email has not been verified";
        }

        echo view('template/header');
        echo view('profile', ['id' => $this->userDetails]);
        echo view('template/footer');
        return;
    }

    public function updateUserInfo() {
        $email = $this->request->getPost('email');
        $phoneNumber = $this->request->getPost('phoneNumber');

        $validationRules = [
            'phoneNumber' => 'permit_empty|min_length[9]|max_length[10]',
            'email' => 'permit_empty|valid_email',
        ];
        
        if (!$this->validate($validationRules)) {
            $this->userDetails['error'] = "either phoneNumber is invalid or email is invalid";

            echo view('template/header');
            echo view('profile', ['id' => $this->userDetails]);
            echo view('template/footer');
            return;
            // return redirect()->to(base_url()."profile");
        }

        $data = [
            'username'          => $this->username,
            'password'          => $this->password,
            'email'             => $email,
            'phoneNumber'       => $phoneNumber,
        ];

        $this->userModel->updateDetails($data);
        return redirect()->to(base_url()."profile");

    }

    public function updateEmailVerified() {
        $userInputCode = $this->request->getPost('verificationCode');
        if ($userInputCode === $this->userDetails['emailVerificationCode']) {
            $data = [
                'username'          => $this->username,
                'password'          => $this->password,
                'emailVerified'     => 1,
            ];
   
            $this->userModel->updateDetails($data);
            return redirect()->to(base_url()."profile");
            
        } else {
            return redirect()->to(base_url()."profile");
        }
    }

    public function uploadProfilePicture() {
        $rules = [
            'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,jpg,jpeg,png,gif]',
        ];
        
        if ($this->validate($rules)) {
            $image = $this->request->getFile('image');
            $imageType = $image->getClientMimeType(); // to check if type is correct. do this later.
            $newName = $image->getRandomName();
            
            $path = ROOTPATH.'writable/uploads/';
            
            $data['success'] = 'Image uploaded successfully.';
            $data['original'] = '/demo/writable/uploads/'.$newName;

            $configureImage = \Config\Services::image();

            $configureImage->withFile($image)
                           ->resize(100, 100, true, 'height')
                           ->save($path.$newName);

            $this->userModel->updateProfilePicture($this->username, $this->password, $newName);

            return redirect()->to(base_url()."profile");


        } else {
            // $data['validation'] = $this->validator; do this later.
            return redirect()->to(base_url()."profile");
        }
      
    }

    public function showForgotPasswordForm() {
        $data['error'] = "";
        echo view('template/header');
        return view('forgotPassword', $data);
    }

    public function resetPasswordEmail() {
        $userEmail = $this->request->getPost('email', FILTER_SANITIZE_EMAIL); //might cause error filter
        $isEmailInUse = $this->userModel->isEmailInUse($userEmail);

        if ($isEmailInUse) {
            $token = md5(uniqid(rand(), true));

            $data = [
                'email' => $userEmail,
                'token' => $token,
            ];

            $this->userModel->updateResetToken($data);

            $fromEmail = "unitalk3202@gmail.com";
            $link = base_url()."reset_password/$token";
            $subject = "Reset Your Password";
            $message = "You request to reset your password has been received. Please click on this link below to reset your password 
                        '$link' .
                        Please verify within 10 minutes.";

            $emailConf = [
                'protocol' => 'smtp',
                'wordWrap' => true,
                'SMTPHost' => 'mailhub.eait.uq.edu.au',
                'SMTPPort' => 25,
            ];

            $email = new Email();
            $email->initialize($emailConf);
            $email->setFrom($fromEmail);
            $email->setTo($userEmail);
            $email->setSubject($subject);
            $email->setMessage($message);

            if (!$email->send()) {
                $data = $email->printDebugger(['headers']);
                echo view('template/header');
                echo "email didn't send <br>";
                echo $data;
            } else {
                session()->setTempData('resetEmailSent', "An password reset link has been sent to your email.");
                return redirect()->to(base_url());

            }

            
        } else {
            $data['error'] = "This email is not in use.";
            echo view('template/header');
            echo view('forgotPassword', $data);
            return;
        }

        // check if email is in database. 
    }

    public function resetPassword() {
        $token = explode("/", $this->uri)[1];
        $tokenDetails = $this->userModel->verifyResetToken($token);
        $data['token'] = $token;
        //if the token still exists in the database
        if (!empty($tokenDetails)) {
            // if token is in database then check expiry date.
            $time = $tokenDetails['resetTokenTime'];
            $isTokenValid = $this->checkTokenDate($time);

            if ($isTokenValid) {

                if ($this->request->getMethod() == 'post') {
                    $rules = [
                        'password' => [
                                    'label' => "Password",
                                    'rules' => 'required|min_length[6]|max_length[25]',
                        ],
                        'passwordconf' => [
                                        'label' => 'Confirm Password',
                                        'rules' => 'required|matches[password]',
                        ],
                    ];

                    if ($this->validate($rules)) {
                        $unhashedPassword = $this->request->getPost('password');
                        $password = password_hash($unhashedPassword, PASSWORD_DEFAULT);
                        if ($this->userModel->updatePassword($token, $password)) {
                            session()->setTempdata('success', 'Password updated successfuly');
                            $this->userModel->removeResetToken($token);
                            return redirect()->to(base_url());

                        } else {
                            session()->setTempdata('error', 'Sorry! Unable to update Password. Try again.');
                            return redirect()->to(current_url());
                        }
                    } else {
                        $data['validation'] = $this->validator;
                    }
                }

            } else {    //token has gone past its 10 minute timer.
                echo view('template/header');
                echo "Sorry but the link to reset your password is no longer available.";
                return;
            }
        } else {
            echo view('template/header');
            echo "Sorry but the link to reset your password is no longer available.";
            return;
        }
    
        echo view('template/header');
        return view('resetPassword', $data);
        
    }

    public function checkTokenDate($time) {
        $tokenTime = strtotime($time);
        $currentTime = strtotime(date('Y-m-d h:i:s'));
        $interval = $currentTime-$tokenTime;

        if ($interval < 600) {
            return true; // token is still valid
        } else {
            return false;
        }
    }

    public function enrolInCourse() {
        // edit dashboard view so that it has a form to add courses. 
        $courseID = $this->request->getPost('selectedCourse');
        $userID   = $this->userDetails['id'];

        $data = [
            'courseID'     => $courseID,
            'userID'       => $userID,
        ];

        $this->enrolmentModel->enrolInCourse($data);

        return redirect()->to(base_url());

    }

    public function addToFavourites() {
        $postId   = $this->request->getPost('postId');
        $userId   = $this->userDetails['id'];
        $this->userFavouritesModel->addToFavourites($postId, $userId);
        return;
    }
}