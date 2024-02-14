<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
//======================Start================================//
	public function index(){
		$this->load->view('welcome');
	}


public function getlist(){
	$dt['user']= $this->User_Model->getlist();
				
	$this->load->view('list',$dt);		
}

public function store(){
	if($_SERVER['REQUEST_METHOD']=="POST"){

		if($this->User_Model->store()){
			$info= array('status'=> 'success',
						'message'=> 'Insert Successfully',
						'class' => 'alert alert-success fade in'

						);

		}else{
			$info= array('status'=> 'error',
			'message'=> 'Insert Not Successfully',
			'class' => 'alert alert-danger fade in'
			);
		}
		$this->session->set_flashdata('item', $info);
		redirect('Welcome');
		//echo json_encode($info);

	}
}

public function edit(){

	$dt['id']= $this->input->get('id');
    
	//print_r($dt['id']);die();
	$dt['user']= $this->User_Model->GetAlist($dt['id']);
				
	$this->load->view('edit',$dt);		
}

public function update(){
	if($_SERVER['REQUEST_METHOD']=="POST"){

		if($this->User_Model->update()){
			$info= array('status'=> 'success',
						'message'=> 'Update Successfully',
						'class' => 'alert alert-success fade in'

						);

		}else{
			$info= array('status'=> 'error',
			'message'=> 'Update Not Successfully',
			'class' => 'alert alert-danger fade in'
			);
		}
		$this->session->set_flashdata('item', $info);
		redirect('Welcome/edit');
		//echo json_encode($info);

	}
}


public function delete(){
	if($_SERVER['REQUEST_METHOD']=="GET"){

		$dt['id']= $this->input->get('id');

		if($this->User_Model->delete($dt['id'])){
			$info= array('status'=> 'success',
						'message'=> 'Delete Successfully',
						'class' => 'alert alert-success fade in'
						);
		}else{

			$info= array('status'=> 'error',
						'message'=> 'Delete Not Successfully',
						'class' => 'alert alert-danger fade in'
						);

		}
		$this->session->set_flashdata('item', $info);
         redirect('Welcome/getlist');
	}
}


	

//======================End================================//

}
