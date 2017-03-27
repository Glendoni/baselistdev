<?php
class Tagging_model extends MY_Model {
    
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
         $this->load->helper('date');
        $this->load->helper('string');
	}


function get_tagging_stats()
{

$sql = "select 
       U.name \"person\", 
       U.image,
       count(CASE when CT.created_at >= current_date - 7 then 1 END) \"7days\",
     count(CASE when CT.created_at >= current_date - 30 then 1 END) \"30days\",
     count(CASE when CT.created_at >= current_date - 100 then 1 END) \"days\",
     min(current_date - CT.created_at::date) \"lasttag\"
 
from COMPANY_TAGS CT

JOIN USERS U
ON CT.created_by = U.id

where CT.eff_to is null
and CT.company_id > 100
and U.department = 'sales' 
and U.eff_to is null

group by 1,2

order by 5 desc,1 desc";
    $query = $this->db->query($sql);
    return $query->result_array();
}

    
    
    public function create_sub($post,$userID)
    {
       
         $itemid = $post['itemid'];
        
        
        $eff_from = $this->dateTrasnformer($post['eff_from']);
            $eff_to  = $this->dateTrasnformer($post['eff_to']);
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities(ucwords($post['name'])),
        'master_category_id' => $itemid,
           'eff_from' => $eff_from,
           'eff_to' => $eff_to ? $eff_to : NULL,
          'updated_by' => $userID
       );
       
       $this->db->insert('tag_categories', $data);   
    }
    
    public function add_category($post,$userID)
    {
         
        
        $eff_from = $this->dateTrasnformer($post['eff_from']);
            $eff_to  = $this->dateTrasnformer($post['eff_to']); 
    $data = array(
          'created_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities(ucwords($post['name'])),
        'master_category_id' => $post['create_category'] ? $post['create_category'] : NULL,
           'eff_from' => $eff_from,
           'eff_to' => $eff_to ? trim($eff_to) : NULL,
          'created_by' => $userID
       );
       
       $this->db->insert('tag_categories', $data);
        
        
         return $post['userID'];
       
    }
    public function show_category($string= false)
    {
        
        //WHERE t.master_category_id =22
        $string = $string ? '='.$string : 'IS NULL';
 
      $sql = 'SELECT distinct t.*, tcsub.eff_from as cat_eff_from, tcsub.eff_to as cat_eff_to,tcsub.id as sub_id, tcsub.name as sub_name, tcsub.id as sub_master_id  FROM tag_categories t
LEFT JOIN tag_categories tcsub
ON t.id = tcsub.master_category_id 
 WHERE t.master_category_id '.$string.'
ORDER BY t.name';
   
      $query = $this->db->query($sql);
      return json_encode($query->result_array());

    }
    
    function getEditTags($id= false){
        
        $sql = 'SELECT   tc.name as name, t.id, t.eff_from, t.eff_to, t.name  as sub_name, t.id as sub_master_id, t.id as tag_id, t.category_id FROM tag_categories tc
LEFT JOIN tags t
ON tc.id = t.category_id
 WHERE t.category_id ='.$id;
        
         $query = $this->db->query($sql);
      return json_encode($query->result_array()); 
        
    }
    
    public function update_category($post)
    {

        $itemid = $post['itemid'];
        $master = $post['masterID'];
        
        
        $eff_from = $this->dateTrasnformer($post['eff_from']);
            $eff_to  = $this->dateTrasnformer($post['eff_to']); 
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities(ucwords($post['name'])),
        'master_category_id' => $master ? $master : NULL,
           'eff_from' => trim($eff_from),
           'eff_to' => trim($eff_to) ? trim($eff_to) : NULL,
          'updated_by' => $userID
       );
       
        $this->db->where('id', quotes_to_entities($itemid));  
        $this->db->update('tag_categories', $data); 
    }
    public function _delete_category($id)
    {

    }
    
    //Tag
    public function add_tag($post,$userId)
    {
        
         $itemid = $post['itemid'];
        
        
         $eff_from = $this->dateTrasnformer($post['eff_from']);
            $eff_to  = $this->dateTrasnformer($post['eff_to']); 
        
        $data = array(
           'category_id' => $itemid,
           'name' => quotes_to_entities(ucwords($post['name'])),
           'tag_type' =>  1,
           'created_at' => date('Y-m-d'),
           'eff_from' =>  trim($eff_from),
           'eff_to' =>  trim($eff_to) ? trim($eff_to) : NULL,
           'created_by' => $userId
       );
        
       $this->db->insert('tags', $data);
    }
    
    public function edit_tag($post,$userId)
    {
        
        $eff_from = $this->dateTrasnformer($post['eff_from']);
            $eff_to  = $this->dateTrasnformer($post['eff_to']); 
        
         $itemid = $post['itemid'];
        $master = $post['masterID'];
        $data = array(
         'name' => quotes_to_entities($post['name']),
           'eff_from' =>  trim($eff_from),
           'eff_to' => trim($eff_to) ? trim($eff_to) : NULL,
          'updated_by' => $userId
       );
        
          $this->db->where('id', quotes_to_entities($itemid)); 
       
       $this->db->update('tags', $data);
        
    }
    public function show_tag($id)
    {
        
        $sql = 'SELECT t.id as tag_id, 
        t.name , 
        tc.id as tac_sub_cat_id,
        tc.name as sub_cat_name,
        tcn.id as sub_parent_cat_id ,
        tcn.name as parent_cat_name , 
        t.tag_type, 
        t.eff_from,
        t.eff_to as eff_to
        FROM tags t
        LEFT JOIN tags tt
        ON  t.category_id = tt.id
        LEFT JOIN tag_categories tc
        ON t.category_id  = tc.id
        LEFT JOIN tag_categories tcn
        ON tc.master_category_id = tcn.id
        WHERE t.tag_type=1 
        AND t.category_id='.$id;
 
        $query = $this->db->query($sql);
      return json_encode($query->result_array());  
        
    }
    
    public function update_tag($post)
    {
     $itemid = $post['itemid'];
        
        
         $eff_from = $this->dateTrasnformer($post['eff_from']);
         $eff_to  = $this->dateTrasnformer($post['eff_to']); 
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
           'eff_from' => $eff_from,
           'eff_to' => $eff_to ? $eff_to : NULL,
          'updated_by' => $userID
       );
       
        $this->db->where('id', quotes_to_entities($itemid));  
        
       $this->db->update('tags', $data);
    }
    
    public function delete_tag($id)
    {
        $this->db->delete('tags', array('id' => $id)); 
        
        return json_encode(array('success' => 'ok'));
    }
      //contact Tags
    public function add_contact_tag($post)
    {
            $data = array(
          'tag_id' => isset($post['tagID']) ? $post['tagID'] : 2,
          'contact_id' => isset($post['name']) ? $post['name'] : 1234,
           'created_at' => date('Y-m-d'),
           'eff_from' => date('Y-m-d'),
           'eff_to' => date('Y-m-d'),
          'created_by' => $post['userID']
       );
       
       $this->db->insert('contact_tags', $data);
    }
    public function _show_contact_tag($id)
    {

    }
    public function _update_contact_tag($post)
    {

    }
    public function _delete_contact_tag($id)
    {

    }
    
          //Company Tags
    public function add_company_tag($post)
    {
            $data = array(
          'tag_id' => isset($post['tagID']) ? $post['tagID'] : 2,
          'company_id' => isset($post['name']) ? $post['name'] : 1234,
           'created_at' => date('Y-m-d'),
           'eff_from' => date('Y-m-d'),
           'eff_to' => date('Y-m-d'),
          'created_by' => $post['userID']
       );
       
       $this->db->insert('company_tags', $data);
    }
    public function _show_company_tag($id)
    {

    }
    public function _update_company_tag($post)
    {

    }
    public function _delete_company_tag($id)
    {

    }
    
    public function checkCategoryName($cat_name, $master_cat_id =false){ //Check if category tag exist
    $master_cat_id = $master_cat_id ?  'AND master_category_id='.quotes_to_entities($master_cat_id) :  '' ;

    $query = $this->db->query("SELECT name FROM tag_categories WHERE name  ilike '".quotes_to_entities($cat_name)."' ".$master_cat_id."  LIMIT 1");

    if ($query->num_rows() > 0)
    {

    return false;
    }
    return true;
    }

    
    public function checkTagName($cat_name, $master_cat_id =false){ //Check if category tag exist
        
       
        $query = $this->db->query("SELECT name FROM tags WHERE name  ilike '".quotes_to_entities($cat_name)."' AND category_id=".$master_cat_id."  LIMIT 1 ");

        if ($query->num_rows() > 0)
        {

        return false;
        }
        return true;
        }
    
     public function getCategoryName($cat_name)
     { //Check if category tag exist
        
        $query = $this->db->query("SELECT name FROM tag_categories WHERE name  ilike '".quotes_to_entities($cat_name)."'  LIMIT 1");
       
            if ($query->num_rows() > 0)
                {
                   $row = $query->row(); 
        
                   return $row->id;
        
                }
        
        return false;
    }
    
    public function check_if_date_in_past($newDate)
    {
         
        $datetime1 = new DateTime(date('Y-m-d'));
        $datetime2 = new DateTime($newDate);
        $interval = $datetime1->diff($datetime2);
        $int =  $interval->format('%R%a');
     
         if($int[0] === '-'){
             
             return false;
             
         }else{
             
              return true ; 
         }
     }
        
    public function feReadTag()
    {

        
        $sql = 'SELECT  DISTINCT
        tc.sequence, tc.id as cat_id, 
        tcn.name as parent_cat_name ,
        tcn.id as sub_parent_cat_id ,
        tc.id as tac_sub_cat_id,
        tc.name as sub_cat_name,
        t.id as tag_id, 
        t.tag_type, 
        t.eff_from,
        t.eff_to as eff_to,
        tc.name as category_name,
        t.name,
        t.how_used
        FROM tags t
        LEFT JOIN tags tt
        ON  t.category_id = tt.id
        LEFT JOIN tag_categories tc
        ON t.category_id  = tc.id
        LEFT JOIN tag_categories tcn
        ON tc.master_category_id = tcn.id
        WHERE tc.eff_from <= DATE(NOW()) 
        AND t.eff_from <= DATE(NOW()) 
        AND  (tc.eff_to >= DATE(NOW()) or  tc.eff_to IS NULL) 
	 AND  (t.eff_to >= DATE(NOW()) or  t.eff_to IS NULL)  
   order by  tc.sequence        
        
        
        '; 

         $query = $this->db->query($sql);
           $query =   $query->result_array();

        return json_encode($query); 

    }
    
    function fegetcategories()
    {
        
        $sql = 'SELECT name as  par_name FROM tag_categories  WHERE master_category_id IS NULL '; 

        $query = $this->db->query($sql);

        $query = $query->result_array();

        return json_encode($query); 
        
    }
    
    
     function fegettags($post, $userID)
    {
        
        $sql = 'SELECT  tc.sequence, t.name, ct.id as tag_id ,tc.id as parent_tag_id, tc.name as parent_tag_name, u.name as username, ct.eff_from as tagcreatedat 
        FROM company_tags  ct
        LEFT JOIN tags t
        ON ct.tag_id= t.id
        LEFT JOIN tag_categories tc
        ON t.category_id = tc.id
        LEFT JOIN users u
        ON ct.created_by = u.id
        WHERE ct.company_id='.$post['companyID'].' 
        AND ct.eff_from <= DATE(NOW()) 
        AND ct.eff_to IS NULL 
        AND t.eff_from <= DATE(NOW()) 
        AND t.eff_to IS NULL
        ORDER BY tc.sequence asc'; 
         
        $query = $this->db->query($sql);

        $query = $query->result_array();

        return json_encode($query);    
    }
    
    
    function feAddTag($post, $userID)
    {
        
        //$getTagEffFromDate  = $this->getTagEffFromDate($post['tagid']); //removed. No need to keep full track of original date added
        $checkForDuplicateEntry = $this->checkForDuplicateEntry($post['tagid'],$post['companyID']);
        
        if($checkForDuplicateEntry){
        
            $arrSql = array(
            'tag_id' => $post['tagid'],
             'eff_from' => date('Y-m-d'),
             'created_by' => $userID,
            'company_id' => $post['companyID']
            );
            $this->db->insert('company_tags', $arrSql);
            return json_encode(array('success' => 'ok'));
        }else{
            
           return json_encode(array('error' => 'This Company tag already exist')); 
            
        }
    }
    
    
    function getTagEffFromDate($id)
    {
        
        $query = $this->db->query("SELECT eff_from FROM tags WHERE id='".$id."' LIMIT 1");
            if($query->num_rows() > 0){
                $row = $query->row(); 
                return $row->eff_from;
            }
    }
    
    function checkForDuplicateEntry($id,$compID)
    {
        
     $sql = 'SELECT id, eff_to, updated_by FROM company_tags
        WHERE tag_id='.$id.'
         AND company_id ='.$compID.'
         ORDER by eff_to DESC
         LIMIT 1
         ';
        
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            
         
            
            $row = $query->row();
            
            
               if($row->eff_to >= date('Y-m-d')   ||  $row->eff_to == ''){
                   
            return false;
               }else{
                   
                   return true;
               }
        }else{
           return  true;
        }
    }
        
        
    function feDeleteTag($post,$userID){
        $id = $post['datatagid'];
        $comp_id =  $post['comp_id'];
        $data = array(
            'eff_to' => date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d')))),
            'updated_by' =>$userID,
            'updated_at' =>date('Y-m-d'),
            'company_id' => $comp_id
            );

$this->db->where('id', $id);
        
$this->db->update('company_tags', $data); 
             return json_encode(array('success' => $id));
    }
    
    function dateTrasnformer($dateTransform){
        
        if(trim($dateTransform)){
        $dd = explode('-', $dateTransform);

return  $dd[2].'-'.$dd[1].'-'.$dd[0];
            
            
        }
        
          return null;
        
    }
    
  
}