<?php
class Csv_model extends CI_Model {

 

    function bill(){
        
        echo 'wew';
        
    }
    
    
public function csvreader() 
	{
    
    return 'Glen';
        // path where your CSV file is located
            define('CSV_PATH','');
        // Name of your CSV file
           $file_exists_check = file_exists("companies.csv");
           if($file_exists_check){
                $csv_file = CSV_PATH . "companies.csv"; 
                if (($handle = fopen($csv_file, "r")) !== FALSE) {
                    fgetcsv($handle);   
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        for ($c=0; $c < $num; $c++) {
                            $col[$c] = $data[$c];
                        }

                        $col1 = $col[0]; //name =  company name
                        $col2 = $col[1]; //registration  =  company id
                        $col3 =  str_replace(',', '',$col[2].' '.$col[3].' '.$col[5].' '.$col[6]); //address = full address
                        $col4 = $col[7];
                        $reformated_time = explode('/', $col[8]);
                        $time = $reformated_time[1].'/'.$reformated_time[0].'/'.$reformated_time[2];       
                        $eff_from = date("Y-m-d", strtotime($time)) ? date("Y-m-d", strtotime($time)) : NULL;
                        $post = array(
                            'name' => $col1,
                            'registration' =>  $col2,
                            'address' => $col3,
                            'date_of_creation' =>$eff_from  
                        );
                        if($col[7] == 'Active'){
                            $compID = $this->Companies_model->create_company_from_CH($post,1); 
                       
                            //echo '<hr />';

                        //echo $col[8] . '' . $col[1].' '.$col3.' <br>';
                        }
                    }
                  
                    fclose($handle);
                }
                echo "File data successfully imported to database!!";
           }else{
            echo "Cannot find companies.csv file!!";   
           }
    }
    

    function getCompanyHouseChargesApi($id,$compID,$debug)
    {
        
       // return  $id;
       //echo  substr("abcdef", 1, 6);
      //  echo ltrim($id, '0');
        $url = "https://api.companieshouse.gov.uk/company/".$id."/charges";
       // echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json;',
            'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo='
          ]
        );
         
            $result = curl_exec($ch);
        // Check for errors
        if($result === FALSE){

          die(curl_errno($ch).': '.curl_error($ch));
        }

       $output =  json_decode($result,TRUE);
        $rtnOutput =$output;
        if(is_array($output)){
           
                    $i = $output['items'] ;
            foreach($i as $item => $value){
            //    echo  'I am will now check run morgages<br>' ;
                $runMorgageCheck = $this->runMorgageCheck($value['etag']);
                       if($runMorgageCheck){
                          
                              $output = array(
                                'company_id' => $compID,
                                'provider_str' =>   $value['persons_entitled'][0]['name'],
                                'etag' => $value['etag'],  
                                'stage' => $value['status'],    
                                'eff_from' => $value['transactions'][0]['delivered_on'], 
                                'created_by' => 1 
                              );
                           //send querry to model for futhur checking
                          //echo $output['ref'];
                           $this->Companies_model->insert_charges_CSV($output);
                   
               // echo  $output['company_id'];
                // $this->Companies_model->insert_charges_CSV($output);
                // echo $id .'<br>';
               //echo   $value['persons_entitled'][0]['name']. '<br>'. $value['etag'].'<br>';  //prividers_id
               //echo $value['etag'].'<br>'; //ref
               //echo $value['status'].'<br>'; //stage
               //echo $value['transactions'][0]['delivered_on'].'<br>'; //eff_from
               //echo  '<br><br>';//
                           if($debug){
                        print_r($rtnOutput); 
                               echo '<br>';
                           }
                             return true;
                       } 
           }
        }
        return false; 
    }
    
    function ipp($lmt = 100 ,$oft= 0, $debug = false)
    {
        
        $sql = "SELECT registration,id FROM companies WHERE  created_at >= '".date('Y-m-d')."' ORDER BY id LIMIT ".$lmt."  OFFSET ".$oft."   ";
    $query = $this->db->query($sql);
         if($debug) echo $sql.'<br>';
            if($debug) 'Number of rows being checked - '.  $query->num_rows();
          foreach ($query->result_array() as $row)
          {          
             if($debug) echo $row['registration'].' ' .$row['id'] .'  - <br> ';
           $this->getCompanyHouseChargesApi($row['registration'],$row['id'],$debug)  ;
          } 
         if($debug) echo 'Query has finished<br>';
          echo "<h2>Update to table completed!!</h2>";
        //unlink('companies.csv');
    }
    
    
 function runMorgageCheck($ref)
 {
     $sql = "SELECT ref FROM mortgages WHERE ref='".$ref."' ";
     //echo $sql;
     $query = $this->db->query($sql);
         $rownum  =     $query->num_rows();
     if($rownum){
         return  false;
     }else{
         
         return true ;
     }
 }
    
     public function insert_charges_CH($response, $company_id,$user_id)
    {
           
        $this->load->helper('inflector');
        $provider  = '';
        $provider = $response['items'][0]['persons_entitled'][0]['name'];
         $provider_id = $this->providerCheck($provider);
    
        if($provider_id){
            $mortgages = array(
                    'company_id' => $company_id,
                    'provider_id' => $provider_id,
                    'ref' => $response['items'][0]['etag'],
                    'stage' =>  $response['items'][0]['status'],
                    'eff_from' => $response['items'][0]['transactions'][0]['delivered_on'],
                    'created_at' =>   date('Y-m-d'),	
                    'created_by' => $user_id

                    );
                $this->db->insert('mortgages', $mortgages);
        }        
             
    }
    
       public function providerCheck($name)
    {
        
        //$name = 'ABN AMRO COMMERCIAL FINANCE PLC';
        
        $q = '
         SELECT id,name,provider_id
         FROM provider_checks
         WHERE name ilike \''.$name.'\'
         LIMIT 1
        ';
        $result = $this->db->query($q);
            $last = $this->db->last_query();
         //file_put_contents('pop.txt', $last.PHP_EOL, FILE_APPEND);
        
        
              if( $result->num_rows()){
                   foreach ($result->result() as $row)
                    {
                        return $row->provider_id;
                    } 
             }else{
                  return false;
            }
    }
}