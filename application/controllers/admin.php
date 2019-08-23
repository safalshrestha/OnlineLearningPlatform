<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata("email")) {
			$this->welcome();
		}
		else {
			$data['page'] = "main";

			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();
		
			$this->load->view('index', $data);
		}
	}
	
	public function login()
	{
		//error_reporting(0);
		//$this->load->view('welcome_message');
		if ($this->input->post('email') || $this->input->post('password')) {
			$this->input->post('email');
			$this->input->post('password');
			
			$this->load->helper(array('form', 'url'));
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('email','email','trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password','password','trim|required|xss_clean');
			
			if ($this->form_validation->run()) {

				//$this->db->insert('users', array('email'=>$this->input->post('email'), ');
				$data['status'] = "";
				$this->db->where("email",$this->input->post('email'));
				$this->db->where("password",md5($this->input->post('password'))); //no salting yet
				$query = $this->db->get("users");

				$options = array("email"=>$this->input->post('email'), "password"=>$this->input->post('password') );

				if($this->users_model->getUsers($options)) {
					$this->session->set_userdata('email',$this->input->post('email'));
					$row = $query->row();//first row of the query
					$this->session->set_userdata('user_id', $row->id);
					$this->session->set_userdata('privilege', $row->privilege);
					$this->welcome();

				}else{
					$data['page'] = "login_form";
					$data['status'] = "Login Mismatch";
					$data['nav'] = $this->_genNavigation();
					$this->load->view('index', $data);
				}
			}
			else {
				$data['page'] = "login_form";
				$data['status'] = "Invalid data";
				$data['nav'] = $this->_genNavigation();
				$this->load->view('index', $data);
			}
		}
		else {
			$data['page'] = "login_form";
			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();
			$this->load->view('index', $data);
		}
	}
	
	public function forgot_form($status)
	{
		$data["page"] = "forgot_form";
		if (isset($status)) {
			$data['status'] = $status;
		}
		else $data['status'] = "";
		$data['nav'] = $this->_genNavigation();
		$this->load->view('index',$data);
	}


	public function logout(){
		$this->session->unset_userdata("email");
		$this->session->unset_userdata("privilege");
		$this->index();
	}

	public function forgotpassword_form(){
		$data['page'] = 'forgot_form';
		$data['status'] = '';
		$data['nav'] = $this->_genNavigation();
        $this->load->view('index', $data);
    }

    public function retrievepassword(){
    	$this->load->library('form_validation');
        $this->form_validation->set_rules('email','email','trim|required|xss_clean|valid_email');

        if($this->form_validation->run()){
            $options['email'] = trim($this->input->post('email'));
            $options['id'] = trim($this->input->post('id'));
            $query = $this->users_model->GetUsers($options);
            if(count($query) > 0){
                $uniqueId = $this->users_model->generatePassword();
                
                /* FOR EMAILING/NOT IMPLEMENTED COMPLETELY
                $data['email'] = $this->input->post('email');
                $data['password'] = $uniqueId;
                $this->users_model->UpdateUser($data);

                $query2 = $this->db->get_where("newsletters", array('id'=>11))->row(0);

                $options['from'] = $provider->email;
                $options['name'] = $provider->name;
                $options['to'] = $this->input->post('email');
                $options['subject'] = $query2->subject;
                $options['message'] = str_replace(array('[USERNAME]', '[SITEURL]', '[PASSWORD]'),
                    array($this->session->userdata('userId'), 'http:'.site_url(), $uniqueId ), $query2->body);
                $this->users_model->sendMail($options);

                $data['page'] = 'forgotpassword';
                $data['status'] = 'New password sent to your mailbox.';
                */
                $data['id'] = $this->input->post('id');
				$data['password'] = $uniqueId;
				$this->users_model->changePassword($data);
                $this->forgot_form($uniqueId);
            }else{

                $this->forgot_form("verification");
            }
        }else $this->forgot_form("validation");
    }
    

    //navigation menu based on user privilege
    public function _genNavigation(){
    	
    	$navs = $this->db->get_where("nav", array("privilege"=>$this->users_model->getPrivilege()))->result();
    	return $navs;
    }

    

    //Similar to user_profile but takes the data to fill in the main after login page.
    public function welcome() {
    	$this->welcome2('Announcements');
    }
	public function welcome2($content){
		$data['page'] = "welcome";
		$data['status'] = "Success";
		$data['nav'] = $this->_genNavigation();
		$data['priv'] = $this->users_model->getPrivilege();
		$user_id = $this->session->userdata('user_id');
		$priv = $data['priv'];
		if ($content == "Announcements") {
			$data['content'] = "Announcements";
		}
		else if ($content == "help") {
			$data['content'] = "Support";
		}
		else {
			$data['content'] = "Course";
			$data['weeks'] = $this->users_model->getWeeksData($content);
		}
		switch ($this->users_model->getPrivilege()) {
			case 1:
				//admin
				$this->users_model->adminGuard();
				break;
			case 2:
				//faculty head
				$this->users_model->facultyGuard();
				break;
			case 3:
				$this->users_model->lecturerGuard();
				//lecturers
				break;
			case 8:
				//students
				$this->users_model->sessionGuard();
				break;
			case 9:
				//TODO: parents
				$this->users_model->sessionGuard();

				break;
			default:
				redirect("admin/logout");
				
				break;
		}

		if ($priv == 8 || $priv == 9) {
				$this->db->order_by("batch_id", "desc");
				$q = $this->db->get_where("student_subject", array("student_id"=> $user_id))->row(0);
				$subject_id = $q->subject_id;
				$batch_id = $q->batch_id;
				//QUERY FOR COURSE ID
				$q = $this->db->get_where("subjects", array("id"=>$subject_id))->row(0);
				$data['course'] = $q->course_id;
				//QUERY FOR LATEST BATCH SUBJECTS
				$data['subjects'] = $this->db->get_where("student_subject", array("batch_id"=>$batch_id , "student_id"=>$user_id))->result();
				$data['subject_name'] = $this->db->get("subjects")->result();
		}
		else if ($priv == 2 || $priv == 5 || $priv == 1) {
				$data['course'] = "Subjects List:";
				$data['subjects'] = $this->db->get_where("subject_lecturer", array("lecturer_id"=>$user_id))->result();
				$data['subject_name'] = $this->db->get("subjects")->result();		
		}
		$data['notices'] = $this->users_model->latestNotice();
		$data['users'] = $this->db->get_where("personal_details", array("user_id"=>$user_id ))->result();
		$this->load->view('index', $data);	//passing variable to view
	}

	public function Announcements() {

		$this->welcome();
	}
	private function changePassword() {
		if ($this->input->post("npassword") == $this->input->post("cnpassword")) return false;
		else {
			if ($this->input->post('id') || $this->input->post('npassword') || $this->input->post('cpassword')) {
				$option['id'] = $this->input->post("id");
				$option['password'] = $this->input->post("cpassword");

				if($this->users_model->getUsers($options)) {
					$data['id'] = $this->input->post('id');
					$data['password'] = $this->input->post('npassword');
					$this->users_model->changePassword($data);
				}
				else return false;
			}
		}
	}

	

	//single user register
	public function register($options = array()){
		if(!$options['email']) return false;
		if(!$options['privilege']) return false;
		
		$options['id'] = $this->users_model->getUniqueUserId();
        $options['password'] = md5($this->users_model->generatePassword());

		if($this->users_model->AddUser($options)) return $options;
		//insert into subject_student table
	}

	//-------------------------------------------------------------------------------------------------------
	
	public function students(){
		$this->users_model->adminGuard();
    	//add group users function + single user
   
    	$data['page'] = "admin/add_users";

    	$this->db->where("privilege", 8);
    	$data['users'] = $this->db->get("users")->result();

    	$data['faculty'] = $this->db->get("faculty")->result();
    	$data['courses'] = $this->db->get("courses")->result();
    	$data['batch'] = $this->db->get("batch")->result();
    	
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)

    }

    public function addStudents(){
		$options['email'] = $this->input->post('email');
		$options['privilege'] = $this->input->post('privilege');
		
		//var_dump($options['privilege']);
		//var_dump($options['email']);


		$credentials = $this->register($options);
		$data['student_id'] = $credentials['id'];
		//if(!$credentials['student_id'] || $data['student_id'] != "" || $data['student_id'] != 0){
		if(count($credentials) > 0){
			//assign subjects to student
			$subjects= $this->db->get_where("subjects", array("course_id"=>$this->input->post('course_id')))->result();
			$data['batch_id'] = $this->input->post('batch_id');
			
			foreach($subjects as $subject){
				$data['subject_id'] = $subject->id;
				$this->db->insert("student_subject", $data);
			}
			//email user
			/*
              $options['from'] = '';
              $options['name'] = '';
              $options['to'] = '';
              $options['subject'] = '';
              $options['message'] = '';
            */
            $options['from'] = "admin@eSiksha.com";
            $options['name'] = "eSiksha";
            $options['to'] = $options['email'];
            $options['subject'] = "Welcome to eSiksha";
            $options['message'] = "Your password is: ".$credentials['password'];
            $this->users_model->sendMail($options);



		}else echo "0"; //false

	}
	public function deleteStudents() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else if($this->input->post('email')) {
			$options['email'] = $this->input->post('email');
		}
		else return false;

		$this->users_model->deleteStudents($options);
	}

	public function progressStudent(){
		$data['student_id'] = $this->input->post('student_id');
		$subjects = $this->input->post('subject');
		$data['batch_id'] = $this->input->post('batch_id');
		foreach($subjects as $subject){
				$data['subject_id'] = $subject;
				$this->db->insert("student_subject", $data);
			}
		redirect('admin/students', 'refresh');
	}

    public function lecturers(){
    	//add group users function + single user
    	
    	$this->db->where("privilege", 5);
    	$data['users'] = $this->db->get("users")->result();

    	$data['page'] = "admin/add_lecturer";
    	$data['courses'] = $this->db->get("courses")->result();
    	$data['subjects'] = $this->db->get("subjects")->result();
    	
    	
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)
    }

    public function addLecturer(){
		$options['email'] = $this->input->post('email');
		$options['privilege'] = 5;
		$subjects = $this->input->post('subject');

		$data['lecturer_id'] = $this->register($options);

		if(!$data['lecturer_id'] || $data['lecturer_id'] != "" || $data['lecturer_id'] != 0){
			//assign subjects to student
			foreach ($subjects as $subject_id ) {
				$data['subject_id'] = $subject_id;
				$this->db->insert("subject_lecturer", $data);
			}
		}else echo "0"; //false

	}

	public function deleteLecturer() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else if($this->input->post('email')) {
			$options['email'] = $this->input->post('email');
		}
		else return false;

		$this->users_model->deleteLecturer($options);
	}

	//GET ALL COURSES, SUBJECTS, BATCHES FOR ADDING USERS
	//JSON DATA IS NEEDED SINCE, php can't run inside script
	//Other JSON function to PROGRESS Student
	public function getAllCourses(){
		$this->db->select("id, faculty_id, name");
		$courses = $this->db->get("courses")->result();

		echo json_encode($courses);
	}

	public function getAllSubjects(){
		$this->db->order_by("course_id");
		$this->db->select("id, course_id, name");
		$subjects = $this->db->get("subjects")->result();

		echo json_encode($subjects);
	}

	public function getAllBatch(){
		$this->db->order_by("id");
		$this->db->select("id, name");
		$batch = $this->db->get("batch")->result();
		
		echo json_encode($batch);
	}



    public function admins(){
    	
    	//add group users function + single user
    	$this->db->where("privilege", 2);
    	$data['users'] = $this->db->get("users")->result();
    	
    	$data['page'] = "admin/add_admin";
    	$data['courses'] = $this->db->get("courses")->result();
    	$data['subjects'] = $this->db->get("subjects")->result();
    	
    	
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)
    }

    public function addHeads(){
		$options['email'] = $this->input->post('email');
		$options['privilege'] = 2;
		$courses = $this->input->post('course');
		echo $courses;

		$data['lecturer_id'] = $this->register($options);
		if(!$data['lecturer_id'] || $data['lecturer_id'] != "" || $data['lecturer_id'] != 0){
			//assign subjects to admin

			foreach ($courses as $course_id) {
				$this->db->select("id");
				$subjects = $this->db->get_where("subjects", array("course_id"=>$course_id))->result();
				//var_dump($subjects);
				foreach ($subjects as $subject_id ) {
					$data['subject_id'] = $subject_id->id;
					$this->db->insert("subject_lecturer", $data);
				}
			}
			
		}else echo "0"; //false

	}

	public function deleteHead() {
		if($this->input->post('id')) {
			$option['id'] = $this->input->post('id');
		}
		else if($this->input->post('email')) {
			$options['email'] = $this->input->post('email');
		}
		else return false;

		$this->users_model->deleteLecturer($options);
	}

	


	//***************************************************************************
	//-----------------------------------------------------------------------------------------------------------

	//**************************************************************************************
	public function updateUser() {

		//var_dump($_POST);

		if ($this->input->post('email') || $this->input->post('id')) {
			$option['id'] = $this->input->post("id");
			$option['email'] = $this->input->post("email");
			if($this->input->post("password") != null) $option['password'] = $this->input->post("password");
			$option['from'] = "admin";
			$this->users_model->updateUser($option);
			redirect('/admin/students', 'refresh');
		}
		else return false;
		
	}

	

	

	public function faculty(){
    	//add group users function + single user
    	
    	
    	$data['page'] = "admin/add_faculty";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['faculty'] = $this->users_model->getFaculty();
    	$this->load->view("index",$data);

    }

    public function addFaculty(){
		$options['name'] = $this->input->post('name');
		
		if ($this->users_model->addFaculty($options)){
		}
		else echo "0";
	}

	public function deleteFaculty() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;

		$this->users_model->deleteFaculty($options);
	}

	public function updateFaculty(){
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
			$options['name'] = $this->input->post('name');
			$id = $this->input->post('id');
			//Var_dump($options);
			if ($this->users_model->updateFaculty($options)) {
				$this->faculty();
			}

		}
	}

	public function searchFaculty() {
		if($this->input->post('name')) {
			$options['name'] = $this->input->post('name');
		}
		else return false;
		$data['page'] = "admin/add_faculty";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['faculty'] = $this->users_model->searchFaculty($options);
    	$this->load->view("index",$data);

		
	}

    public function course(){
    	//add group users function + single user
    	
    	
    	$data['page'] = "admin/add_course";
    	$data['faculty'] = $this->db->get("faculty")->result();
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['courses'] = $this->users_model->getCourses();

    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)
    }

    public function addCourse(){
    	$options['id'] = $this->input->post('id');
		$options['faculty_id'] = $this->input->post('faculty_id');
		$options['name'] = $this->input->post('name');
		if ($this->users_model->addCourse($options)){
		}
		else echo "0";
	}

	public function deleteCourse() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;

		$this->users_model->deleteCourse($options);
	}

	public function updateCourse(){
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
			$options['faculty_id'] = $this->input->post('faculty_id');
			$options['name'] = $this->input->post('name');
			$id = $this->input->post('id');
			//Var_dump($options);
			if ($this->users_model->updateCourses($options)) {
				$this->course();
			}

		}
	}

	public function searchCourse() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;
		$data['page'] = "admin/add_course";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['courses'] = $this->users_model->searchCourse($options);
    	$this->load->view("index",$data);

		
	}

    public function subject(){
    	//add group users function + single user
    	
    	
    	$data['page'] = "admin/add_subject";
    	$data['faculty'] = $this->users_model->getFaculty();
    	$data['courses'] = $this->users_model->getCourses();
    	$data['subjects'] = $this->users_model->getSubject();
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)
    }

    public function addSubject(){
    	$options['course_id'] = $this->input->post('course_id');
		$options['name'] = $this->input->post('name');
		$options['status'] = $this->input->post('available');
		if ($this->users_model->addSubject($options)){
		}
		else echo "0";
	}

	public function deleteSubject() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;

		$this->users_model->deleteSubject($options);
	}

	public function updateSubject(){
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
			$options['course_id'] = $this->input->post('cid');
			$options['name'] = $this->input->post('name');
			$options['status'] = $this->input->post('state');
			$id = $this->input->post('id');
			//Var_dump($options);
			if ($this->users_model->updateSubject($options)) {
				$this->subject();
			}

		}
	}

	public function searchSubject() {
		if($this->input->post('name')) {
			$options['name'] = $this->input->post('name');
		}
		else return false;
		$data['page'] = "admin/add_subject";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['faculty'] = $this->users_model->getFaculty();
    	$data['courses'] = $this->users_model->getCourses();
    	$data['subjects'] = $this->users_model->searchSubject($options);
    	$this->load->view("index",$data);

		
	}

    public function batch(){
    	$data['page'] = "admin/add_batch";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['batches'] = $this->users_model->getBatches();
    	$this->load->view("index",$data);
    }

    
	public function addBatch(){
    	$options['id'] = $this->input->post('id');
		$options['start_date'] = $this->input->post('start_date');
		$options['end_date'] = $this->input->post('end_date');
		$options['name'] = $this->input->post('name');
		if ($this->users_model->addBatch($options)){
		}
		else echo "0";
	}

	public function deleteBatch() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;

		$this->users_model->deleteBatch($options);
	}

	public function updateBatch(){
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
			$options['start_date'] = $this->input->post('start');
			$options['end_date'] = $this->input->post('end');
			$options['name'] = $this->input->post('name');
			$id = $this->input->post('id');
			//Var_dump($options);
			if ($this->users_model->updateBatch($options)) {
				$this->batch();
			}

		}
	}

	 public function searchBatch(){
	 	$options['name'] = $this->input->post('name');
    	$data['page'] = "admin/add_batch";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['batches'] = $this->users_model->searchBatch($options);
    	$this->load->view("index",$data);
    }

	public function notice(){
    	$data['page'] = "admin/add_notice";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['notices'] = $this->users_model->getNotices();
    	$this->load->view("index",$data);
    }

    public function addNotice(){
		$options['title'] = $this->input->post('title');
		$options['content'] = $this->input->post('content');

		if ($this->users_model->addNotice($options)){
		}
		else echo "0";
	}

	public function deleteNotice() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;
		$this->users_model->deleteNotice($options);
		redirect('/admin/notice/', 'refresh');
	}

	public function viewNotice(){
		error_reporting(0);
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		}
			$data['page'] = "admin/view_notice";
			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();
			$q = $this->db->get_where("notices", array("id"=> $id))->row(0);
		
			$data['id'] = $q->id;
			$data['timestamp'] = $q->timeStamp;
			$data['title'] = $q->title;
			$data['content'] = $q->content;
			$this->load->view("index", $data);
	}

	public function editNotice(){
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
			$options['title'] = $this->input->post('title');
			$options['content'] = $this->input->post('content');
			$id = $this->input->post('id');
			if ($this->users_model->editNotice($options)) {
				$this->viewNotice($id);
			}

		}
	}

	public function searchNotice(){
		$options['title'] = $this->input->post('title');
    	$data['page'] = "admin/add_notice";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['notices'] = $this->users_model->searchNotice($options);
    	$this->load->view("index",$data);
    }

    public function updateWeekData(){
    	$options['id'] = $this->input->post('id');
    	$options['description'] = $this->input->post('description');
    	$this->users_model->updateWeekData($options);
    }

    public function Support(){
    	$data['page'] = "help";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);
    }

    public function help(){
    	$data['page'] = "admin/add_help";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['help'] = $this->users_model->getHelp();
    	$this->load->view("index",$data);
    }

    public function addHelp(){
    	$options['email'] = $this->input->post('email');
		$options['title'] = $this->input->post('subject');
		$options['message'] = $this->input->post('message');

		if ($this->users_model->addHelp($options)){
			redirect('/admin/help/', 'refresh');
		}
		else echo "0";
	}

	public function deleteHelp() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;
		$this->users_model->deleteHelp($options);
		redirect('/admin/support/', 'refresh');
	}

	public function viewHelp(){
		error_reporting(0);
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		}
			$data['page'] = "admin/view_help";
			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();
			$q = $this->db->get_where("help", array("id"=> $id))->row(0);
		
			$data['email'] = $q->email;
			$data['timestamp'] = $q->timeStamp;
			$data['title'] = $q->title;
			$data['message'] = $q->message;
			$this->load->view("index", $data);
	}


	public function searchHelp(){
		$options['title'] = $this->input->post('title');
    	$data['page'] = "admin/add_help";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['help'] = $this->users_model->searchHelp($options);
    	$this->load->view("index",$data);
    }


    //SIMPLE MESSAGING

    public function message() {
    	$this->messageInbox();
    }

    public function sendMessage() {
    	$data['page'] = "send_message";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);
    }

    public function messageInbox(){
    	$data['page'] = "admin/inbox";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$type = "inbox";
    	$data['messages'] = $this->users_model->getMessage($type);
    	$this->load->view("index",$data);
    }

    public function messageSent(){
    	$data['page'] = "admin/outbox";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$type = "sent";
    	$data['messages'] = $this->users_model->getMessage($type);
    	$this->load->view("index",$data);
    }


    public function addMessage(){
    	$options['from'] = $this->session->userdata('email');
    	$options['to'] = $this->input->post('email');
		$options['subject'] = $this->input->post('subject');

		$options['message'] = $this->input->post('message');

		if ($this->users_model->addMessage($options)){
			redirect('/admin/messageSent/', 'refresh');
		}
		else echo "0";
	}

	public function deleteMessage() {
		if($this->input->post('id')) {
			$options['id'] = $this->input->post('id');
		}
		else return false;
		$this->users_model->deleteMessage($options);
		redirect('/admin/messageInbox/', 'refresh');
	}

	public function viewMessage(){
		error_reporting(0);
		if ($this->input->post('id'))
		{
			$id = $this->input->post('id');
		}
			$data['page'] = "view_message";
			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();
			$q = $this->db->get_where("message", array("id"=> $id))->row(0);
		
			$data['from'] = $q->from;
			$data['to'] = $q->to;
			$data['timestamp'] = $q->timeStamp;
			$data['subject'] = $q->subject;
			$data['message'] = $q->message;
			$this->load->view("index", $data);
	}


	public function searchMessageInbox(){
		$options['title'] = $this->input->post('title');
    	$data['page'] = "admin/add_help";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['messages'] = $this->users_model->searchMessageFrom($options);
    	$this->load->view("index",$data);
    }

    public function searchMessageSent(){
		$options['title'] = $this->input->post('title');
    	$data['page'] = "admin/add_help";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$data['messages'] = $this->users_model->searchMessageTo($options);
    	$this->load->view("index",$data);
    }

    //Exams
    public function exam() {
    	$data['page'] = "exam";
    	$data['status'] = "";
    	$data['nav'] = "Exam";
    	$data['help'] = $this->users_model->getHelp();
    	$this->load->view("index",$data);
    }

	//Viewing and Editing Profiles////
	public function searchUser() {
		if ($this->input->post('email'))
		{
			$options['email'] = $this->input->post('email');
			$options['priv'] = $this->input->post('priv');
		}
		$data['page'] = "admin/add_users";

    	$data['users'] = $this->users_model->searchUser($options);
    	//var_dump($data['users']);
    	$data['faculty'] = $this->users_model->getFaculty();
    	$data['courses'] = $this->users_model->getCourses();
    	$data['batch'] = $this->users_model->getBatches();
    	
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();
    	$this->load->view("index",$data);
	}

	
	//created to avoid errors, using same function to get post data as well as pass parameters.
	//Missing argument error whenever variable posted from form.
	public function userProfile2(){
		if ($this->input->post('id'))
		{
			$user_id = $this->input->post('id');
			$priv = $this->input->post('priv');
		}
		$this->userProfile($user_id, $priv);
	}


	public function userProfile($user_id, $priv){
			$data['page'] = "admin/user_profile";
			$data['status'] = "";
			$data['nav'] = $this->_genNavigation();

			if ($priv == 8 || $priv == 9) {
				$this->db->order_by("batch_id", "desc");
				$q = $this->db->get_where("student_subject", array("student_id"=> $user_id))->row(0);
				$subject_id = $q->subject_id;
				$batch_id = $q->batch_id;
				//QUERY FOR COURSE ID
				$q = $this->db->get_where("subjects", array("id"=>$subject_id))->row(0);
				$data['course'] = $q->course_id;
				//QUERY FOR LATEST BATCH SUBJECTS
				$data['subjects'] = $this->db->get_where("student_subject", array("batch_id"=>$batch_id , "student_id"=>$user_id))->result();
				$data['subject_name'] = $this->db->get("subjects")->result();
			}
			else if ($priv == 2 || $priv == 5 || $priv == 1) {
				$data['course'] = "Subjects List:";
				$data['subjects'] = $this->db->get_where("subject_lecturer", array("lecturer_id"=>$user_id))->result();
				$data['subject_name'] = $this->db->get("subjects")->result();		
			}
			$data['priv'] = $priv;
			$data['users'] = $this->db->get_where("personal_details", array("user_id"=>$user_id ))->result();
			$this->load->view("index", $data);
	}

	public function editProfile(){
		if($this->input->post('id')) {
			$options['user_id'] = $this->input->post('id');
			$options['title'] = $this->input->post('title');
			$options['first_name'] = $this->input->post('first_name');
			$options['family_name'] = $this->input->post('family_name');
			$options['dob'] = $this->input->post('dob');
			$options['add1'] = $this->input->post('add1');
			$options['add2'] = $this->input->post('add2');
			$options['add3'] = $this->input->post('add3');
			$options['add4'] = $this->input->post('add4');
			$options['phone'] = $this->input->post('phone');
			$options['mobile'] = $this->input->post('mobile');
			$options['nationality'] = $this->input->post('nationality');
			$options['birth_country'] = $this->input->post('birth_country');
			$options['pps_no'] = $this->input->post('pps_no');
			$user_id = $this->input->post('id');
			$priv = $this->input->post('priv');
			//Var_dump($options);
			if ($this->users_model->editProfile($options)) {
				$this->userProfile($user_id, $priv);
			}

		}


	}

	 
}