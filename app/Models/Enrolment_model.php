<?php
namespace App\Models;

use CodeIgniter\Model;

class Enrolment_model extends Model
{
    protected $db;
    protected $username;

    public function __construct() {
        $this->db = \Config\Database::connect();
        
        $session = session();
        $this->username = $session->get('username');
    }
    // gets courses the user is enrolled in.
    public function getCourses($username) 
    {

        $builder = $this->db->table('enrolment');
        
        $builder->select('courseid')->join('users', 'users.id = enrolment.userID')->where('users.username', $username);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function enrolInCourse($data) {
        $builder = $this->db->table('enrolment');
        
        $builder->insert($data);
    }
}

?>