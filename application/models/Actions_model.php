<?php
class Actions_model extends MY_Model {
    


    // GETS

function get_actions1($company_id)
{
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where_not_in('action_type_id', $category_exclude);
    $this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
    
}

function get_actions($company_id)
{

    $sql = "select distinct
    c.id,
    ec.id as id,
    ec.name as campaign_name,
    con.id as contact_id,
    con.first_name,
    con.last_name,
    ec.date_sent,
    u.image,
    u.name,
    ec.created_at,
    20 AS action_type_id,
    ec.date_sent as actioned_at,
    'email campaign' as comments
    from email_campaigns ec
    left join email_actions ea on ec.id = ea.email_campaign_id
    left join contacts con on ea.contact_id = con.id
    left join companies c on con.company_id = c.id
    left join users u on ec.created_by = u.id
    where c.id = '$company_id'
    AND ec.name != 'pending'
    union all
    select distinct
    c.id,
    a.id as id,
    at.name as campaign_name,
    con.id as contact_id,
    con.first_name,
    con.last_name,
    a.actioned_at as \"actioned_at\",
    u.image,
    u.name,
    a.created_at,
    a.action_type_id as action_type_id,
    a.actioned_at as actioned_at,
    a.comments
    from actions a
    left join
    action_types at on
    a.action_type_id = at.id
    left join companies c on a.company_id = c.id
    left join users u on a.user_id = u.id
    left join contacts con on a.contact_id = con.id
    where c.id = '$company_id'
    ORDER BY 10 desc LIMIT 10";
            $query = $this->db->query($sql);
    return $query->result_object();
    
}

function get_marketing_actions($user_id)
{
    $sql = "select distinct ec.name as campaign, c.id as company_id, c.name as company, c.pipeline, con.first_name, con.last_name, CONCAT(con.last_name, ' ', con.first_name)  as username,to_char(ea.created_at, 'DD-MM-YYYY') as Date, ea.created_at, ea.email_action_type, ea.link as url from companies c
    left join contacts con on
    c.id = con.company_id
    left join email_actions ea on 
    ea.contact_id = con.id
    left join email_campaigns ec on 
    ec.id = ea.email_campaign_id
    where (ea.email_action_type = '2' or ea.email_action_type = '3') and c.pipeline not in ('proposal','customer') and ec.created_by = $user_id
      limit 1 ";
    $query = $this->db->query($sql);
    return $query->result_object();
    
}
    
function get_marketing_actions_two($user_id)
{
    $sql = "select c.id as company_id, to_char(ea.action_time, 'DD-MM-YYYY') as Date,ec.name as campaign, ea.email_action_type as action, c.name as company, c.pipeline, con.first_name, con.last_name, CONCAT(con.last_name, ' ', con.first_name)  as username, ea.created_at, ea.email_action_type, ea.link as url from companies c
    left join contacts con on
    c.id = con.company_id
    left join email_actions ea on 
    ea.contact_id = con.id
    left join email_campaigns ec on 
    ec.id = ea.email_campaign_id
    where (ea.email_action_type = '2' or ea.email_action_type = '3' or ea.email_action_type = '4' or ea.email_action_type = '1' ) and c.pipeline not in ('proposal','customer')  and ec.created_by = $user_id
    AND ec.name IS NOT null
    AND ea.email_action_type !=4
    AND ec.name != 'pending'
    ORDER BY ea.action_time DESC
    limit 200";
    
    //echo $sql;
        //AND ea.created_by = $user_id 
    $query = $this->db->query($sql);
    
    return $query->result_object();
    
}
    
function get_actions_outstanding($company_id,$limit =100)
{
    $category_exclude = array('7', '20');
    $data = array(
        'a.company_id' => $company_id,
        );
    $this->db->select('a.company_id, a.id "action_id",a.followup_action_id,a.comments,a.planned_at,a.action_type_id,u.name ,c.first_name,c.last_name,c.phone,ufwd.name as createfollowername, comp.initial_rate,c.email,a.user_id,c.id "contact_id",a.created_at as "created_at",a.actioned_at as "actioned_at", at.name as actionType, a.planned_at, u.image ,comp.name as "company_name",');
    $this->db->where('a.planned_at IS NOT NULL', null);
    $this->db->where('a.actioned_at IS NULL', null);
    $this->db->where('a.cancelled_at IS NULL', null);
    $this->db->where_not_in('a.action_type_id',$category_exclude);
    $this->db->join('contacts c', 'c.id = a.contact_id', 'left');
    $this->db->join('users u', 'a.user_id = u.id', 'left');
     $this->db->join('users ufwd', 'a.campaign_id = ufwd.id', 'left');
    $this->db->join('companies comp', 'a.company_id = comp.id', 'left');
    $this->db->join('action_types at', 'a.action_type_id = at.id', 'left');
    $this->db->order_by('a.actioned_at desc, a.cancelled_at desc,a.planned_at desc');
     $this->db->limit($limit);
    $query = $this->db->get_where('actions a', $data);
//echo $this->db->last_query();
  //  exit();
    return $query->result_object();
}

function get_actions_completed($company_id)
{
    $category_exclude = array( '20');
    $data = array(
        'a.company_id' => $company_id,
        );
  $sql = "SELECT  adj.currency,adj.remittance_id, a.created_at, a.actioned_at, a.action_type_id, com.initial_rate, a.comments, a.cancelled_at, a.campaign_id, a.outcome, a.id, u.image, u.name, c.first_name, c.last_name, a.contact_id, a.followup_action_id, a.tfer_turnover, a.tfer_runners, a.initial_fee, a.planned_at,T1.updated_at outcome_action_date,
 CASE when a.created_by = T1.updated_by then null else T1.peep END originalcreator,
  CASE when a.created_by = T2.updated_by then null else T2.peep END creater
FROM actions a
LEFT JOIN contacts c ON c.id = a.contact_id
LEFT JOIN users u ON a.user_id = u.id
LEFT JOIN companies com ON a.company_id = com.id
LEFT JOIN adjustments adj ON a.id = adj.action_id

LEFT JOIN (select cb.id,cb.user_id, cb.updated_by,cb.updated_at, u.name as peep from actions cb LEFT JOIN users u on cb.updated_by = u.id where company_id=".$company_id.") T1
ON a.id = T1.id
LEFT JOIN (select cb.id, cb.updated_by, u.name as peep from actions cb LEFT JOIN users u on cb.created_by = u.id where company_id=".$company_id.") T2
ON a.id = T2.id
WHERE actioned_at IS NOT NULL
AND followup_action_id IS NULL
AND action_type_id NOT IN(20)
AND a.company_id = ".$company_id."

ORDER BY actioned_at desc,planned_at desc
";
    
    /*
    $this->db->join('contacts c', 'c.id = a.contact_id', 'left');
    $this->db->join('users u', 'a.user_id = u.id', 'left');
    $this->db->join('companies com', 'a.company_id = com.id', 'left');
     //$this->db->join('files f', 'a.id = f.action_id', 'left');
    $this->db->where('actioned_at IS NOT NULL', null);
    $this->db->where('followup_action_id', null);
    $this->db->where_not_in('action_type_id', $category_exclude);
    $this->db->order_by('actioned_at desc,planned_at desc');
   
    */
     //$query = $this->db->get_where('actions a', $data);
   // echo $this->db->last_query();
      $query = $this->db->query($sql);
    
    return $query->result_object();
}
    
