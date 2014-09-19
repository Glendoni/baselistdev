<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends MY_Controller {

	public function create(){
		// print_r('<pre>');print_r($this->input->post());print_r('</pre>');
		if($this->input->post('company_id'))
		{	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean');
			$this->form_validation->set_rules('comment', 'comment', 'xss_clean');
			$this->form_validation->set_rules('planned_at', 'planned_at', 'xss_clean');
			$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
			$this->form_validation->set_rules('window', 'window', 'xss_clean');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');
		

			if($this->form_validation->run())
			{	
				$result = $this->Actions_model->create($this->input->post());
				
				if(empty($result))
				{
					$this->set_message_warning('Error');
					die('Error in form');
				}
				else
				{
					redirect('companies/company?id='.$this->input->post('company_id'),'location');
				}
			}
			die('invalid form');
		}
	} 
}