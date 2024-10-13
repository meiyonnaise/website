<?php


namespace App\Models;

use CodeIgniter\Model;

class UserFavourites_model extends Model
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

    public function addToFavourites($postId, $userId) {
        $builder = $this->db->table('userFavourites');
        $data = [
            'postID' => $postId,
            'userID' => $userId,
        ];
        $builder->insert($data);
    }
}

?>