    function get_actions_files($company_id)
{ //TESTER FOR FILES QUERRY DELETE AFTER USE
 $sql = 'select * FROM files WHERE company_id='.$company_id;
    //echo $this->db->last_query();
         $query = $this->db->query($sql);
 
        //return $query->result_array();
    return $query->result_object();
}
    
function get_follow_up_actions($company_id) //Added by glen this has only one dependency located in the companies controller
{
    $category_exclude = array('7', '20');
    $data = array(
        'a.company_id' => $company_id,
        );
    $this->db->select('a.created_at,a.actioned_at,a.action_type_id,a.comments,a.outcome,a.cancelled_at,a.id,u.image,u.name,c.first_name,c.last_name,a.contact_id,a.followup_action_id, a.planned_at", ');
    $this->db->join('contacts c', 'c.id = a.contact_id', 'left');
    $this->db->join('users u', 'a.user_id = u.id', 'left');
    $this->db->where('followup_action_id IS NOT NULL', null);
    $this->db->where_not_in('action_type_id', $category_exclude);
    $this->db->order_by('actioned_at desc,planned_at desc');
    $query = $this->db->get_where('actions a', $data);
    return $query->result_object();
}    
    

function get_actions_cancelled($company_id)
{
    $category_exclude = array('7', '20');
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where('cancelled_at IS NOT NULL', null);
    $this->db->where_not_in('action_type_id', 7);
    $this->db->order_by('cancelled_at, planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
}

function get_actions_marketing($company_id)
{
    $sql = "select distinct ec.name as campaign_name, con.first_name, con.last_name,  
    c.name, u.email,u.id as user_id,ec.date_sent,ec.sent_id, to_char(ec.date_sent, 'DAY DDth MONTH') as Dater,to_char(ea.action_time, 'DAY DDth MONTH YYYY') as Date, ea.email_action_type as action,
    sum(case when email_action_type = '2' then 1 else 0 end) opened,
    sum(case when email_action_type = '3' then 1 else 0 end) clicked,
    sum(case when email_action_type = '3' and link ilike '%unsubscribe%' then 1 else 0 end) unsubscribed
    from email_campaigns ec
    left join email_actions ea on ec.id = ea.email_campaign_id
    inner join contacts con on ea.contact_id = con.id
    left join companies c on con.company_id = c.id
    left join users u on ec.created_by = u.id
    where c.id = '$company_id'
    AND ec.name != 'pending'
    AND ea.action_time >= '2016-01-01'
    group by 1,2,3,4,5,6,7,8,ea.email_action_type,action_time order by date_sent desc LIMIT 100";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array(); 
    }else{
        return [];
    }
}

function get_comments($company_id)
{
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where('action_type_id', '7');
    $this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
}

