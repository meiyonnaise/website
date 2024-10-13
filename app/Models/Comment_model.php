<?php
namespace App\Models;

use CodeIgniter\Model;

class Comment_model extends Model
{   
    protected $db;

    public function __constructor() {
        $this->db = \Config\Database::connect();
    }

    public function getComments($courseid) 
    {
        $builder = $this->db->table('comments');
        $builder->join('Posts', 'Posts.id = comments.postID')->join('users', 'users.id = comments.userID');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function addComment($postID, $comment, $userID) {
        $builder = $this->db->table('comments');

        $data = [
            'postID'    => $postID,
            'comment'   => $comment,
            'userID'    => $userID,
        ];
        
        $builder->insert($data);
        
    }
}

?>