<?php
class Campaigns_model extends MY_Model {
	

	// GETS
	function get_all_shared_searches()
	{
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where('status', 'search');
		$this->db->order_by("c.name", "DESC");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_searches($user_id)
	{
		$this->db->select('name,id,user_id');
		$this->db->from('campaigns');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->where('shared', 'False');
		$this->db->where('status', 'search');
		$this->db->where("(eff_to IS NULL OR eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->order_by("name", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_shared_campaigns()
	{
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where('status', 'search');
		$this->db->order_by("c.name", "DESC");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_campaings($user_id)
	{
		$this->db->select('name,id,user_id');
		$this->db->from('campaigns');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->where('shared', 'False');
		$this->db->where('status', 'search');
		$this->db->where("(eff_to IS NULL OR eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->order_by("name", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}


	function get_campaigns_for_user($user_id)
	{
		$this->db->select('name,id,user_id');
		$this->db->from('campaigns');
		// Apply this to find campaigns
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->order_by("name", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_campaign_by_id($id)
	{
		$this->db->select('name,id,criteria,shared,user_id,shared');
		$this->db->from('campaigns');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	// UPDATES

	function update_campaign_make_public($id,$user_id)
	{
		$this->db->where('id', $id);
		$this->db->update('campaigns', array('shared'=>'True','updated_by'=>$user_id));
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	function update_campaign_make_private($id,$user_id)
	{
		$data = array(
			'shared' => 'False',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);

		$this->db->where('id', $id);
		$this->db->update('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	// INSERTS
	function save_search($name,$shared,$user_id,$post) 
	{	
		$data['name'] = $name;	
		$data['user_id'] = $user_id;
		$data['campaign_user_id'] = $user_id;
		$data['criteria'] =  serialize($post);
		$data['shared'] = $shared;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['eff_from'] = date('Y-m-d');
		$data['created_by'] = $user_id;

		$this->db->insert('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$compaign_id = $this->db->insert_id();
			return $compaign_id;
		}
	}

	function add_company_to_campaign($new_campaign_id,$company_id,$user_id)
	{
		$data['campaign_id'] = $new_campaign_id;
		$data['company_id'] = $company_id;
		$data['created_by'] = $user_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('targets',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$target_id = $this->db->insert_id();
			return $target_id;
		}
	}

	function create_campaign($name,$shared,$user_id) 
	{	
		$data['name'] = $name;	
		$data['user_id'] = $user_id;
		$data['campaign_user_id'] = $user_id;
		$data['shared'] = $shared;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['eff_from'] = date('Y-m-d');
		$data['created_by'] = $user_id;

		$this->db->insert('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$compaign_id = $this->db->insert_id();
			return $compaign_id;
		}
	}


	// DELETES
	function delete_campaign($id,$user_id)
	{
		$data = array(
			'eff_to' => date('Y-m-d'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);
		$this->db->where('id',$id);
		$this->db->update('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

}