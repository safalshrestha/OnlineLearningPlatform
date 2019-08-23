<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

	public function index()
	{
		$data['user'] = $this->session->userdata("email");
		$this->load->view('welcome_message', $data);
	}
	
	public function login()
	{
		//$this->load->view('welcome_message');
		$this->input->post('email');
		$this->input->post('password');
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','email','trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password','password','trim|required|xss_clean|min_length[6]');
		
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
				$this->session->set_userdata('privilege', $row->privilege);
				$this->welcome();

			}else{
				$data['page'] = "login_form";
				$data['status'] = "Login Mismatch";
				$this->load->view('index', $data);
			}
		}
		else {
			$data['page'] = "login_form";
			$data['status'] = "Invalid data";
			$this->load->view('index', $data);
		}
	}
	
	public function login_form()
	{
		$data["page"] = "login_form";
		$data['status'] = "";
		$this->load->view('index',$data);
	}


	public function logout(){
		$this->session->unset_userdata("email");
		$this->session->unset_userdata("privilege");
	}
	public function forgotpassword_form(){
		$data['page'] = 'forgotpassword';
		$data['status'] = '';
        $this->load->view('index', $data);
    }
    public function retrievepassword(){
        $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email');

        if($this->form_validation->run()){
            $options['email'] = trim($this->input->post('email'));
            $query = $this->users_model->GetUsers($options);
            if(count($query) > 0){
                $uniqueId = $this->users_model->generatePassword();

                $data['email'] = $this->input->post('email');
                $data['password'] = $uniqueId;
                $this->users_model->UpdateUser($data);

                $query2 = $this->db->get_where("newsletters", array('id'=>11))->row(0);

                $provider = $this->db->get('providers')->row(0);
                $options['from'] = $provider->email;
                $options['name'] = $provider->name;
                $options['to'] = $this->input->post('email');
                $options['subject'] = $query2->subject;
                $options['message'] = str_replace(array('[USERNAME]', '[SITEURL]', '[PASSWORD]'),
                    array($this->session->userdata('userId'), 'http:'.site_url(), $uniqueId ), $query2->body);
                $this->users_model->sendMail($options);

                $data['page'] = 'forgotpassword';
                $data['status'] = 'New password sent to your mailbox.';
                
                $this->load->view('index', $data);
            }else{

                $data['page'] = 'forgotpassword';
                //$data['pagetitle'] = 'Instant World';
                //$data['status'] = 'Password Retrieve';
                $data['status'] = 'Please try again..';
                //$this->_setTracker("Password retrieval error.");
                $this->load->view('index', $data);
            }
        }else $this->forgotpassword_form();
    }
    

    //navigation menu based on user privilege
    public function _genNavigation(){
    	
    	$navs = $this->db->get_where("nav", array("privilege"=>$this->users_model->getPrivilege()))->result();
    	return $navs;
    }
    public function users(){
    	//add group users function + single user
    	$data['page'] = "admin/add_users";
    	$data['status'] = "";
    	$data['nav'] = $this->_genNavigation();


    	$data['faculty'] = $this->db->get("faculty")->result();
    	$data['courses'] = $this->db->get("courses")->result();
    	$data['batch'] = $this->db->get("batch")->result();

    	$this->load->view("index",$data);


    	//list recently added users

    	//list blocked users (fee not paid)


    }
	public function welcome(){
		$data['page'] = "welcome";
		$data['status'] = "<p class='text-info'> Login success </p>";
		$data['nav'] = $this->_genNavigation();
		$data['priv'] = $this->users_model->getPrivilege();

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
			case 9:
				//students
				$this->users_model->sessionGuard();
				break;
			case 8:
				//TODO: parents
				$this->users_model->sessionGuard();

				break;
			default:
				echo "Nothing here";
				die();
				break;
		}

		
		$this->load->view('index', $data);	//passing variable to view
	}
	
	public function addStudents(){
		$options['email'] = $this->input->post('email');
		$options['privilege'] = $this->input->post('privilege');
		
		var_dump($options['privilege']);
		var_dump($options['email']);

		$this->input->post('course_id');
		

		$data['student_id'] = $this->register($options);

		if(!$data['student_id'] || $data['student_id'] != ""){
			//assign subjects to student
			$subjects= $this->db->get_where("subjects", array("course_id"=>$this->input->post('course_id')))->result();
			$data['batch_id'] = $this->input->post('batch_id');
			foreach($subjects as $subject){
				$data['subject_id'] = $subject->id;
				$this->db->insert("student_subject", $data);
			}
		}else echo "0"; //false

	}
	public function deleteStudents() {
		if($this->input->post('id')) {
			$option['id'] = $this->input->get('id');
		}
		else if($this->input->get('email')) {
			$options['email'] = $this->input->get('email');
		}
		else return false;

		$this->users_model->deleteStudents($options);
	}


	//single user register
	public function register($options = array()){
		if(!$options['email']) return false;
		if(!$options['privilege']) return false;
		
		$options['id'] = $this->users_model->getUniqueUserId();
        $options['password'] = md5($this->users_model->generatePassword());
           
		if($this->users_model->AddUser($options)) return $options['id'];
		//insert into subject_student table
	}

}
