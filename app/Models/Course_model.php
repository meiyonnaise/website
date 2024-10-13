<?php
namespace App\Models;

use CodeIgniter\Model;

class Course_model extends Model
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

    public function getAllCourses() {
        $builder = $this->db->table('Courses');
        $query= $builder->get();
        return $query->getResultArray();
    }
    
}

?>