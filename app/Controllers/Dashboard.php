<?php
namespace App\Controllers;
class Dashboard extends BaseController
{   
	
	protected $courseModel;
	protected $userEnrolmentsModel;
	protected $username;

	public function __construct(){
		$this->courseModel = new \App\Models\Course_model();
		$this->userEnrolmentsModel = new \App\Models\Enrolment_model();

		$session = session();
		$this->username = $session->get("username");
	}
	
	// display the courses at the dashboard.
	public function index() {
		$courseids = $this->userEnrolmentsModel->getCourses($this->username);

		echo view("template/header");
		echo view("dashboard", ["courseids" => $courseids]);
		echo view("template/footer");
	}

	// add a course 

}
