<?php

class Upload extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    function index()
    {
        //$this->load->view('/profile/upload_form', array('error' => ' ' ));
        echo "Index";
    }
    
   
    function do_upload()
    {
        $config['upload_path'] = 'uploads/'.$this->input->post('id').'/profile/';
        if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
        $config['allowed_types'] = 'jpg|jpeg';
        $config['max_size'] = '3000';
        //$config['max_width']  = '2000';
        //$config['max_height']  = '2000';
        $config['overwrite']  = TRUE;
        $config['file_name'] = "profile.jpg";
        
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload())
        {
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
            echo $this->upload->display_errors();
        }
        else
        {
            
            //$data = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
            $path = 'uploads/'.$this->input->post('id').'/profile/';
            //$config['source_image'] = $path.$this->session->userdata['userId'].'.jpg';
            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }
            $config2['source_image'] = "uploads/".$this->input->post('id')."/profile/profile.jpg";
            $config2['image_library'] = 'gd2';
            $config2['maintain_ratio'] = TRUE;
            $config2['width'] = '256';
            $config2['height'] = '256';
            $config2['create_thumb'] = TRUE;
            $config2['overwrite']  = TRUE;
            //$config2['rotation_angle'] = 90;  if potrait photo uploaded
            
            
            $this->load->library('image_lib', $config2);
            $this->image_lib->initialize($config2);
             
            if($this->image_lib->resize()) echo "Resized";
            //$this->image_lib->rotate();
            $this->image_lib->clear();
            $id = $this->input->post('id');
            $priv = $this->input->post('priv');
            $this->users_model->changeProfilePic($id);
            redirect("admin/userProfile2/".$id."/".$priv);
        }
    }
    
}
?>