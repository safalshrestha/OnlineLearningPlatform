<?php

class users_model extends CI_Model {
	/** Utility methods **/
    function _required($required,$data){
        foreach($required as $field)
            if(!isset($data[$field])) return false;
        
        return true;
    }
    
    function _default($defaults, $options){
        return array_merge($defaults,$options);
        
    }

	function getPrivilege(){
		if ($this->session->userdata("email")) {
			$user = $this->db->get_where("users", array("email"=>$this->session->userdata("email")) )->row(0);
			return $user->privilege;
		}
		else return 0;
		
	}

	//single user only
	function setPrivilege($user = array()){
		//ex: array('email'=>"email address", 'privilege'=> 1)
		$this->db->set('privilege', $user['privilege']);
		$this->db->where("email", $user['email']);
		$this->db->update("users");
	}


	function adminGuard(){
		$this->sessionGuard();
		if($this->getPrivilege() != 1) die("Restricted for admin use only.");
	}
	function facultyGuard(){
		$this->sessionGuard();
		if($this->getPrivilege() != 2) die("Restricted for faculty head only.");
	}
	function lecturerGuard(){
		$this->sessionGuard();
		if($this->getPrivilege() != 3) die("Restricted for lecturers only.");
	}

	function sessionGuard(){
		if(!$this->session->userdata('email')) die("Session required");

	}


	function getUsers($options = array()){
		//var_dump($options);
		if(isset($options['id'])) { $this->db->where("id", $options['id']); }
		if(isset($options['email'])) { $this->db->where("email", $options['email']); }
		if(isset($options['password'])) { $this->db->where("password", md5($options['password'])); }

		$users = $this->db->get("users");
		if($users->num_rows() < 1) return 0; //user does not exist
		else if($users->num_rows() == 1){
			return $users->row(0); //single user exists
		}else return $users->result(); //multi user exists, throwing everything back
	}

	
	function UpdateUser($options = array()){
		 
		//change email and password from admin
		if (isset($options['from'])) {
			if(isset($options['email'])) 
            	$this->db->set('email', $options['email']);
            if(isset($options['id']))
            	$this->db->where('id', $options['id']);
        	if(isset($options['password']))
            	$this->db->set('password', md5($options['password']) );

		}
		else {
			//when username and password given, change password
			if(isset($options['email']))
            $this->db->where('email', $options['email']);
      	  	if(isset($options['id']))
            $this->db->where('id', $options['id']);
        	 if(isset($options['password']))
            $this->db->set('password', md5($options['password']) );
		}
                        
        $this->db->update('users');
        return $this->db->affected_rows();

    }

    //change password function for users
    function changePassword($options = array()){
    	if(!$this->_required(
            array('id','password'),
            $options
            )
        ) {
    		return false;
    		die();
    	}
        else {
	        $this->db->where('id', $options['id']);
	        $this->db->set('password', md5($options['password']) );
	                        
	        $this->db->update('users');
	        return $this->db->affected_rows();	//send affected rows, 0 = false
    	}

    }

    function getUniqueUserId($length = 7)
    {
        // start with a blank password
        $uniqueId = "";
        
        $possible = "abcdefghijklmnopqrstuvwxyz012346789ABCDFGHJKLMNPQRTVWXYZ";
        $maxlength = strlen($possible);
        
        if ($length > $maxlength) {
          $length = $maxlength;
        }
        $i = 0; 
        
        while ($i < $length) { 
          $char = substr($possible, mt_rand(0, $maxlength-1), 1);
          if (!strstr($uniqueId, $char)) { 
            $uniqueId .= $char;
            $i++;
          }
        }
        
        $match = $this->getUsers(array('id' => $uniqueId));
        if($match) getUniqueUserId();
        else return $uniqueId;
    }

	function generatePassword($length = 12)
	  {

	    // start with a blank password
	    $password = "";

	    // define possible characters - any character in this string can be
	    // picked for use in the password, so if you want to put vowels back in
	    // or add special characters such as exclamation marks, this is where
	    // you should do it
	    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

	    // we refer to the length of $possible a few times, so let's grab it now
	    $maxlength = strlen($possible);
	  
	    // check for length overflow and truncate if necessary
	    if ($length > $maxlength) {
	      $length = $maxlength;
	    }
	    
	    // set up a counter for how many characters are in the password so far
	    $i = 0; 
	    
	    // add random characters to $password until $length is reached
	    while ($i < $length) { 

	      // pick a random character from the possible ones
	      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
	        
	      // have we already used this character in $password?
	      if (!strstr($password, $char)) { 
	        // no, so it's OK to add it onto the end of whatever we've already got...
	        $password .= $char;
	        // ... and increase the counter by one
	        $i++;
	      }

	    }

	    // done!
	    return $password;

	  }

