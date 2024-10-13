<?php


namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{

    protected $db;
    protected $username;
    protected $password;

    public function __construct() {
        $this->db = \Config\Database::connect();
        $session = session();
        $this->username = $session->get('username');
        $this->password = $session->get('password');
    }

    public function login($username, $password) 
    {
        $builder = $this->db->table('users');
        
        $builder->where('username', $username);
        $query = $builder->get();
        $user = $query->getRowArray();
        //if result returned from getrowarray() is empty, then no user exists with that username.
        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfile($username) {
        $builder = $this->db->table('users');

        $builder->where('username', $username);
        $query = $builder->get();
        
        return $query->getRowArray();
    }

    public function updateDetails($data) {
        // get user's id.
        $user = $this->getProfile($data['username']);
        $id = $user['id'];

        if (empty($data['phoneNumber'])) {
            $data['phoneNumber'] = $user['phoneNumber'];
        }

        if (empty($data['email'])) {
            $data['email'] = $user['email'];
        }
        
        $builder = $this->db->table('users');
        $builder->where('id', $id)->update($data);
    }

    public function updateProfilePicture($username, $password, $image) {
        $data = [
            'profilePicture' => $image,
        ];

        $user = $this->getProfile($username);
        $id = $user['id'];

        $builder = $this->db->table('users');
        $builder->where('id', $id)->update($data);
    }

    public function addUser($data) {
        $builder = $this->db->table('users');
        $builder->insert($data);
    }
    
    public function isEmailInUse($email) {
        $builder = $this->db->table('users');
        $builder->where('email', $email);
        $query = $builder->get();

        if ($query->getRowArray()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateResetToken($userTokenEmail) {

        $data = [
            'resetTokenTime' => date('Y-m-d h:i:s'),
            'resetToken'     => $userTokenEmail['token'],
        ];

        $builder = $this->db->table('users');
        $builder->where('email', $userTokenEmail['email'])->update($data);
    }

    public function removeResetToken($token) {
        $date = date('Y-m-d h:i:s', strtotime('-1 Year'));
        $builder = $this->db->table('users');
        $builder->where('resetToken', $token);
        $builder->update(['resetTokenTime' => $date]);
    }

    public function verifyResetToken($token) {
        $builder = $this->db->table('users');
        $builder->select('id, email, resetTokenTime')->where('resetToken', $token);
        $query = $builder->get();

        return $query->getRowArray(); //might change this.

    }

    public function updatePassword($token, $password) {
        $builder = $this->db->table('users');
        $builder->where('resetToken', $token);
        $builder->update(['password' => $password]);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllEmailsForCourse($course) {
        $builder = $this->db->table('users');
        $builder->join('enrolment', 'enrolment.userID = users.id')
                ->where('enrolment.courseID', $course)
                ->select('email');
        $query = $builder->get();
        return $query->getResultArray();
    }
}

?>