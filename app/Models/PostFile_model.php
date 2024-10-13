<?php
namespace App\Models;

use CodeIgniter\Model;

class PostFile_model extends Model
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

    public function uploadFile($postId, $fileName) {
        $data = [
            'postId' => $postId,
            'fileName' => $fileName,
        ];
        
        $builder = $this->db->table('PostFiles');
        $builder->insert($data);
    }


}