	function sendMail($options = array()){
        if($this->settings(array('sendMails' => 1))){
            $this->load->library('email');
            
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $this->email->initialize($config);
            
            /*
              $options['from'] = '';
              $options['name'] = '';
              $options['to'] = '';
              $options['subject'] = '';
              $options['message'] = '';
            */
                        
            $this->email->from($options['from'], $options['name']);
            $this->email->to($options['to']);
            $this->email->subject($options['subject']);
            $this->email->message($options['message']);
            
            $this->email->send();
        }
    }

    //---------------Check Existing-------------------------
    function EmailExist($options = array()){
        $this->db->where('email', $options['email']);
        $query = $this->db->get('users');
        
        if($query->num_rows() > 0) return true;
        
        return false;
    }

    function facultyExist($options = array()){
        $this->db->where('name', $options['name']);
        $query = $this->db->get('faculty');
        
        if($query->num_rows() > 0) return true;
        
        return false;
    }

    function courseExist($options = array()){
        $this->db->where('id', $options['id']);
        $query = $this->db->get('courses');
        
        if($query->num_rows() > 0) return true;
        
        return false;
    }

    function subjectExist($options = array()){
        $this->db->where('name', $options['name']);
        $this->db->where('course_id', $options['course_id']);

        $query = $this->db->get('subjects');
        
        if($query->num_rows() > 0) return true;
        
        return false;
    }


    function batchExist($options = array()){
        $this->db->where('id', $options['id']);
        $this->db->where('start_date', $options['start_date']);
        $this->db->where('end_date', $options['end_date']);
        $this->db->where('name',$options['name']);
        $query = $this->db->get('batch');
        
        if($query->num_rows() > 0) return true;
        
        return false;
    }

    //------------------END OF EXISTS CHECKING---------//
    function AddUser($options = array()){
        //var_dump($options);
        if(!$this->_required(
            array('email'),
            $options
            )
        ) return false;
        
        if($this->EmailExist($options)) { return false; }
        else{
            
            
            $this->db->insert('users',$options);
            $this->db->insert('personal_details', array("user_id"=>$options['id']) );
            
            
            //send email
            /*
            $this->db->where('email', $options['email']);
            $query = $this->db->get('users');
            $this->sendVerificationEmail($query->row(0));
            */
            return true;
        }
        
    }

    function searchUser($options = array()) {
    	//tried where but it would create 3 or stateent thus used having

    	$this->db->having("privilege", $options['priv']);		
  		$this->db->like("reg_no",$options['email']);
   		$this->db->or_like("email", $options['email']);
   		return $this->db->get("users")->result();
   	}

    

   	function deleteStudents($options = array()) {
   		$userId = "";
   		if(isset($options['id'])) { $userId = $options['id']; }

   		if (isset($options['email'])) {
   			$user = $this->db->get_where("users", array("email"=>$options['email']))->row(0);
   			$userId = $user->id;
		}
   		
   		//delete user from 'users' table
   		$this->db->where("id", $userId);
   		$this->db->delete("users");
   		//delete users from 'relation' tables
   		$this->db->where("student_id", $userId);
   		$this->db->delete("student_subject");
   	}

