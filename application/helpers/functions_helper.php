<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    
    // -----------------------------------------------------------------------------
    //check auth
    if (!function_exists('auth_check')) {
        function auth_check()
        {
            // Get a reference to the controller object
            $ci =& get_instance();
            if(!$ci->session->has_userdata('is_admin_login'))
            {
                $ci->session->set_userdata('redirect_to', current_url());
                redirect('admin/auth/login', 'refresh');
            }
        }
    }

    if (!function_exists('slugged')) {
        function slugged($string)
        {
            $slug = strtolower(trim($string));
            $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
            $slug = preg_replace('/-+/', '-', $slug);
            return $slug;
        }
    }



    if (! function_exists('resizeImage')) {
        function resizeImage($filelocation = "", $target_path = "", $width = "", $height = "") {
            $CI =&  get_instance();
            $CI->load->database();
            
            if($width == ""){
                $width = 200;
            }

            if($height == ""){
                $maintain_ratio = TRUE;
            }else{
                $maintain_ratio = FALSE;
            }

            $config_manip = array(
                'image_library' => 'gd2',
                'source_image' => $filelocation,
                'new_image' => $target_path,
                'maintain_ratio' => $maintain_ratio,
                'create_thumb' => TRUE,
                'thumb_marker' => '_thumb',
                'width' => $width,
                'height' => $height
            );
            $CI->load->library('image_lib', $config_manip);

            if ($CI->image_lib->resize()) {
                return true;
            }else{
                $CI->image_lib->display_errors();
                return false;
            }
            $CI->image_lib->clear();
       }
    }


  if (!function_exists('nameofuser')) {
            function nameofuser($id) {
                $ci =& get_instance();
                $q = $ci->db->get_where('users', array('admin_id'=>$id), 1);
                if( $q->num_rows() > 0 ) {
                    $user =  $q->row();
                    $name = ucfirst($user->lastname).' '.ucfirst($user->firstname); 
                    return $name;
                }else{
                    return 'Anonymous';
                }
                
            }
        }



    // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings()
        {
            $ci =& get_instance();
            $ci->load->model('admin/setting_model');
            return $ci->setting_model->get_general_settings();
        }
    }

    if (!function_exists('getSettings')) {
        function getSettings(){
            $ci =& get_instance();
            return $ci->setting_model->getSettings();
        }
    }

  if (!function_exists('getRecentMembers')) {

        function getRecentMembers($offset,$limit){
            $ci =& get_instance();
            return $ci->Membership_model->getRecentMembers($offset,$limit);
            
        }

  }


  if (!function_exists('getRecentProjects')) {

        function getRecentProjects($offset,$limit){
            $ci =& get_instance();
            return $ci->Project_model->getRecentProjects($offset,$limit);
            
        }

  }

  


  if (!function_exists('getRecentGroups')) {

        function getRecentGroups($offset,$limit){
            $ci =& get_instance();
            return $ci->Membership_model->getRecentGroups($offset,$limit);
            
        }

  }
     if (!function_exists('countwhere')) {
    
        function countwhere($table, $where = array()) {
            $ci =& get_instance();
            if($table){
                $ci->db->where($where);
                return $ci->db->count_all_results($table);
            } else {
                return $ci->db->count_all($table);
            }
        }
 }

 if (!function_exists('countcomments')) {
     function countcomments($postid){   
        $totalcomments = countwhere('postreactions', array('postid' => $postid, 'type' => 'comment','approvalstatus' => 'approved' ));
        if (empty($totalcomments)) {
            return 0;
        }else{
            return $totalcomments;
        }
     }
 }

  if (!function_exists('getloggedinuserdata')) {
        function getloggedinuserdata() {
            $ci =& get_instance();
            $q = $ci->db->get_where('users', array('admin_id' => $ci->session->userdata('id')), 1);
            if( $q->num_rows() > 0 ) {
                return $q->row();
            }
            return FALSE;
        }
    }   


     // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Sub Menu
    if (!function_exists('get_sidebar_sub_menu')) {
        function get_sidebar_sub_menu($parent_id)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->where('parent',$parent_id);
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('sub_module')->result_array();
        }
    }


    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Menu
    if (!function_exists('get_sidebar_menu')) {
        function get_sidebar_menu()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('module')->result_array();
        }
    }

     // -----------------------------------------------------------------------------
    // Make Slug Function    
    if (!function_exists('make_slug'))
    {
        function make_slug($string)
        {
            $lower_case_string = strtolower($string);
            $string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $lower_case_string);
            return strtolower(preg_replace('/\s+/', '-', $string1));        
        }
    }

    if (!function_exists('prettyprint')) {
        function prettyprint($var) { print '<pre>'; print_r($var); print '</pre>'; }

    }


    // -----------------------------------------------------------------------------
    //get recaptcha
    if (!function_exists('generate_recaptcha')) {
        function generate_recaptcha()
        {
            $ci =& get_instance();
            if ($ci->recaptcha_status) {
                $ci->load->library('recaptcha');
                echo '<div class="form-group mt-2">';
                echo $ci->recaptcha->getWidget();
                echo $ci->recaptcha->getScriptTag();
                echo ' </div>';
            }
        }
    }


     if (!function_exists('time_elapsed')) {
         function time_elapsed($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);
            
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
            
            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }
            
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
    }
    

    
    if (!function_exists('formatDateNoTime')) {
        function formatDateNoTime($date){
            if (empty($date)) {
                return "";
            }else{
                return date("j M Y",strtotime($date));
            }
        }
    }

   if (!function_exists('formatMoney')) {
        function formatMoney($number, $decimals = 2, $currency = null) {  
             $ci =& get_instance();
            $formattedNumber = $number;
            
            // Check if the number is an integer, if so, set decimals to 0
            if (intval($number) == $number) {
                $decimals = 0;
            }
            
            // Format the number with the specified decimals
            $formattedNumber = number_format($number, $decimals, '.', ',');
            
            // Concatenate the currency symbol if provided
            return $currency ? $currency . $formattedNumber : $formattedNumber;
        }
    }


    if (!function_exists('getalldatawhere')) {
        function getalldatawhere($table, $wherearray = array(), $orderbyfield = null, $orderbydirection = null) {
            $ci =& get_instance(); 
            if ($orderbyfield) {
                $ci->db->order_by($orderbyfield, $orderbydirection);
            }
            $q = $ci->db->get_where($table, $wherearray);
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return FALSE;
        }
    }

     if (!function_exists('getalldata')) {
        function getalldata($table, $wherearray = array(), $orderbyfield = null, $orderbydirection = null, $offset = null, $limit = null) {
            $ci =& get_instance(); 
            if ($orderbyfield) {
                $ci->db->order_by($orderbyfield, $orderbydirection);
            }
            if ($limit) {
                $ci->db->limit($limit, $offset);
            }
            $q = $ci->db->get_where($table, $wherearray);
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return FALSE;
        }
    }
    
    if(!function_exists('sendbulksms')){
        function sendbulksms($message, $sendto){
           $ci =& get_instance();
            $curl = curl_init();
            $settings = $ci->settings;
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://my.kudisms.net/api/sms',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('token' => '2F3Hh7oUx0KDfp1ASIdP8mq5lOTYBkR4jeaQJn6rytCbEgzZGiMNvcwsLWX9uV','senderID' => $settings->sms_senderid,'recipients' => $sendto,'message' => $message,'gateway' => '1'),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);
        }
    }

     if (!function_exists('sendsms')) {
        function sendsms($message, $sendto)
        {
           $ci =& get_instance();
            $curl = curl_init();
            $settings = $ci->settings;
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://my.kudisms.net/api/sms',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('token' => '2F3Hh7oUx0KDfp1ASIdP8mq5lOTYBkR4jeaQJn6rytCbEgzZGiMNvcwsLWX9uV','senderID' => $settings->sms_senderid,'recipients' => $sendto,'message' => $message,'gateway' => '1'),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);

        }
    }
   if(!function_exists('getSmsShortcodeTag')) {
          function getSmsShortcodeTag() {
            $ci =& get_instance(); 
            $ci->db->order_by('id', 'desc');
            $query = $ci->db->get('smsshortcode');
            return $query->result();
        }
    }


     // limit the no of characters
    if (!function_exists('text_limit')) {
        function text_limit($x, $length)
        {
          if(strlen($x)<=$length)
          {
            echo $x;
          }
          else
          {
            $y=substr($x,0,$length) . '...';
            echo $y;
          }
        }
    }

  if (!function_exists('sum_column_values')) {

         function sum_column_values($column_name, $table_name, $where = NULl) {
            $ci =& get_instance();
            $ci->db->select_sum($column_name);
            if ($where) {
                $ci->db->where($where);
            }
            $query = $ci->db->get($table_name);
            if (empty($query->row()->$column_name)) {
                return 0;
            }else{
                return $query->row()->$column_name;
            }
        }
        // code...
    }


    if (!function_exists('wallet_balance')) {

         function wallet_balance($userid = null) {
            if (empty($userid)) {
                 $credits = sum_column_values('amount','wallet_transactions',['creditordebit'=>'cr']);
                 $debits = sum_column_values('amount','wallet_transactions',['creditordebit'=>'dr']);
            }else{
                $credits = sum_column_values('amount','wallet_transactions',['userid'=>$userid,'creditordebit'=>'cr']);
                $debits = sum_column_values('amount','wallet_transactions',['userid'=>$userid,'creditordebit'=>'dr']);
            }
            return $credits - $debits;
         }
    }
   

    

    if (!function_exists('balance_after')) {

         function balance_after($userid = null,$typeoftxn,$amount) {
            
            $balance = wallet_balance($userid);
            $balanceafter = 0;
            if ($typeoftxn == 'cr') {
                $balanceafter = $balance + $amount;
            } elseif ($typeoftxn == 'dr') {
                $balanceafter = $balance - $amount;
            }
            return $balanceafter;
         }
    }
   

    if (!function_exists('generate_unique_reference')) {
        function generate_unique_reference($length = 10) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $reference = '';

            $max = strlen($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $reference .= $characters[random_int(0, $max)];
            }

            return $reference;
        }
    }

    // ----------------------------------------------------------------------------
    //print old form data
    if (!function_exists('old')) {
        function old($field)
        {
            $ci =& get_instance();
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }


    if (!function_exists('get_next_record')) {
        function get_next_record($currentRecordId,$table)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->from($table);
            $ci->db->where('id >', $currentRecordId);
            $ci->db->order_by('id', 'ASC');
            $ci->db->limit(1);

            $query = $ci->db->get();
            return $query->row();
        }
    }

    if (!function_exists('get_previous_record')) {
        function get_previous_record($currentRecordId,$table)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->from($table);
            $ci->db->where('id <', $currentRecordId);
            $ci->db->order_by('id', 'DESC');
            $ci->db->limit(1);

            $query = $ci->db->get();
            return $query->row();
        }
    }
   

    // --------------------------------------------------------------------------------
    if (!function_exists('date_time')) {
        function date_time($datetime) 
        {
           return date('F j, Y',strtotime($datetime));
        }
    }

   
    if (!function_exists('add_leading_zero')) {
        function add_leading_zero($inputString) {
            // Add a leading zero if there isn't one already
            if (substr($inputString, 0, 1) !== '0') {
                return '0' . $inputString;
            }

            return $inputString;
        }
    }

    if (!function_exists('generate_fhub_token')) {
        function generate_fhub_token(){
             $ci =& get_instance();
             $headers = [];
             $body = [
                'requestChannelId'=> $ci->settings->fhub_code,
                'requestChannel'=> "Api",
                'requestChannelType'=> "Integrator",
                'requestApplicationCode'=> "FINHUB",
                'requestPartnerCode'=> "LOAN",
                'username'=> $ci->settings->fhub_username,
                'password'=> $ci->settings->fhub_password,
                'rememberMe'=> true
             ];
             $uri = $ci->settings->fhub_islive == 1 ? $ci->settings->fhub_liveurl : $ci->settings->fhub_testurl;
             $url = $uri.'/identityservice/rest/api/integration/authentication/credential';
             $response = $ci->functions->sendPostRequest($url,$headers,$body);
             $response = json_decode($response);

            if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
                // json_decode('{ "responseCode" : 54, "responseMessage" : "API Error"')
               return false;
            } else {
                if ($response->responseCode == 200) {
                    return $response->data->authorization->token;
                }else{
                    return false;
                }
                
            }
             
        }
             
    }

    if (!function_exists('formatDate')) {
        function formatDate($date){
            if (empty($date)) {
                return "";
            }else{
                return date("M j, Y. h:i A",strtotime($date));
            }
        }
    }

    if (!function_exists('days_ago')) {
        function days_ago($date) {
            $now = new DateTime();
            $date = new DateTime($date);
            $interval = $date->diff($now);

            if ($interval->days > 0) {
                return $interval->days . ($interval->days === 1 ? ' day ago' : ' days ago');
            } else {
                return 'Today';
            }
        }
    }

  if (!function_exists('calculateDTIRatio')) {
    function calculateDTIRatio($monthlyDebtPayments, $monthlyIncome) {
        if ($monthlyIncome == 0) {
            return 0; // Handle division by zero
        }

        $dtiRatio = ($monthlyDebtPayments / $monthlyIncome) * 100;
        return number_format($dtiRatio, 2);
    }
  }

  if (!function_exists('replace_leading_234')) {
        function replace_leading_234($inputString) {
            $replacement = '0';
            $prefix = '234';

            if (strpos($inputString, $prefix) === 0) {
                return $replacement . substr($inputString, strlen($prefix));
            }

            return $inputString;
        }
    }

    if (!function_exists('getbyid')) {
        function getbyid($id, $table) {
            $ci =& get_instance();
            try {
                $q = $ci->db->get_where($table, array('id' => $id), 1);
                if( $q->num_rows() > 0 ) {
                    return $q->row();
                }
                return FALSE;
            } catch (Exception $e) {
                return '';
            }
            
        }
    }

    if (!function_exists('assetCurrentValue')) {
        function assetCurrentValue($assetValue, $depreciationStartDate, $depreciationRate, $usefulLife) {
            $today = new DateTime('today');
            $depreciationStartDate = new DateTime($depreciationStartDate);
            $yearsSinceDepreciationStarted = $today->diff($depreciationStartDate)->format('%a') / 365;
            $currentValue = $assetValue * (1 - ($depreciationRate / 100) * ($yearsSinceDepreciationStarted / $usefulLife));
            return $currentValue;
            
        }
    }

      if (!function_exists('getby')) {
            function getby($arr, $table) {
                $ci =& get_instance();
                $q = $ci->db->get_where($table, $arr, 1);
                if( $q->num_rows() > 0 ) {
                    return $q->row();
                }
                return FALSE;
            }
        }


    // --------------------------------------------------------------------------------
    // limit the no of characters
    if (!function_exists('text_limit')) {
        function text_limit($x, $length)
        {
          if(strlen($x)<=$length)
          {
            echo $x;
          }
          else
          {
            $y=substr($x,0,$length) . '...';
            echo $y;
          }
        }
    }

?>