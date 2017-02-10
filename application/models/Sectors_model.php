<?php
class Sectors_model extends MY_Model {
	
	function get_all()
	{
		$this->db->order_by("name", "asc");
		$query = $this->db->get_where('sectors');	

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name;
		} 
		
		return $sectors_array;
	}
		function get_all_target()
	{
		$this->db->where('target', 't'); 
        $this->db->where('sector_group',null, false);
		$this->db->order_by("name", "asc");
		$query = $this->db->get_where('sectors');	
		foreach($query->result() as $row)
		{
		  $target_sectors_array[$row->id] = $row->name;
		} 
		
		return $target_sectors_array;
	}	
    function get_bespoke_target()
	{
		$this->db->where('target', 'f'); 
        $this->db->where('sector_group',1);
		$this->db->order_by("name", "asc");
		$query = $this->db->get_where('sectors');	
		foreach($query->result() as $row)
		{
		  $target_sectors_array[$row->id] = $row->name;
            //$target_sectors_array[$row->created_at] = $row->created_at;
		} 
		
		return $target_sectors_array;
	}
    
	function get_all_not_target()
	{
		$this->db->where('target', 'f'); 
        $this->db->where('sector_group',null, false);
		$this->db->order_by("name", "asc");
		$query = $this->db->get_where('sectors');

		foreach($query->result() as $row)
		{
		  $not_target_sectors_array[$row->id] = $row->name;
		} 
		
		return $not_target_sectors_array;
	}
    
    function bespokeSelected($id){
            $sql = "SELECT o.* ,s.name
            FROM operates o
            LEFT JOIN sectors s
            ON o.sector_id = s.id
            WHERE o.company_id=".$id." 
            AND s.sector_group is not null
            AND o.active=true";


             $query = $this->db->query($sql);
                if($query){
                    return $query->result_array();
                }else{
                    return [];
                }
 
    }
    
	function get_all_for_search()
	{
		$sql ="
		SELECT s.id,s.name,count(O.id)
		FROM sectors s
		LEFT JOIN operates O on s.id = O.sector_id
		WHERE s.display = 't' and o.active = 't'
		GROUP BY s.id
		ORDER BY count desc,s.name desc";
		
		$query = $this->db->query($sql);

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name;//.' ('.number_format($row->count).')';
		    $sectors_array_all = $query->row_array(); 
		} 
		return $sectors_array;
				return $sectors_array_all;

	}

		function get_all_target_in_array()
	{
		$this->db->select('id, name');
		$this->db->where('display', 'true');
		$query = $this->db->get_where('sectors');

		foreach($query->result() as $row)
		{
		  $sectors_target_array[$row->id] = ucwords(strtolower($row->name));
		} 	
		return $sectors_target_array;
	}

	
	function get_by_id($id)
	{
		$query = $this->db->get_where('sectors',array('id'=>$id));
		return $query->result();
	}

	function get_by_name($name)
	{
		$query = $this->db->get_where('sectors',array('name'=>$name));
		return $query->result();
	}

	function insert_sector($name,$display)
	{
        $this->name   = $name; // please read the below note
        $this->display = $display;
        $this->db->insert('sectors', $this);
    }
}