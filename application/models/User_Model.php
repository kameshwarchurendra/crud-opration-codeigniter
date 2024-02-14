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
  
//================================/File Upload==================//

//======================/End================================//

}
