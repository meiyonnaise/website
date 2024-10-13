<?php
namespace App\Models;

use CodeIgniter\Model;

class Post_model extends Model
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

    public function getPosts($courseid) {
        $builder = $this->db->table('Posts');
        //get all the informaiton of the post
        $builder->where('courseid', $courseid);
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function getPost($postid) {
        $builder = $this->db->table('Posts');
        $builder->where('id', $postid);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function createPost($courseid, $userid, $title, $question) {
        $date = strtotime(date('Y-m-d'));

        $data = [
            'courseid' => $courseid,
            'userid' => $userid,
            'title' => $title,
            'message' => $question,
            'date' => $date,
        ];

        $builder = $this->db->table('Posts');
        $builder->insert($data);
    }

    public function getPostId($courseid, $userid, $title, $question) {
        $builder = $this->db->table('Posts');
        $builder->where('courseid', $courseid)->where('userid', $userid)->where('title', $title)->where('message', $question);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function incrementPostViews($postid) {
        $builder = $this->db->table('Posts');
        $builder->where('id', $postid);
        $builder->increment('numViews', 1);
    }
}
?>