   	function deleteLecturer($options = array()) {
   		$userId = "";
   		if(isset($options['id'])) { $userId = $options['id']; }

   		if (isset($options['email'])) {
   			$user = $this->db->get_where("users", array("email"=>$options['email']))->row(0);
   			$userId = $user->id;
		}
   		
   		//delete user from 'users' table
   		$this->db->where("id", $userId);
   		$this->db->delete("users");
   		//delete users from 'relation' tables
   		$this->db->where("lecturer_id", $userId);
   		$this->db->delete("subject_lecturer");
   	}

   	
   	function addFaculty($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('name'),
            $options
            )
        ) return false;
        
        if($this->facultyExist($options)) { return false; }
        else{
            
            
            $this->db->insert('faculty',$options);
           	return true;
        }
   	}

   	function getFaculty() {
   		return $this->db->get("faculty")->result();
   	}

   	function deleteFaculty($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("faculty");

   	}

   	function updateFaculty($options = array()){
		
		if (isset($options['id'])) {
			
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('faculty');
       	 	return true;
		}
    }

    function searchFaculty($options = array()) {
   		$this->db->like("name", $options['name']);
   		return $this->db->get("faculty")->result();
   	}


   	function addCourse ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('id','faculty_id','name'),
            $options
            )
        ) return false;
        
        if($this->courseExist($options)) { return false; }
        else{
            
            
            $this->db->insert('courses',$options);
            return true;
        }
   	}

   	function getCourses() {
   		return $this->db->get("courses")->result();
   	}

   	function deleteCourse($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("courses");

   	}

   	function updateCourses($options = array()){
		
		if (isset($options['id'])) {
			
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('courses');
       	 	return true;
		}
    }

    function searchCourse($options = array()) {
   		$this->db->like("id", $options['id']);
   		return $this->db->get("courses")->result();
   	}

   	function addSubject ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('course_id','name','status'),
            $options
            )
        ) return false;
        
        if($this->subjectExist($options)) { return false; }
        else{
            
            
            $this->db->insert('subjects',$options);
			$subject = $this->db->get_where("subjects", array("name"=>$option['name'],"course_id"=>$option['course_id']) )->row(0);
			$data['subject_id'] = $subject->id;
			for ($i=1; $i <= 12; $i++) {
				$data['week_id'] = $i;
				$this->db->insert('subject_weeks', $data );
			}
            return true;
        }
   	}

   	function getSubject() {
   		return $this->db->get("subjects")->result();
   	}

   	function deleteSubject($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("subjects");

   	}

   	function updateSubject($options = array()){
		
		if (isset($options['id'])) {
			
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('subjects');
       	 	return true;
		}
    }

    function searchSubject($options = array()) {
   		$this->db->like("name", $options['name']);
   		return $this->db->get("subjects")->result();
   	}


   	function addBatch ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('id','start_date','end_date', 'name'),
            $options
            )
        ) return false;
        
        if($this->batchExist($options)) { return false; }
        else{
            $this->db->insert('batch',$options);
            return true;
        }
   	}

   	function getBatches() {
   		return $this->db->get("batch")->result();
   	} 

   	function deleteBatch($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("batch");

   	}

   	function updateBatch($options = array()){
		
		if (isset($options['id'])) {
			
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('batch');
       	 	return true;
		}
    }

    function searchBatch($options = array()) {
    	$this->db->like("id", $options['name']);
   		$this->db->or_like("name", $options['name']);
   		return $this->db->get("batch")->result();
   	}

   	function addNotice ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('content', 'title'),
            $options
            )
        ) return false;
        else {    
	        $this->db->insert('notices',$options);
	        return true;
    	}
   	}

   	function getNotices() {
   		return $this->db->get("notices")->result();
   	}

   	function deleteNotice($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("notices");

   	}

   	function editNotice($options = array()){
		
		if (isset($options['id'])) {
			
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('notices');
       	 	return true;
		}
    }

    function searchNotice($options = array()) {
    	$this->db->like("title", $options['title']);
   		return $this->db->get("notices")->result();
   	}

   	function latestNotice($options = array()) {
   		$this->db->order_by("timeStamp", "desc");
   		return $this->db->get("notices",6)->result();
   	}

   	function addHelp ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('message', 'title', 'email'),
            $options
            )
        ) return false;
        else {    
	        $this->db->insert('help',$options);
	        return true;
    	}
   	}

   	function getHelp() {
   		$this->db->order_by('timestamp','desc');
   		return $this->db->get("help")->result();
   	}

   	function deleteHelp($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("help");

   	}

    function searchHelp($options = array()) {
    	$this->db->like("title", $options['title']);
    	$this->db->or_like("email", $options['title']);
   		return $this->db->get("help")->result();
   	}

   	function addMessage ($options = array()) {
   		//var_dump($options);
   		if(!$this->_required(
            array('message', 'to', 'from'),
            $options
            )
        ) return false;
        else {    
	        $this->db->insert('message',$options);
	        return true;
    	}
   	}

   	function getMessage($type) {
   		$email = $this->session->userdata('email');
   		if ($type == "inbox") {
   			$this->db->where('to', $email);
   		}
   		if ($type == "sent") {
   			$this->db->where('from', $email);
   		}
   		$this->db->order_by('timestamp','desc');
   		return $this->db->get("message")->result();
   	}

   	function deleteMessage($options = array()) {
   		$id = "";
   		if(isset($options['id'])) { $id = $options['id']; }
   		
   		$this->db->where("id", $id);
   		$this->db->delete("message");

   	}

    function searchMessageInbox($options = array()) {
    	$this->db->like("subject", $options['title']);
    	$this->db->or_like("from", $options['title']);
    	$this->db->having("to", $this->session->userdata['email']);
   		return $this->db->get("message")->result();
   	}

   	function searchMessageSent($options = array()) {
    	$this->db->like("subject", $options['title']);
    	$this->db->or_like("to", $options['title']);
    	$this->db->having("from", $this->session->userdata['email']);
   		return $this->db->get("message")->result();
   	}

   	function getWeeksData($subject_id) {
   		$this->db->where('subject_id', $subject_id);
   		return $this->db->get("subject_weeks")->result();
   	}

   	function updateWeekData($options = array()){
		
		if (isset($options['id'])) {
            $this->db->where('id', $options['id']);
            $this->db->set($options);
            $this->db->update('subject_weeks');
       	 	return true;
		}
    }

   	function editProfile($options = array()){
		
		if (isset($options['user_id'])) {
			
            $this->db->where('user_id', $options['user_id']);
            $this->db->set($options);
            $this->db->update('personal_details');
       	 	return true;
		}
    }

    function changeProfilePic($id) {
    	if (isset($id)) {
    		$this->db->where('user_id', $id);
    		$this->db->set('profilePic', 1);
    		$this->db->update('personal_details');
    	}
    	return true;
    }
}