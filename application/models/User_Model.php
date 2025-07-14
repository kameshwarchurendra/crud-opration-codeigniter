<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {
//======================Start================================//

public function getlist(){
     $this->db->select('*');
    return $this->db->get('member')->result();
    
}

public function GetAlist($id){
    $this->db->select('*');
    $this->db->where('id',$id);
   return $this->db->get('member')->result();
   
}

public function store(){
    $data= array('name'=> $this->input->post('name'),
                 'email'=> $this->input->post('email'),
                 'mobile'=> $this->input->post('mobile'),
                 'image'=> $this->upload_a_file('image', 'uploads/', 'gif|jpg|png|jpeg')
           );
    return $this->db->insert('member',$data);
    
}


public function update(){
    $data= array('name'=> $this->input->post('name'),
                 'email'=> $this->input->post('email'),
                 'mobile'=> $this->input->post('mobile'),
                 'image'=> $this->upload_a_file('image', 'uploads/', 'gif|jpg|png|jpeg')
           );
	    $this->db->where('id',$this->input->post('id'));
    return $this->db->update('member',$data);
    
}


public function delete($id){     
    $this->db->where('id',$id);
    return $this->db->delete('member');
    
}

//=================================File Upload=================//
public function upload_a_file($in_title, $file_location, $file_type='*', $out_title=''){
    if (!empty($file_location)){
      if (!file_exists($file_location)) mkdir($file_location, 0777, true);
    }
    /* NOTE here $out_title = previous file title   while updating only */
    if (!empty($in_title) && !empty($file_location))
    if(!empty($_FILES[$in_title]['name'])) {  
      $config['upload_path']   = $file_location;
      $config['allowed_types'] = $file_type;
      $config['remove_spaces'] = TRUE;
      $config['file_name']     = $_FILES[$in_title]['name'];
      //Load upload library and initialize configuration
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
  
      if($this->upload->do_upload($in_title)){
        $uploadData = $this->upload->data();
        if (!empty($out_title)) if(file_exists($config['upload_path'].$out_title))
          unlink($config['upload_path'].$out_title); /* Deleting previous File */
        $out_title = $uploadData['file_name'];
    } } return $out_title;
  }
  
public function upload_multiple_files($in_title, $file_location, $file_type='*', $existing_files = array()) {
    if (!empty($file_location)){
        if (!file_exists($file_location)) mkdir($file_location, 0777, true);
    }

    if (!empty($in_title) && !empty($file_location)) {
        $uploaded_files = array();

        // Load upload library and initialize configuration
        $this->load->library('upload');

        // Loop through all files
        $file_count = count($_FILES[$in_title]['name']);
        for ($i = 0; $i < $file_count; $i++) {
            if (!empty($_FILES[$in_title]['name'][$i])) {
                $_FILES['file']['name'] = $_FILES[$in_title]['name'][$i];
                $_FILES['file']['type'] = $_FILES[$in_title]['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES[$in_title]['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES[$in_title]['error'][$i];
                $_FILES['file']['size'] = $_FILES[$in_title]['size'][$i];

                $config['upload_path'] = $file_location;
                $config['allowed_types'] = $file_type;
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = $_FILES['file']['name'];
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    // Delete the existing file if it exists
                    if (!empty($existing_files) && in_array($uploadData['file_name'], $existing_files)) {
                        unlink($config['upload_path'] . $uploadData['file_name']);
                    }
                    $uploaded_files[] = $uploadData['file_name'];
                } else {
                    // Handle upload error if needed
                    $error = $this->upload->display_errors();
                    // You can log or display the error message as needed
                    echo "Error uploading file: " . $error;
                }
            }
        }
        return $uploaded_files;
    }
}


//================================/File Upload==================//

//======================/End================================//

}