    function get_comments_two($company_id)
{
    $sql = "SELECT a.*, u.name as created_by , u.image
FROM actions a
LEFT JOIN users u
ON a.created_by = u.id
WHERE a.action_type_id =30  AND a.company_id='$company_id'
OR a.action_type_id =7
AND a.company_id='$company_id'";
         $query = $this->db->query($sql);
    return $query->result_object();
}
    
  
    
function get_pending_actions($user_id)
{       
    $this->db->select("actions.company_id, actions.id as action_id,comments,planned_at,action_type_id,name as company_name,contacts.first_name,contacts.last_name,contacts.phone as contact_phone,contacts.email, to_char(planned_at, 'HH24:MI DD/MM/YY') as duedate, companies.phone as company_phone, companies.pipeline,companies.user_id as userID,companies.assign_date ");
    $this->db->where('actions.user_id',$user_id);
    $this->db->where('actioned_at',NULL);
    $this->db->where('cancelled_at',NULL);
      $this->db->where('active',true);    
    $this->db->join('companies', 'companies.id = actions.company_id', 'left');
    $this->db->join('contacts', 'contacts.id = actions.contact_id', 'left'); 
    $this->db->limit(200);
    $this->db->order_by('cancelled_at desc,planned_at asc');
    $query = $this->db->get('actions');
    // var_dump($query);
    
   // echo $this->db->last_query();
    
    return $query->result_object();

}
function get_assigned_companies($user_id)
{   
    
    $this->db->where('user_id',$user_id);
    $this->db->where('active','t');
    $this->db->order_by("name asc, assign_date desc"); 
    $query = $this->db->get('companies');
    return $query->result_object();

}
    
function get_assigned_companies_ajax($user_id, $order = false)
{   
       
    
    $orderby = 'name asc, assign_date desc';
    if($order)
        $orderby = 'pipeline asc, assign_date desc';
    
    $sql = "SELECT id, name, pipeline
    FROM companies
    WHERE user_id=".$user_id."
    AND active='t'
    Order BY ".$orderby."
    ";

    $query = $this->db->query($sql);
    return $query->result_object();
}
    
function get_recent_stats($period, $team_type)
{   
 $team_type =  trim($team_type) ;
 
    if(!empty($team_type)){
        //$team_type_sql = "and u.market = '$team_type'";
    }
    $dates = $this->dates($period);
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];

$sql[] = "select U.name, 
       U.id as user, 
       U.image, 
       U.active as active, 
       sum(CASE when action_type_id in (4) and A.actioned_at between '$start_date' and '$end_date' then 1 else 0 END ) introcall, 
       sum(CASE when action_type_id in (4,5,11,17) and A.actioned_at between '$start_date' and '$end_date' then 1 else 0 END) salescall, 
       sum(CASE when action_type_id in (5,11) and A.actioned_at between '$start_date' and '$end_date' then 1 else 0 END) callcount, 
       sum(CASE when action_type_id in (10,12) and A.actioned_at between '$start_date' and '$end_date' then 1 else 0 END) meetingcount, 
       sum(CASE when action_type_id in (9,15) and A.actioned_at between '$start_date' and '$end_date' then 1  else 0 END) democount, 
       sum(CASE when action_type_id in (9,15) and A.created_at between '$start_date' and '$end_date' then 1  else 0 END) demobookedcount, 
       sum(CASE when action_type_id in (10,12) and A.created_at between '$start_date' and '$end_date' then 1  else 0 END) meetingbooked, 
       sum(CASE when action_type_id in (16) and A.created_at between '$start_date' and '$end_date' then 1  else 0 END) deals, 
       sum(CASE when action_type_id in (25) and A.created_at between '$start_date' and '$end_date' then 1  else 0 END) duediligence, 
       sum(CASE when action_type_id in (22) and A.created_at between '$start_date' and '$end_date' then 1  else 0 END) key_review_added, 
       sum(CASE when action_type_id in (22) and A.actioned_at between '$start_date' and '$end_date' then 1  else 0 END) key_review_occuring, 
       sum(CASE when action_type_id in (8) and A.actioned_at between '$start_date' and '$end_date' then 1 else 0 END) proposals
       
        from ACTIONS A

        JOIN COMPANIES C 
        on A.company_id = C.id 

        JOIN USERS U 
        on A.user_id = U.id

        where U.department = 'sales'
        and U.active = 't'
        and A.cancelled_at is null
        ";
  
        if($team_type == 'admin' ){  
            $team_type = 'uf';
        } 

        $sql[]  ="and U.market= '".trim($team_type)."' ";
        $sql[] = "group by 1,2,3,4 order by deals desc nulls last, proposals desc";
    
    $sql = join($sql);
    
