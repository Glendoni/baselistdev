<?php
class Campaigns_model extends MY_Model {
	

	// GETS
	function get_all_shared_searches($user_id)
	{
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where_not_in('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->order_by("c.name", "asc");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_searches($user_id)
	{
		$this->db->select('name,id,user_id,shared');
		$this->db->from('campaigns');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->where("(eff_to IS NULL OR eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_shared_campaigns($user_id)
	{
		$this->db->distinct();
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared, c.created_at,c.evergreen_id');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		$this->db->join('targets t', 'c.id = t.campaign_id');
		$this->db->join('companies comp', 't.company_id = comp.id');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NULL', null, false);
		$this->db->where('u.active', 'True');
		$this->db->where('c.shared', 'True');
		$this->db->where('comp.active', 'True');
		$this->db->where_not_in('c.user_id', $user_id);
		$this->db->order_by("c.created_at", "desc");
		//$this->db->limit(20);
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$this->db->group_by("1,2,3,4,5");
				$this->db->limit(20);
 
		$query = $this->db->get();
		return $query->result();
	}

		function get_all_private_campaigns($user_id)
	{

				$this->db->distinct();
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared, c.created_at');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		$this->db->join('targets t', 'c.id = t.campaign_id');
		$this->db->join('companies comp', 't.company_id = comp.id');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NULL', null, false);
		$this->db->where('u.active', 'True');
		$this->db->where('c.shared', 'True');
		$this->db->where('comp.active', 'True');
		$this->db->where('c.user_id', $user_id);
		$this->db->order_by("c.created_at", "desc");
		//$this->db->limit(20);
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$this->db->group_by("1,2,3,4,5");
				$this->db->limit(20);
 
		$query = $this->db->get();
		return $query->result();

	}

	function get_campaigns_for_user($user_id)
	{
		$this->db->select('name,id,user_id');
		$this->db->from('campaigns');
		// Apply this to find campaigns
		//$this->db->where('criteria IS NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_campaign_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('campaigns');
		//$this->db->where('campaigns.criteria IS NULL', null, false);
		$this->db->where('campaigns.id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_companies_for_campaign_id($campaign_id,$pipeline)
	{

		if(!empty($pipeline)) { 
		$pipeline_sql =  "and pipeline ilike '$pipeline'";} else {$pipeline_sql ="";};
		// -- Data to Display a Company's details
		// IMPORTANT if you change/add colums on the following query then change the mapping array on the companies controller
		$sql = 'select json_agg(results)
		from (

		select row_to_json((
		       T1."JSON output",
		       T2."JSON output"
		       )) "company"
		from 
		(-- T1
		select C.id,
			   C.name,
			   C.pipeline,
			   U.id "owner_id",
			   TT5.actioned_at, -- f32
			   TT6.planned_at, -- f35
			   AU1.name "aname1",
			   AU2.name "aname2",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			   C.active, -- f9
			   C.created_at, -- f10
			   C.updated_at, -- f11
			   C.created_by,-- f12
			   C.updated_by,-- f13
			   C.registration, -- f14
		       TT1."turnover", -- f15
			   TT1."turnover_method",  -- f16
			   TT4.count,--f17
			   U.image , -- f18
			   C.class, -- f19
			   A.lat, -- f20
			   A.lng, -- f21
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f22
			   C.phone, -- f23 
			   C.pipeline, -- f24
			   CONT.contacts_count, -- f25
			   C.parent_registration, --f26
			   C.zendesk_id, -- f27
			   C.customer_from, -- f28
			   C.sonovate_id, -- f29
			   TT5.actioned_at, -- f30
			   ACT1.name, -- f31
			   AU1.name, -- f32
			   TT6.planned_at, -- f33
			   ACT2.name , -- f34
			   AU2.name, -- f35
			   C.trading_name, --f36
			   C.lead_source_id, --f37
			   C.source_date, --f38
			   pr.name, --f39
			   pr.id, --f40
			   C.source_explanation, --f41
			   UC.name, --f42
			   UU.name, --f43
               C.initial_rate, --f44
                C.customer_to --f45
			   )) "JSON output" 
			  

		from (select * from companies where eff_to IS NULL  '.$pipeline_sql.') C ';

		
		$sql = $sql.' JOIN ( select company_id from targets where campaign_id = '.$campaign_id.' ) company ON C.id = company.company_id';
		$sql = $sql.' LEFT JOIN 
		(-- TT1 
		select T.company_id "company id",
		       T.turnover "turnover",
		       T.method "turnover_method"       
		from 
		(-- T1
		select id "id",
		       company_id,
		       max(eff_from) OVER (PARTITION BY company_id) "max eff date"
		from TURNOVERS
		)   T1
		  
		JOIN TURNOVERS T
		ON T1.id = T.id
		  
		where T1."max eff date" = T.eff_from
		  
		  
		)   TT1
		ON TT1."company id" = C.id 

		LEFT JOIN 
		(-- TT4 
		select distinct E.company_id,
		E.count
		from 
		(-- T4
		select distinct id,
		company_id,
		max(created_at) OVER (PARTITION BY company_id) "max created_at date"
		from emp_counts
		)   T4
		JOIN EMP_COUNTS E
		ON T4.id = E.id 
		where T4."max created_at date" = E.created_at
		)   TT4
		ON TT4.company_id = C.id 

		LEFT JOIN
		(
		SELECT count(*) as "contacts_count",company_id FROM "contacts" group by contacts.company_id
		) CONT ON CONT.company_id = C.id
	
		LEFT JOIN 
		(-- TT5 LAST ACTION
		select distinct ac1.*
		from 
		(-- T5
		select distinct id,
		       company_id,
		       max(id) OVER (PARTITION BY company_id) "max id"
		from actions
		where action_type_id in (\'4\',\'5\',\'6\',\'8\',\'9\',\'10\',\'11\',\'12\',\'13\',\'17\',\'18\')
		and actioned_at is not null
		)   T5
		JOIN ACTIONS AC1
		ON T5.id = AC1.id 
		where T5."max id" = AC1.id
		)   TT5
		ON TT5.company_id = C.id

		LEFT JOIN 
 		action_types ACT1 on
 		TT5.action_type_id = ACT1.id

 		LEFT JOIN
 		companies pr
		ON C.parent_registration = pr.registration

		LEFT JOIN 
 		users UC on
 		uc.id = C.created_by

		LEFT JOIN 
 		users UU on
 		uu.id = C.updated_by

		LEFT JOIN 
 		users AU1 on
 		TT5.user_id = AU1.id

 		LEFT JOIN 
		(-- TT6 NEXT ACTION
		select distinct ac2.*
		from 
		(-- T6
		select distinct id,
		       company_id,
		       planned_at
		from actions
		where actioned_at is null and cancelled_at is null
		order by planned_at asc
		)   T6
		JOIN ACTIONS AC2
		ON T6.id = AC2.id 
		--where T6.id = AC2.id limit 1
		where T6.id = AC2.id
		)   TT6
		ON TT6.company_id = C.id
		
		LEFT JOIN 
 		action_types ACT2 on
 		TT6.action_type_id = ACT2.id

		LEFT JOIN 
 		users AU2 on
 		TT6.user_id = AU2.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector"       
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id


		LEFT JOIN 
		ADDRESSES A
		ON a.id = (select id from addresses where type ilike \'registered address\' and company_id = C.id limit 1)

		LEFT JOIN
		USERS U
		ON U.id = C.user_id


				 
		group by C.id,
		         C.name,
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
			    
			     C.active,
			     C.created_at,
			     C.updated_at,
			     C.created_by,
			     C.updated_by,
			     C.registration,
			     C.class,
			     C.phone,
			     C.pipeline,
			     C.parent_registration,	
			     U.id,
			     U.name,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     TT4.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from,
			     C.sonovate_id,
			     TT5.actioned_at,
			     ACT1.name,
			     AU1.name,
			     TT6.planned_at,
			     ACT2.name,
			     AU2.name,
			     C.trading_name,
				 C.lead_source_id,
			     C.source_date,
			     pr.name,
			     pr.id,
			     C.source_explanation,
			     UC.name, 
			     UU.name,
                  C.initial_rate,   
                 C.customer_to


		order by C.id 


		)   T1

		LEFT JOIN

		(-- T2
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type",  T."provider url", T."mortgage Inv_fin_related"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       P.url "provider url",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type",
                M.Inv_fin_related "mortgage Inv_fin_related"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 5, M.eff_from desc

		)   T

		group by T."company id"	

		order by T."company id"

		)   T2
		ON T1.id = T2."company id"
		-- insert this for sort order  
		order by 
		CASE when pipeline = \'Lost\' then 9
		when pipeline = \'Unsuitable\' then 10
		else 1
        END,
		actioned_at asc NULLS FIRST,case when pipeline = \'Customer\' then 1
		when pipeline = \'Proposal\' then 2
		when pipeline = \'Intent\' then 3
		when pipeline = \'Qualified\' then 4
		else 5
		end
		 
		) results';
		// print_r($sql);
		$query = $this->db->query($sql);

		return $query->result_array();
	}

    
    //  BETA PROTOTYE FOR campaign for data entry guys 
    	function get_companies_for_campaign_id_data_entry($campaign_id,$pipeline)
	{ 

		if(!empty($pipeline)) { 
		$pipeline_sql =  "and pipeline ilike '$pipeline'";} else {$pipeline_sql ="";};
		// -- Data to Display a Company's details
		// IMPORTANT if you change/add colums on the following query then change the mapping array on the companies controller
		$sql_ = 'select json_agg(results)
		from (

		select row_to_json((
		       T1."JSON output",
		       T2."JSON output"
		       )) "company"
		from 
		(-- T1
		select C.id,
			   C.name,
			   C.pipeline,
S."has sector",
TAGS."has DQ tag",
			   U.id "owner_id",
			   TT5.actioned_at, -- f32
			   TT6.planned_at, -- f35
			   AU1.name "aname1",
			   AU2.name "aname2",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			   C.active, -- f9
			   C.created_at, -- f10
			   C.updated_at, -- f11
			   C.created_by,-- f12
			   C.updated_by,-- f13
			   C.registration, -- f14
		       TT1."turnover", -- f15
			   TT1."turnover_method",  -- f16
			   TT4.count,--f17
			   U.image , -- f18
			   C.class, -- f19
			   A.lat, -- f20
			   A.lng, -- f21
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f22
			   C.phone, -- f23 
			   C.pipeline, -- f24
			   CONT.contacts_count, -- f25
			   C.parent_registration, --f26
			   C.zendesk_id, -- f27
			   C.customer_from, -- f28
			   C.sonovate_id, -- f29
			   TT5.actioned_at, -- f30
			   ACT1.name, -- f31
			   AU1.name, -- f32
			   TT6.planned_at, -- f33
			   ACT2.name , -- f34
			   AU2.name, -- f35
			   C.trading_name, --f36
			   C.lead_source_id, --f37
			   C.source_date, --f38
			   pr.name, --f39
			   pr.id, --f40
			   C.source_explanation, --f41
			   UC.name, --f42
			   UU.name, --f43
               C.initial_rate, --f44
                C.customer_to,--f45
               AM.name, --f46
			   C.confidential_flag, -- f47
               C.permanent_funding, -- f48
               C.staff_payroll, -- f49
               C.management_accounts, -- f50
               C.paye, -- f51
               C.permanent_invoicing -- f52
			   )) "JSON output" 
			  

		from (select * from companies where eff_to IS NULL  '.$pipeline_sql.') C ';

		
		$sql = $sql.' JOIN ( select company_id from targets where campaign_id = '.$campaign_id.' ) company ON C.id = company.company_id
        		LEFT JOIN
		(
			select distinct company_id "has sector"
		from OPERATES		  
		) S
		ON C.id = S."has sector"
		  
		LEFT JOIN
		(-- T2
		select distinct CT.company_id "has DQ tag"

		from COMPANY_TAGS CT

		JOIN TAGS T
		ON CT.tag_id = T.id

		where T.category_id = 18
		and   CT.eff_to is null
		)   TAGS
		ON C.id = TAGS."has DQ tag"
        
        ';
		$sql = $sql.' LEFT JOIN 
		(-- TT1 
		select T.company_id "company id",
		       T.turnover "turnover",
		       T.method "turnover_method"       
		from 
		(-- T1
		select id "id",
		       company_id,
		       max(eff_from) OVER (PARTITION BY company_id) "max eff date"
		from TURNOVERS
		)   T1
		  
		JOIN TURNOVERS T
		ON T1.id = T.id
		  
		where T1."max eff date" = T.eff_from
		  
		  
		)   TT1
		ON TT1."company id" = C.id 

		LEFT JOIN 
		(-- TT4 
		select distinct E.company_id,
		E.count
		from 
		(-- T4
		select distinct id,
		company_id,
		max(created_at) OVER (PARTITION BY company_id) "max created_at date"
		from emp_counts
		)   T4
		JOIN EMP_COUNTS E
		ON T4.id = E.id 
		where T4."max created_at date" = E.created_at
		)   TT4
		ON TT4.company_id = C.id 

		LEFT JOIN
		(
		SELECT count(*) as "contacts_count",company_id FROM "contacts" group by contacts.company_id
		) CONT ON CONT.company_id = C.id
	
		LEFT JOIN 
		(-- TT5 LAST ACTION
		select distinct ac1.*
		from 
		(-- T5
		select distinct id,
		       company_id,
		       max(id) OVER (PARTITION BY company_id) "max id"
		from actions
		where action_type_id in (\'4\',\'5\',\'6\',\'8\',\'9\',\'10\',\'11\',\'12\',\'13\',\'17\',\'18\')
		and actioned_at is not null
		)   T5
		JOIN ACTIONS AC1
		ON T5.id = AC1.id 
		where T5."max id" = AC1.id
		)   TT5
		ON TT5.company_id = C.id

		LEFT JOIN 
 		action_types ACT1 on
 		TT5.action_type_id = ACT1.id

 		LEFT JOIN
 		companies pr
		ON C.parent_registration = pr.registration

		LEFT JOIN 
 		users UC on
 		uc.id = C.created_by

		LEFT JOIN 
 		users UU on
 		uu.id = C.updated_by

		LEFT JOIN 
 		users AU1 on
 		TT5.user_id = AU1.id

 		LEFT JOIN 
		(-- TT6 NEXT ACTION
		select distinct ac2.*
		from 
		(-- T6
		select distinct id,
		       company_id,
		       planned_at
		from actions
		where actioned_at is null and cancelled_at is null
		order by planned_at asc
		)   T6
		JOIN ACTIONS AC2
		ON T6.id = AC2.id 
		--where T6.id = AC2.id limit 1
		where T6.id = AC2.id
		)   TT6
		ON TT6.company_id = C.id
		
		LEFT JOIN 
 		action_types ACT2 on
 		TT6.action_type_id = ACT2.id

		LEFT JOIN 
 		users AU2 on
 		TT6.user_id = AU2.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector"       
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id


		LEFT JOIN 
		ADDRESSES A
		ON a.id = (select id from addresses where type ilike \'registered address\' and company_id = C.id limit 1)

		LEFT JOIN
		USERS U
		ON U.id = C.user_id


				 
		group by C.id,
		         C.name,
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
"has sector",
 "has DQ tag",
			     C.active,
			     C.created_at,
			     C.updated_at,
			     C.created_by,
			     C.updated_by,
			     C.registration,
			     C.class,
			     C.phone,
			     C.pipeline,
			     C.parent_registration,	
			     U.id,
			     U.name,
                  U.image,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     TT4.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from,
			     C.sonovate_id,
			     TT5.actioned_at,
			     ACT1.name,
			     AU1.name,
			     TT6.planned_at,
			     ACT2.name,
			     AU2.name,
			     C.trading_name,
				 C.lead_source_id,
			     C.source_date,
			     pr.name,
			     pr.id,
			     C.source_explanation,
			     UC.name, 
			     UU.name,
                  C.initial_rate,   
                 C.customer_to


		order by C.id 


		)   T1

		LEFT JOIN

		(-- T2
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type",  T."provider url", T."mortgage Inv_fin_related"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       P.url "provider url",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type",
                M.Inv_fin_related "mortgage Inv_fin_related"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 5, M.eff_from desc

		)   T

		group by T."company id"	

		order by T."company id"

		)   T2
		ON T1.id = T2."company id"
		-- insert this for sort order  
		order by 
		CASE
		   when "has sector" is null and "has DQ tag" is null then 1	    
		   else 1000
		END
		 
		) results';

            
            
$sql = 'select json_agg(results)
		from (

		select row_to_json((
		       T1."JSON output",
		       T2."JSON output",
               T3."JSON output"
		       )) "company"
		from 
		(-- T1 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		select C.id,
			   C.name,
			   C.pipeline,
               TARGETS.created_at "target created",
			   U.id "owner_id",
			   TT5.actioned_at, -- f32
			   TT6.planned_at, -- f35
			   AU1.name "aname1",
			   AU2.name "aname2",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			   C.active, -- f9
			   C.created_at, -- f10
			   C.updated_at, -- f11
			   C.created_by,-- f12
			   C.updated_by,-- f13
			   C.registration, -- f14
		       TT1."turnover", -- f15
			   TT1."turnover_method",  -- f16
			   TT4.count,--f17
			   U.image , -- f18
			   C.class, -- f19
			   A.lat, -- f20
			   A.lng, -- f21
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f22
			   C.phone, -- f23 
			   C.pipeline, -- f24
			   CONT.contacts_count, -- f25
			   C.parent_registration, --f26
			   C.zendesk_id, -- f27
			   C.customer_from, -- f28
			   C.sonovate_id, -- f29
			   TT5.actioned_at, -- f30
			   ACT1.name, -- f31
			   AU1.name, -- f32
			   TT6.planned_at, -- f33
			   ACT2.name , -- f34
			   AU2.name, -- f35
			   C.trading_name, --f36
			   C.lead_source_id, --f37
			   C.source_date, --f38
			   pr.name, --f39
			   pr.id, --f40
			   C.source_explanation, --f41
			   UC.name, --f42
			   UU.name, --f43
               C.initial_rate, --f44
             C.customer_to,--f45
               C.name, --f46
			   C.confidential_flag, -- f47
               C.permanent_funding, -- f48
               C.staff_payroll, -- f49
               C.management_accounts, -- f50
               C.paye, -- f51
               C.permanent_invoicing -- f52
               
			   )) "JSON output" 
			  
		from (select * from companies where active = \'t\') C  
		  
		JOIN 
		(select company_id,
		        created_at
		from TARGETS 
		where campaign_id = '.$campaign_id.' ) TARGETS  -- Hack to list companies for a campaign - remove in Baselist Code
		ON C.id = TARGETS.company_id                                            -- 
	  
		LEFT JOIN 
		(-- TT1 
		select T.company_id "company id",
		       T.turnover "turnover",
		       T.method "turnover_method"       
		from 
		(-- T1
		select id "id",
		       company_id,
		       max(eff_from) OVER (PARTITION BY company_id) "max eff date"
		from TURNOVERS
		)   T1
		  
		JOIN TURNOVERS T
		ON T1.id = T.id
		  
		where T1."max eff date" = T.eff_from	  
		)   TT1
		ON TT1."company id" = C.id 

		LEFT JOIN 
		(-- TT4 
		select distinct E.company_id,
		                E.count
		from 
		(-- T4
		select distinct id,
		company_id,
		max(created_at) OVER (PARTITION BY company_id) "max created_at date"
		from emp_counts
		)   T4
		JOIN EMP_COUNTS E
		ON T4.id = E.id 
		where T4."max created_at date" = E.created_at
		)   TT4
		ON TT4.company_id = C.id 

		LEFT JOIN
		(
		SELECT count(*) "contacts_count",
		       company_id FROM "contacts" 
		group by contacts.company_id
		) CONT 
		ON CONT.company_id = C.id
	
		LEFT JOIN 
		(-- TT5 LAST ACTION
		select distinct ac1.*
		from 
		(-- T5
		select distinct id,
		       company_id,
		       max(id) OVER (PARTITION BY company_id) "max id"
		from actions
		where action_type_id in (\'4\',\'5\',\'6\',\'8\',\'9\',\'10\',\'11\',\'12\',\'13\',\'17\',\'18\')
		and actioned_at is not null
		)   T5
		JOIN ACTIONS AC1
		ON T5.id = AC1.id 
		where T5."max id" = AC1.id
		)   TT5
		ON TT5.company_id = C.id

		LEFT JOIN 
 		ACTION_TYPES ACT1
 		ON TT5.action_type_id = ACT1.id

 		LEFT JOIN
 		COMPANIES PR
		ON C.parent_registration = PR.registration

		LEFT JOIN 
 		USERS UC
 		ON UC.id = C.created_by

		LEFT JOIN 
 		USERS UU
 		ON uu.id = C.updated_by

		LEFT JOIN 
 		USERS AU1
 		ON TT5.user_id = AU1.id

 		LEFT JOIN 
		(-- TT6 NEXT ACTION
		select distinct AC2.*
		from 
		(-- T6
		select distinct id,
		       company_id,
		       planned_at
		from ACTIONS
		where actioned_at is null 
		and cancelled_at is null
		)   T6
		JOIN ACTIONS AC2
		ON T6.id = AC2.id 
		where T6.id = AC2.id
		)   TT6
		ON TT6.company_id = C.id
		
		LEFT JOIN 
 		ACTION_TYPES ACT2 on
 		TT6.action_type_id = ACT2.id

		LEFT JOIN 
 		USERS AU2 on
 		TT6.user_id = AU2.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector"       
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id

		LEFT JOIN 
		ADDRESSES A
		ON a.id = (select id from addresses where type ilike \'registered address\' and company_id = C.id limit 1)

		LEFT JOIN
		USERS U
		ON U.id = C.user_id
				 
		group by C.id,
		         C.name,
                 C.confidential_flag,
                 C.permanent_funding, 
                 C.staff_payroll, 
                 C.management_accounts,
                 C.paye, 
                 C.permanent_invoicing, 
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
                 TARGETS.created_at,
			     C.active,
			     C.created_at,
			     C.updated_at,
			     C.created_by,
			     C.updated_by,
			     C.registration,
			     C.class,
			     C.phone,
			     C.pipeline,
			     C.parent_registration,	
			     U.id,
			     U.name,
		  		 U.image,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     TT4.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from,
			     C.sonovate_id,
			     TT5.actioned_at,
			     ACT1.name,
			     AU1.name,
			     TT6.planned_at,
			     ACT2.name,
			     AU2.name,
			     C.trading_name,
				 C.lead_source_id,
			     C.source_date,
			     pr.name,
			     pr.id,
			     C.source_explanation,
			     UC.name, 
			     UU.name,
                  C.initial_rate,   
                 C.customer_to

		order by C.id 

		)   T1 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------

		LEFT JOIN

		(-- T2 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type",  T."provider url", T."mortgage Inv_fin_related"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       P.url "provider url",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type",
                M.Inv_fin_related "mortgage Inv_fin_related"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 5, M.eff_from desc

		)   T

		group by T."company id"	

		order by T."company id"

		)   T2 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		ON T1.id = T2."company id"
        
        	LEFT JOIN

		(-- T3
		select ct."company id",
		       json_agg(
			   row_to_json(
			   row ( ct."category name",ct."tag id", ct."tag name", ct."added by", ct."created_at"))) "JSON output"  -- f46
				 
		from 
		(-- CT
			select ct.company_id "company id",
		       tc.sequence,
		       t.name "tag name",
		       ct.id "tag id",
		       tc.id,
		       tc.name "category name",
		       u.name "added by",  
               t.created_at "created_at"  
		FROM company_tags ct
        LEFT JOIN tags t
        ON ct.tag_id= t.id
        LEFT JOIN tag_categories tc
        ON t.category_id = tc.id
        LEFT JOIN users u
        ON ct.created_by = u.id
		WHERE
        ct.eff_to IS NULL 
        AND t.eff_to IS NULL
        ORDER BY tc.id asc, t.created_at asc


		)   ct

		group by CT."company id"	

		order by CT."company id"

		)   T3
		ON T1.id = T3."company id"
 
		order by "target created"desc
		 
		) results';
            
           
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
    
    
	function get_saved_searched_by_id($id)
	{
	$sql = "select U.name, U.id as user, U.image, 
				sum(case when action_type_id = '4' AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5' or action_type_id = '11' or action_type_id = '17')  AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) proposals,
		    	sum(case when action_type_id = '25' AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) duediligence,
		    	sum(case when action_type_id = '22' AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) key_review_added,
		    	sum(case when action_type_id = '22' AND a.planned_at > '$start_date_month' AND a.planned_at < '$end_date_month' then 1 else 0 end) key_review_occuring,
		    	Sum(CASE WHEN action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' THEN 1 ELSE 0 END) AS pipelinecount 
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null and u.department = 'sales' group by U.name, U.id order by deals desc, meetingbooked desc, introcall desc,  name desc";
		$query = $this->db->query($sql);
		if($query){
			return $query->result_array();
		}else{
			return [];
		}
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
		//$data['criteria'] =  serialize($post);
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

		function get_campaigns($company_id)
	{
		$this->db->select('campaigns.id,campaigns.name as "campaign_name", users.name, campaigns.created_at,campaigns.evergreen_id');
		$this->db->distinct();
		$this->db->join('campaigns', 'campaigns.id = targets.campaign_id', 'left');
		$this->db->join('users', 'users.id = campaigns.created_by', 'left');
		$this->db->where('campaigns.eff_to', NULL);
		$this->db->order_by('campaigns.created_at', 'desc'); 
		$query = $this->db->get_where('targets',array('company_id'=>$company_id));	
		return $query->result();
	}

function get_campaign_pipeline($id,$private=false)
	{
$sql = "select campaign_id ,campaignname,datecreated,\"campaign name\",
description,
image,
\"created\",
campaign_total,
\"%\" contacted,
campaign_prospects,
campaign_intent,
campaign_proposals,
campaign_customers,
campaign_unsuitable,
T2.\"emails\" as emails,
T2.\"distinct companies emailed\" as companies_emailed,
round(100 * T2.\"distinct companies emailed\"::numeric / campaign_total::numeric) \"% support\"
from
(
select C.id,
C.id campaign_id,
C.created_at::date \"created\",
U.image image,
C.name \"campaign name\" ,
C.name \"campaignname\" ,
C.created_at \"datecreated\",
C.description description ,
count(distinct T.company_id) campaign_total,
 CASE when count(distinct CASE when CO.pipeline <> 'Unsuitable' then CO.id END) = 0 
  then 0
  else 
  round (100 * count(distinct (CASE when A.created_at > C.created_at AND CO.pipeline <> 'Unsuitable' 
  then A.company_id else null END ))::numeric/count(distinct CASE when CO.pipeline <> 'Unsuitable' then CO.id END)::numeric) END \"%\",
CASE when count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) END campaign_prospects,
CASE when count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) END campaign_intent,
CASE when count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END)  END campaign_proposals,
	CASE when count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END)  END campaign_unsuitable,
CASE when count(distinct CASE when CO.pipeline ilike 'Customer' and CO.customer_from > C.created_at then CO.id END) = 0 then 0
else count(distinct 
CASE when CO.pipeline = 'Customer' and CO.customer_from > C.created_at then CO.id END) END campaign_customers
FROM   CAMPAIGNS C
JOIN USERS U
ON C.user_id = U.id
LEFT JOIN TARGETS T
ON C.id = T.campaign_id
INNER JOIN COMPANIES CO
ON T.company_id = CO.id
LEFT JOIN 
(
select *
from ACTIONS 
where (action_type_id in ('4','5','8','9','10','16','17','18','23','6')) 
  or (action_type_id in ('11','12','13','14','15') 
	  and actioned_at is not null and cancelled_at is null)
)   A
on CO.id = A.company_id
where C.id = '$id' and CO.active = 't'
group by 1,2,3,4
order by 2, 1 desc
)   T1
LEFT JOIN
(
select CA.id,
count(*) \"emails\",
count(distinct C.company_id) \"distinct companies emailed\"
from EMAIL_CAMPAIGNS EC
LEFT JOIN EMAIL_ACTIONS EA
ON EC.id = EA.email_campaign_id
JOIN CONTACTS C
ON EA.contact_id = C.id
JOIN TARGETS T
ON C.company_id = T.company_id
JOIN CAMPAIGNS CA
ON T.campaign_id = CA.id
where 
EC.created_at > C.created_at
group by 1
)   T2
ON T1.id = T2.id
order by 3 desc";
    
    
		$query = $this->db->query($sql);
    
    
    if($private){
		
          $row = $query->row(); 
              return $row;
    }else{
       return $query->result(); /* returns an object */
    return $row;
    }
    
    
}

function get_user_campaigns($user_id)
	{
$sql = "select campaign_total,
campaign_prospects,
campaign_intent,
campaign_proposals,
campaign_customers,
campaign_unsuitable,
\"%\" contacted,
campaign_lost
from
(
select 
count(distinct T.company_id) campaign_total,
case when 
count(distinct (CASE when A.created_at > C.created_at AND CO.pipeline <> 'Unsuitable' then A.company_id else null END ))::numeric = 0 then 0 
else
round (100 * count(distinct (CASE when A.created_at > C.created_at AND CO.pipeline <> 'Unsuitable' then A.company_id else null END ))::numeric  / CASE when count( CASE when CO.pipeline <> 'Unsuitable' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline <> 'Unsuitable' then CO.id END) END::numeric) end AS \"%\",
CASE when count(distinct CASE when CO.pipeline ilike 'Lost' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Lost' then CO.id END) END campaign_lost,
CASE when count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) END campaign_prospects,
CASE when count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) END campaign_intent,
CASE when count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END)  END campaign_proposals,
	CASE when count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END)  END campaign_unsuitable,
CASE when count(distinct CASE when CO.pipeline ilike 'Customer' and CO.customer_from > C.created_at then CO.id END) = 0 then 0
else count(distinct 
CASE when CO.pipeline = 'Customer' and CO.customer_from > C.created_at then CO.id END) END campaign_customers
FROM   CAMPAIGNS C
JOIN USERS U
ON C.user_id = U.id
LEFT JOIN TARGETS T
ON C.id = T.campaign_id
INNER JOIN COMPANIES CO
ON T.company_id = CO.id
LEFT JOIN 
(
select *
from ACTIONS 
where (action_type_id in ('4','5','8','9','10','16','17','18','23','6')) 
  or (action_type_id in ('11','12','13','14','15') 
	  and actioned_at is not null and cancelled_at is null)
)   A
on CO.id = A.company_id
where C.user_id = '$user_id' and CO.active = 't' and c.eff_to is null
order by 2, 1 desc
)   T1";
		echo $query = $this->db->query($sql);
		    return $query->result(); /* returns an object */
}

function get_team_campaigns()
	{
$sql = "select userimage,
campaign_total,
campaign_prospects,
campaign_intent,
campaign_proposals,
campaign_customers,
campaign_unsuitable,
campaign_lost,
\"%\" contacted
from
(
select 
u.image userimage,
count(distinct T.company_id) campaign_total,
case when 
count(distinct (CASE when A.created_at > C.created_at AND CO.pipeline <> 'Unsuitable' then A.company_id else null END ))::numeric = 0 then 0 
else
round (100 * count(distinct (CASE when A.created_at > C.created_at AND CO.pipeline <> 'Unsuitable' then A.company_id else null END ))::numeric  / CASE when count( CASE when CO.pipeline <> 'Unsuitable' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline <> 'Unsuitable' then CO.id END) END::numeric) end AS \"%\",
CASE when count(distinct CASE when CO.pipeline ilike 'Lost' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Lost' then CO.id END) END campaign_lost,
CASE when count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Prospect' then CO.id END) END campaign_prospects,
CASE when count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) = 0 then 0 
else count(distinct CASE when CO.pipeline ilike 'Intent' then CO.id END) END campaign_intent,
CASE when count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Proposal' then CO.id END)  END campaign_proposals,
	CASE when count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END) = 0 then 0
else count(distinct CASE when CO.pipeline ilike 'Unsuitable' then CO.id END)  END campaign_unsuitable,
CASE when count(distinct CASE when CO.pipeline ilike 'Customer' and CO.customer_from > C.created_at then CO.id END) = 0 then 0
else count(distinct 
CASE when CO.pipeline = 'Customer' and CO.customer_from > C.created_at then CO.id END) END campaign_customers
FROM   CAMPAIGNS C
JOIN USERS U
ON C.user_id = U.id
LEFT JOIN TARGETS T
ON C.id = T.campaign_id
INNER JOIN COMPANIES CO
ON T.company_id = CO.id
LEFT JOIN 
(
select *
from ACTIONS 
where (action_type_id in ('4','5','8','9','10','16','17','18','23','6')) 
  or (action_type_id in ('11','12','13','14','15') 
	  and actioned_at is not null and cancelled_at is null)
)   A
on CO.id = A.company_id
where CO.active = 't' and u.active = 'true' and u.department = 'sales' and c.eff_to is null
group by 1
order by 2 desc
)   T1";
$query = $this->db->query($sql);
		if($query){
			return $query->result_array();
		}else{
			return [];
		}
}


function get_campaign_owner($id)
	{
	$sql = "select u.image, u.name as \"username\"
				from campaigns CP
				LEFT JOIN users u
				on CP.user_id = u.id
				where CP.id = $id group by 1,2 limit 1";
		$query = $this->db->query($sql);
		    return $query->result(); /* returns an object */
}
    
    
         function private_campaigns_new($user_id)
	{
			$this->db->distinct();
		$this->db->select('c.name,c.id as id,c.user_id as userid,u.name as searchcreatedby,u.image as image,c.shared, c.created_at as datecreated');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		$this->db->join('targets t', 'c.id = t.campaign_id');
		$this->db->join('companies comp', 't.company_id = comp.id');
		// Apply this to find saved searches only
		//$this->db->where('criteria IS NULL', null, false);
		$this->db->where('u.active', 'True');
		//$this->db->where('c.shared', 'True');
		$this->db->where('comp.active', 'True');
		$this->db->where('c.user_id', $user_id);		
		$this->db->order_by("c.created_at", "desc");
		//$this->db->limit(20);
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$this->db->group_by("1,2,3,4,5");
				$this->db->limit(20);
 
		$query = $this->db->get();
             
             
             //$this->db->last_query();
		//print_r($query->result());
             
               return $query->result();          
            
}
    
    
    function private_campaigns_new_ajax($user_id,$department){  
        
        
        $datauser= '';
        if($department == 'data'){
      $datauser =   "AND c.evergreen_id is null";
        }

	 $sql = 'SELECT DISTINCT "c"."name", "c"."id" as "id", "c"."user_id" as "userid", "u"."name" as "searchcreatedby", "u"."image" as "image", "c"."shared", "c"."created_at", to_char(c.created_at, \'dd-mm-yyyy\') as datecreated  FROM "campaigns" "c" JOIN "users" "u" ON "c"."user_id" = "u"."id" JOIN "targets" "t" ON "c"."id" = "t"."campaign_id" JOIN "companies" "comp" ON "t"."company_id" = "comp"."id" WHERE  "u"."active" = E\'True\' AND "comp"."active" = E\'True\' AND "c"."user_id" = E\''.$user_id.'\' AND (c.eff_to IS NULL OR c.eff_to > \''.date('Y-m-d').'\') '.$datauser.' AND c.evergreen_id IS NULL GROUP BY 1, 2, 3, 4, 5 ORDER BY "c"."created_at" DESC LIMIT 20' ;
             
        
    
        	$query = $this->db->query($sql);
             
        
      
		    return $query->result(); /* returns an object */
            //echo  $this->db->last_query();
          
}
    
    
    function getCampaignOwner($campaignID){
        
      $sql = 'SELECT U.department as campaignOwnerType, cam.created_by as campaignowner  FROM campaigns cam
LEFT JOIN users as U 
ON cam.user_id = U.id
WHERE cam.id='.$campaignID.'
LIMIt 1' ;
             
        
    
        	$query = $this->db->query($sql);
             
        
      
		    return $query->result();   
        
        
    }

}