    $sqlOld = "select U.name, U.id as user, U.image, U.active as active,
    sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
    sum(case when (action_type_id = '4' or action_type_id = '5' or action_type_id = '11' or action_type_id = '17')  AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) salescall,
    sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
    sum(case when (action_type_id = '12' or action_type_id = '10') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
    sum(case when (action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) democount,
    sum(case when (action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) demobookedcount,
    sum(case when (action_type_id = '12' or action_type_id = '10') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
    sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
    sum(case when action_type_id = '25' AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) duediligence,
    sum(case when action_type_id = '22' AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) key_review_added,
    sum(case when action_type_id = '22' AND a.planned_at > '$start_date' AND a.planned_at < '$end_date' then 1 else 0 end) key_review_occuring,
    sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals,
    Sum(case when action_type_id = '19' and a.id =  (SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' THEN 1 ELSE 0 END) AS pipelinecount
    from actions A INNER JOIN companies C on A.company_id = C.id INNER JOIN users U on A.user_id = U.id group by U.id,U.name,a.cancelled_at, u.department HAVING cancelled_at is null and u.department = 'sales' and (u.active = 't' or sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) >0) $team_type_sql order by deals desc,proposals desc,meetingbooked desc, introcall desc, name desc";
    
    
    
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}

function get_pipeline_contacted()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }else{
        $start_date_sql = "a.created_at > NOW() - INTERVAL '30 days'";}
        $sql = "select
        c.id as company_id,
        a.comments,
        c.name as company_name,
        a.id,
        a.created_at,
        c.pipeline,
        u.name as username
        from companies c
        inner join actions a on
        c.id = a.company_id
        and a.id =  (
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' and c.pipeline not in ('Customer','customer','Proposal','proposal','Lost','lost')
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
    
function get_pipeline_contacted_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '30 days'";}
        $sql = "select
        c.id as company_id,
        a.comments,
        c.name as company_name,
        a.id,
        a.created_at,
        c.pipeline,
        u.name as username
        from companies c
        inner join actions a on
        c.id = a.company_id
        and a.id =  (
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' 
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19'  and c.pipeline not in ('Customer','customer','Proposal','proposal','Lost','lost') and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_proposal()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '60 days'";
    }
    $sql = "select
    c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id =    (
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and a.created_at > NOW() - INTERVAL '60 days' AND $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_proposal_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '60 days'";}
        $sql = "select
        c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id =    (
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' 
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_customer()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($start_date)) {
        $start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
    }
    $sql = "select c.id as company_id, a.comments, c.name as company_name, a.id, a.created_at, c.pipeline, u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id =  (
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '16' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '16'   $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_customer_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($start_date)) {
    $start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
    }
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id =  (
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '16' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '16' and (c.pipeline ilike '%customer%') $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_lost()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id =  (
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' and a.created_at > NOW() - INTERVAL '60 days' order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_lost_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id =  (
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date'order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_user_placements($period)
{
    $dates = $this->dates($period);
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    $search_user_id = $dates['search_user_id'];
    if (!empty($search_user_id)) {
        $sql = "select distinct c.name, a.actioned_at, c.id, a.created_by, c.id as compid, u.name as username, ls.name as lead_name, c.initial_rate from companies c 
         inner join actions a on c.id = a.company_id
         left join lead_sources ls on c.lead_source_id = ls.id
         left join users u on a.created_by = u.id where a.action_type_id = '16' and a.user_id = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.actioned_at asc";
        
        //echo $sql;
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
}

function dates($period = false)
{
    if ($period==='search') {
        if (!empty($_GET['start_date'])) {
            $start_date = date('Y-m-d 00:00:00',strtotime($_GET['start_date']));
        } else {
            $start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
        }
        if (!empty($_GET['end_date'])) {
            $end_date = date('Y-m-d 23:59:59',strtotime($_GET['end_date']));
        } else {
            $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
        }
    }
    else if ($period==='week') {
        $start_date = date('Y-m-d 00:00:00',strtotime('monday this week'));
        $end_date = date('Y-m-d 23:59:59',strtotime('sunday this week'));
    }
    else if ($period==='lastweek') {
        $start_date = date('Y-m-d 00:00:00',strtotime('monday last week'));
        $end_date = date('Y-m-d 23:59:59',strtotime('sunday last week'));
    }
    else if ($period==='thismonth') {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
    }
    else if ($period==='lastmonth') {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of previous month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of previous month'));
    }
    else
    {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
    }
        return array('search_user_id' => $_GET['user'], 'start_date' => $start_date, 'end_date' => $end_date);
}


function get_user_proposals($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (!empty($search_user_id)) {
        $sql = "select distinct c.name, a.created_at, c.id from companies c inner join actions a on c.id = a.company_id where a.action_type_id = '8' and a.user_id = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.created_at asc";
        $query = $this->db->query($sql);
        if($query){
            return $query->result_array();
        }else{
            return [];
        }
    }
}


function get_user_meetings($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    if (!empty($search_user_id)) {
         $sql = "select distinct c.name, a.created_at,a.actioned_at,a.planned_at, c.id from companies c inner join actions a on c.id = a.company_id where (action_type_id = '12' or action_type_id = '10') and a.user_id = '$search_user_id' AND (a.created_at > '$start_date' or a.actioned_at > '$start_date') AND (a.created_at < '$end_date' or a.actioned_at < '$end_date') group by c.name, a.created_at,a.actioned_at,a.planned_at, c.id order by a.actioned_at, a.planned_at asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}

function get_user_demos($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    if (!empty($search_user_id)) {

      $sql = "select distinct c.name, a.created_at,a.actioned_at,a.planned_at, c.id from companies c inner join actions a on c.id = a.company_id where (action_type_id = '9' or action_type_id = '15') and (a.created_by = '$search_user_id' or a.updated_by = '$search_user_id') AND (a.created_at > '$start_date' or a.actioned_at > '$start_date') AND (a.created_at < '$end_date' or a.actioned_at < '$end_date') and a.cancelled_at is null group by c.name, a.created_at,a.actioned_at,a.planned_at, c.id order by a.actioned_at, a.planned_at asc";
    $query = $this->db->query($sql);
    return $query->result_array();
}
}


function get_action_types_array()
{
    $this->db->select("id,name");
    $query = $this->db->get('action_types');
    foreach($query->result() as $row)
    {
      $array[$row->id] = $row->name;
    }   
    return $array;

}

function get_action_types_done()
{
    $ignore = array('19','7','20','33'); //EXCLUDE PIPELINE TRACKING, COMMENT AND MARKETING//
    $data = array(
        'type' => 'Done',
        );
    $this->db->where_not_in('id', $ignore);
    $this->db->order_by('name', 'asc'); 

    $query = $this->db->get_where('action_types',$data);
    return $query->result_object();
}


function get_action_types_planned()
{   
    $this->db->order_by('name', 'asc'); 
    $query = $this->db->get_where('action_types',array('type'=>'Planned'));
    return $query->result_object();
}

// UPDATES
function set_action_state($action_id,$user_id,$state,$outcome,$post)

{
    //$outcome =  htmlentities($outcome);

 

    
    
    if($state == 'completed'){
        $data = array(
        'outcome' => (!empty($outcome)?$outcome:NULL),
        'actioned_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user_id,
        );
    }
    
    if($state == 'cancelled'){
        $data = array(
        'outcome' => (!empty($outcome)?$outcome:NULL),
        'cancelled_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user_id,
        );
    }
    
    $this->db->where('id',$action_id);
    $this->db->update('actions',$data);
    
    
    if($this->db->affected_rows() !== 1){
        $this->addError($this->db->_error_message());
        return false;
    }else{
        
        
              if ($post['action_type_planned']>0) {
                  
                  
                      
       
        if($post['who_user_id'] != $user_id ){
            
            $useris =  $user_id;
            
            
        }
             
                  
                   $query = $this->db->query("SELECT created_by FROM actions where id=".$action_id." LIMIT 1");
                    $output =   $query->result_array();
                   $num =  $query->num_rows();
                  
                  if($num == true) $user_id =  $output[0]['created_by'];  
                  
                //  echo $user_id;
                  
                  //exit();
                  
            $planneddata = array(
            'company_id'    => $post['company_id'],
             'user_id'      => $post['who_user_id'] ? $post['who_user_id'] : $user_id,
            'comments'      => (!empty($outcome)?$outcome:NULL),
            'planned_at'    => $post['planned_at'],
            'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
            'created_by'    =>  $useris ? $useris : $user_id,
            'campaign_id' => $useris ? $useris : null,
            'action_type_id'=> $post['action_type_planned'],
            'actioned_at'   =>  NULL,
            'created_at'    => date('Y-m-d H:i:s'),
            'followup_action_id' =>(isset($post['followup_action_id'])?$post['followup_action_id']:NULL),
        );
       $query = $this->db->insert('actions', $planneddata);
        
        
        }
        
        return true;
    } 
    
}

// INSERTS
function create($post, $userid =false)
{
    
    
    
    
    $query = $this->db->query("SELECT * FROM actions WHERE company_id=".$post['company_id']." AND action_type_id=16  LIMIT 1");

    if ($query->num_rows() > 0 &&  $post['action_type_completed'] ==16)
        {
         return false;

        }else{
    
    if ($post['action_type_completed']>0) {

    //TEST - COMPLETED ACTION ONLY
    $completeddata = array(
        'company_id'    => $post['company_id'],
        'user_id'       => $userid ? $userid : $post['user_id'],
        'comments'      => (isset($post['comment'])?htmlspecialchars(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', rtrim($post['comment']))):NULL),
        'planned_at'    => NULL,
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'    => $userid ? $userid : $post['user_id'],
        'action_type_id'=> (isset($post['action_type_completed'])?$post['action_type_completed']:$post['action_type']),
        'actioned_at'   => date('Y-m-d H:i:s'),
        'created_at'    => date('Y-m-d H:i:s'),
        'followup_action_id' =>(isset($post['followup_action_id'])?$post['followup_action_id']:NULL),
         'tfer_turnover' => $post['turnover']?$post['turnover']:null,
         'tfer_runners'  => $post['runners'] ?$post['runners']:0,
         'initial_fee'  => (!empty($post['initialfee'])? $this->calIntRate($post['initialfee']):NULL)
        );
    $query = $this->db->insert('actions', $completeddata);
    //END TEST
    

if($post['action_type_completed'] == 43){
 
    $adjustments  = array("company_id" =>   $post['company_id'],
               "created_at" => date('Y-m-d H:i:s'),
               "created_by" => $userid ? $userid : $post['user_id'],
               "action_id" => $this->db->insert_id(),
               "adjustment_type_id" =>$post['adjustment_type_id'],
               "invoice_id" => (!isset($post['invoice_id'])?$post['invoice_id']:NULL),
               "remittance_id" => (!isset($post['remittance_id'])?$post['remittance_id']:NULL),
               "currency" =>$post['currency'],
               "name" => (isset($post['cc_name'])?$post['cc_name']:NULL),
               "candidate" => (isset($post['candidate'])?$post['candidate']:NULL),
               "client" => (isset($post['client'])?$post['client']:NULL),
               "weekending" =>date('Y-m-d H:i:s'),
               "adjustment_amount" => $post['adjustment_amount'],
               "reason" => (isset($post['reason'])?$post['reason']:NULL),
               "change_details" =>(isset($post['change_details'])?$post['change_details']:NULL)

               );   
    
                $query = $this->db->insert('adjustments', $adjustments);
        }





}
    
    if ($post['action_type_planned']>0) {
        
        $useris = array();
        if($post['who_user_id'] != $post['user_id'] ){
            
            $useris =  $post['user_id'];
            
            
        }

        $planneddata = array(
            'company_id'    => $post['company_id'],
            'user_id'       => $post['who_user_id'] ? $post['who_user_id'] : $post['user_id'],
            'comments'      => (isset($post['comment'])?htmlspecialchars(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', rtrim($post['comment']))):NULL),
            'planned_at'    => $post['planned_at'],
            'campaign_id' => $useris ? $useris : null,
            'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
            'created_by'    => $userid ? $userid : $post['user_id'],
            'action_type_id'=> $post['action_type_planned'],
            'actioned_at'   =>  NULL,
            'created_at'    => date('Y-m-d H:i:s'),
            'followup_action_id' =>(isset($post['followup_action_id'])?$post['followup_action_id']:NULL),
        );
        $query = $this->db->insert('actions', $planneddata);

    }
        
    
        //$sqlCheckTags  = "SELECT tag_id FROM company_tags WHERE tag_id=267 AND company_id=".$post['company_id']." AND eff_to IS  NULL";
        
        
         //$query = $this->db->query($sqlCheckTags);
        
       // if ($query->num_rows() > 0){
        
     //$sql = "UPDATE company_tags SET eff_to=  (CURRENT_DATE - INTERVAL '1 day') WHERE tag_id  IN (SELECT tag_id FROM company_tags WHERE tag_id=267 AND company_id=".$post['company_id']." AND eff_to IS  NULL)";
        
        //echo $sql;
       // $query = $this->db->query($sql);
        
            
        //}
        
        
        
        
    return $this->db->insert_id();  
        
        
        }
}
    
    
    
    function tagActionUpdater_($comp_id){ //NOT ACTIVE
        
              $data = array(
            'eff_to' => date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d')))),
            'updated_by' =>1,
            'updated_at' =>date('Y-m-d')
            );

$this->db->where('company_id', $comp_id);
 $this->db->where('tag_id', 267);       
$this->db->update('company_tags', $data); 
        
        
    }

function company_updated_to_customer($post){
 
    if(isset($post['initialfee']) && is_numeric($post['initialfee'])){
        $data = array(
        'initial_rate'  => (!empty($post['initialfee'])? $this->calIntRate($post['initialfee']):NULL)
            );
        $this->db->where('id', $post['company_id']);
        $this->db->update('companies', $data); 
        
    }
    $actiondata = array(
                'company_id'    => $post['company_id'],
                'user_id'       => $post['user_id'],
                'comments'      => 'Pipeline changed to Customer',
                'planned_at'    => (!empty($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
                'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
                'created_by'    => $post['user_id'],
                'action_type_id'=> '19',
                'actioned_at'   => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s'),
                );
    $query = $this->db->insert('actions', $actiondata);
    return $this->db->insert_id();
    
}

function company_updated_to_proposal($post)
{
    $actiondata = array(
        'company_id'    => $post['company_id'],
        'user_id'       => $post['user_id'],
        'comments'      => 'Pipeline changed to Proposal',
        'planned_at'    => (!empty($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'    => $post['user_id'],
        'action_type_id'=> '19',
        'actioned_at'   => date('Y-m-d H:i:s'),
        'created_at'    => date('Y-m-d H:i:s'),
         
        );

    $query = $this->db->insert('actions', $actiondata);

    
    
    
   
    
    
        return $this->db->insert_id();

}
    
function company_updated_to_action($post,$actionName)
{
    $actiondata = array(
        'company_id'    => $post['company_id'],
        'user_id'       => $post['user_id'],
        'comments'      => 'Pipeline changed to '.$actionName,
        'planned_at'    => (!empty($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'    => $post['user_id'],
        'action_type_id'=> '19',
        'actioned_at'   => date('Y-m-d H:i:s'),
        'created_at'    => date('Y-m-d H:i:s'),
        );

    $query = $this->db->insert('actions', $actiondata);
    return $this->db->insert_id();

}    
    
function add_to_zendesk($post)
{
        $company_id = $post['company_id'];
        $this->db->where('id', $company_id);
        $this->db->limit(1);
        $query = $this->db->get('companies');
    foreach ($query->result() as $row){
      $company_name= $row->name;
      $company_url= str_replace("http://"," ",str_replace("www.", "", $row->url));
    $company_registration= $row->registration;
    }
    $ch = curl_init();
    $username = 'dchapple@sonovate.com';
    $password = '25Million';
    curl_setopt($ch, CURLOPT_URL, "https://sonovate.zendesk.com/api/v2/organizations.json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $body = '{"organization": {"name": "'.$company_name.'","domain_names": ["'.$company_url.'"],"company_registration": ["'.$company_registration.'"]}}';

    curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Connection: Keep-Alive'
    ));
    $result=curl_exec($ch);
    $data = json_decode($result, true);
    $zendesk_id = $data["organization"]["id"]; // "John"
    if(!empty($zendesk_id)) {
        $data = array('zendesk_id' => $zendesk_id);
        $this->db->where('id', $company_id);
        $this->db->update('companies', $data); 
    }
    curl_close($ch);

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
    
  function calIntRate($number){
  
    
        $number =  $number /100;
        $number =  str_pad($number, 3, "0", STR_PAD_LEFT);
        
   
   return  $number;
    }
    
    function operations_store($comp_id,$user_id,$operation){
         $actiondata = array(
        'company_id'    => $comp_id,
        'user_id'       => $user_id,
        'operation' => $operation,
        'created_at'    => date('Y-m-d H:i:s'),
        );

    $query = $this->db->insert('views', $actiondata);
    return $this->db->insert_id();
        
        
    }
    
    function  operations_store_check($comp_id,$user_id,$operation){
        
        //$query = $this->db->query("SELECT   id  FROM operations WHERE user_id=".$user_id." AND company_id=".$comp_id."   LIMIT 1");
        
   $this->operations_store($comp_id,$user_id,$operation);
        
    }
    
     function  operations_store_get($user_id,$comp_id=0){
        //ops.user_id, c.id as comp_id, c.name 
     
        
         $query = $this->db->query("select T.company_id AS company,
C.name

from
(
select V.company_id,
row_number() OVER (PARTITION BY company_id order by V.created_at desc) \"rownum\",
V.created_at

from VIEWS V

where V.user_id = ".$user_id." -- ie current user

order by V.created_at desc
limit 50
) T

JOIN COMPANIES C
ON T.company_id = C.id

where \"rownum\" = 1

order by T.created_at desc

limit 16");
         
         
          
         
         

//echo $this->db->last_query();

//exit();
         
        /*
         
$query = $this->db->query("SELECT DISTINCT v.created_at,c.id as company,  c.name as name FROM views v 
LEFT JOIN companies c
ON v.company_id = c.id 
WHERE v.user_id = ".$user_id."
GROUP BY c.id,v.created_at
ORDER BY v.created_at DESC");
*/
             
         
            foreach ($query->result_array() as $row)
        {
            $comlist[$row['company']] =  $row['name'];
 
             if(count($comlist)=== 16)   break;
        }
       
         $i= 0;
         foreach($comlist as $key => $item){
             
             
             $comlister[$i++] = $key.'_'.$item;
             
             
         }
         
       $comlister =   array_splice($comlister, 1, 15);
             
             
             return   $comlister; 
             
               
    }
    
    
    
    function operations_store_delete($id){
      
        //echo $id;
        $this->db->where('id', $id);
        $this->db->delete('views');
        
     
        
        
    }
    
public function getActionsProposals($userID = 0){
        
    $sql = (' select T1.created_at::date "proposal",C.name,C.id,
    -- T1."comments",
           TT2.planned_at::date "planned",
           AT.name "action",
           TT2."by"

    from COMPANIES C

    JOIN
    (-- T1
    select A.company_id,
           A.created_at,
           A.comments,
           U.eff_from,
           U.name,
           U.id

    from ACTIONS A
    JOIN USERS U
    ON A.user_id = U.id

    where A.action_type_id = 8
    and user_id = '.$userID.'
    )   T1
    ON C.id = T1.company_id

    LEFT JOIN
    (-- TT2
    select company_id,
           planned_at,
           comments,
           action_type_id,
           "by"
    from 
    (-- T2
    select A.company_id,
           A.planned_at,
           A.comments,
           A.action_type_id,
           U.name "by",
           row_number() OVER (PARTITION BY company_id order by A.created_at desc) "rownum"

    from ACTIONS A
    JOIN USERS U
    ON A.created_by = U.id  

    where A.actioned_at is null
    )   T2
    where "rownum" = 1
    )   TT2
    ON C.id = TT2.company_id

    LEFT JOIN ACTION_TYPES AT
    ON TT2.action_type_id = AT.id

    where customer_from is null
    and (C.eff_to is null and active = \'t\')

    order by 1 desc') ;  
    
    
    $query = $this->db->query($sql);
       
    return   $query->result_array();    
    
    
    
}
    public function getActionsIntents($userID = 0){
    
 
        $sql = ('select T1.created_at::date "intent",C.name,C.id,
         -- T1."comments",
               TT2.planned_at::date "planned",
               AT.name "action",
               TT2."by"

        from COMPANIES C

        JOIN
        (-- T1
        select A.company_id,
               A.created_at,
               A.comments,
               U.eff_from,
               U.name,
               U.id

        from ACTIONS A
        JOIN USERS U
        ON A.user_id = U.id

        where A.action_type_id = 19
        and comments = \'Pipeline changed to Intent\' 
        and user_id = '.$userID.'
        )   T1
        ON C.id = T1.company_id

        LEFT JOIN
        (-- TT2
        select company_id,
               planned_at,
               comments,
               action_type_id,
               "by"
        from 
        (-- T2
        select A.company_id,
               A.planned_at,
               A.comments,
               A.action_type_id,
               U.name "by",
               row_number() OVER (PARTITION BY company_id order by A.created_at desc) "rownum"

        from ACTIONS A
        JOIN USERS U
        ON A.created_by = U.id  

        where A.actioned_at is null
        )   T2
        where "rownum" = 1
        )   TT2
        ON C.id = TT2.company_id

        LEFT JOIN ACTION_TYPES AT
        ON TT2.action_type_id = AT.id

       where customer_from is null
        and C.active = \'t\'
		and pipeline = \'Intent\'
        order by 1 desc
        ');
    

    $query = $this->db->query($sql);

    return   $query->result_array();    
    
    
    
}
    
    
    function getPods($id){
        
       /*
        $sql = ('SELECT DISTINCT  ct.company_id as id, ct.tag_id, com.created_at::date, com.name, ct.tag_id ,
 

 FROM company_tags ct  
 INNER JOIN actions ac 
ON ct.company_id = ac.company_id 
INNER JOIN companies com
ON  ct.company_id  = com.id
INNER JOIN action_types atp
ON  ac.action_type_id = atp.id
INNER JOIN users u 
ON ac.updated_by = u.id 
WHERE ct.company_id in (select   ctt.company_id from company_tags ctt  INNER JOIN actions  acc on  ctt.company_id = 
 acc.company_id WHERE ctt.tag_id in (200,201,202)  GROUP BY acc.company_id, ctt.company_id ,acc.updated_at ORDER BY acc.updated_at DESC
   
)  
AND ct.tag_id in (200,201,202)  
');
    

    $query = $this->db->query($sql);

    return   $query->result_array();  
        
        */

        
                $sql =  ' SELECT  ct.company_id as id, ct.tag_id, c.created_at::date, c.name , c.pipeline

                FROM companies c
                LEFT JOIN company_tags ct
                ON c.id= ct.company_id
               LEFT  JOIN tags t on ct.tag_id = t.id 
                WHERE  t.category_id  in (10)
                AND ct.eff_to is null
                ';     


                $query= $this->db->query($sql);

                $pp =  $query->result_array();  


                $i = 0;
                foreach($pp as $item => $value){

                //  $pp[$item]['action'] =  $this->getmore() ;
                // echo $value['compid'];
                $idval =   $this->getmore($value['id']) ;
                $idvalac =   $this->get_account_manager($value['id']) ;
                array_push($pp[$item],  array( 'last_action'=> $idval));
                     
//if($idvalac){
                    array_push($pp[$item],  array( 'account_manager' => $idvalac));
    
//}

                }
        
        return $pp;
        
        
    }
    
    
    function getmore($id){
      
        $query = $this->db->query('SELECT ac.company_id, ac.action_type_id, ac.updated_at::date as acudate, ac.updated_by, u.name as username, atp.name as actionname, ac.created_at::date as createdatac
        FROM actions ac
        LEFT JOIN action_types atp
        ON  ac.action_type_id = atp.id
        LEFT JOIN users u 
        ON ac.created_by = u.id 
        WHERE ac.company_id='.$id.' AND  ac.action_type_id !=19 order by ac.updated_at DESC , ac.id DESC  LIMIT 1' ) ;     
    
        return $query->result_array(); 
        
        
    }
    
    
    
    
    
  function actiondata($id){ // Checks created at of pipeline action 
      
   $sql = "SELECT id,created_at,action_type_id FROM actions WHERE company_id = ".intval($id)." AND action_type_id IN (16,32,34,8,31,11,19) ORDER BY created_at DESC";
   
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0)
    {
        foreach ($query->result_array() as $row)
        {
            if( $row['action_type_id']  == 16){
                $out = $row['created_at'];
                break;
            }else{
                $out =  $row['created_at'];   
            }
        }
        return $out;
    }
    
        return false;
    }   
    
    
    
    function changeActionDate($post,$userID){
        
        $completeddata = array(
          
            'user_id'       => $userID,
            'planned_at'    => $post['datechanger'],
    
        );
         $this->db->where('id', $post['id']);
    $query = $this->db->update('actions', $completeddata);
        
        
        
        return 'glen';
    }
    
    
    function get_account_manager($company_id)
    {

        $sql = "SELECT  ct.company_id as id, ct.tag_id, c.created_at::date, c.name, ct.tag_id, t.name
        FROM companies c
        LEFT JOIN company_tags ct
        ON c.id= ct.company_id
        AND ct.eff_to is null
        INNER JOIN tags t on t.id = ct.tag_id 
        and t.category_id = '10'
        and c.id= ".$company_id;
           $query = $this->db->query($sql);
           return $query->result_array()?  $query->result_array() : '';

    }
    
    function update_adjustments($post, $userid){

            $adjustments  = array(
              
               "updated_by" => $userid,
               "updated_at" => date('Y-m-d H:i:s'),
               "adjustment_type_id" =>$post['adjustment_type_id'],
               "invoice_id" => (isset($post['invoice_id'])?$post['invoice_id']:NULL),
               "remittance_id" => (isset($post['remittance_id'])?$post['remittance_id']:NULL),
               "currency" =>$post['currency'],
               "name" => (isset($post['cc_name'])?$post['cc_name']:NULL),
               "candidate" => (isset($post['candidate'])?$post['candidate']:NULL),
               "client" => (isset($post['f_client'])?$post['f_client']:NULL),
               "weekending" =>date('Y-m-d H:i:s'),
               "adjustment_amount" => $post['adjustment_amount'],
               "reason" => (isset($post['reason'])?$post['reason']:NULL),
               "change_details" =>(isset($post['change_details'])?$post['change_details']:NULL)

            );   
    
                 

       
        
        $this->db->where('action_id', $post['action_id']);
        $this->db->update('adjustments', $adjustments);
        
        return true;
        
    }
    
    
}
