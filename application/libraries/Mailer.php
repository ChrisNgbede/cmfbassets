<?php
class Mailer 
{
	function __construct()
	{
		$this->CI =& get_instance();
        $this->CI->load->helper('email');
	}
     //=============================================================
    // Eamil Templates
    function mail_template($to = '',$slug = '',$mail_data = '')
    {

        $template =  $this->CI->db->get_where('email_templates',array('slug' => $slug))->row_array();
        
        // var_dump($template);exit();
        $body = $template['body'];
        $template_id = $template['id'];
        $subject = $this->mail_template_variables($template['subject'], $slug, $mail_data);
        $data['head'] = $subject;
        $data['content'] = $this->mail_template_variables($body, $slug, $mail_data);
        $data['title'] = $template['name'];
        $template_view = $this->CI->load->view('admin/general_settings/email_templates/email_preview', $data, true);
        send_email($to, $subject, $template_view);
        return true;
    }

    //=============================================================
    // GET Email Templates AND REPLACE VARIABLES
    function mail_template_variables($content,$slug,$data = '')
    {
        switch ($slug) {
            case 'email-verification':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{VERIFICATION_LINK}',$data['verification_link'],$content);
                return $content;
            break;

            case 'forget-password':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{RESET_LINK}',$data['reset_link'],$content);
                return $content;
            break;
            case 'customer-booking-success':
                $content = str_replace('{bookedby}',$data['bookedby'],$content);
                $content = str_replace('{noofnights}',$data['noofnights'],$content);
                $content = str_replace('{checkin}',$data['checkin'],$content);
                $content = str_replace('{checkout}',$data['checkout'],$content);
                $content = str_replace('{datecreated}',$data['datecreated'],$content);
                $content = str_replace('{dueamount}',$data['dueamount'],$content);
                $content = str_replace('{room}',$data['room'],$content);
                return $content;
            break;

            case 'general-notification':
                $content = str_replace('{CONTENT}',$data['content'],$content);
                return $content;
            break;

            case 'booking-notification':
                $content = str_replace('{bookedby}',$data['bookedby'],$content);
                $content = str_replace('{email}',$data['email'],$content);
                $content = str_replace('{phone}',$data['phone'],$content);
                $content = str_replace('{noofnights}',$data['noofnights'],$content);
                $content = str_replace('{checkin}',$data['checkin'],$content);
                $content = str_replace('{checkout}',$data['checkout'],$content);
                $content = str_replace('{childs}',$data['childs'],$content);
                $content = str_replace('{adults}',$data['adults'],$content);
                $content = str_replace('{datecreated}',$data['datecreated'],$content);
                $content = str_replace('{dueamount}',$data['dueamount'],$content);
                $content = str_replace('{room}',$data['room'],$content);
                return $content;
            break;

            case 'collateral-registration':
                $content = str_replace('{COLLATERAL}',$data['COLLATERAL'],$content);
                $content = str_replace('{COLLATERALURL}',$data['COLLATERALURL'],$content);
                $content = str_replace('{ACTOR}',$data['ACTOR'],$content);
                return $content;
            break;

            case 'collateral-approval':
                $content = str_replace('{COLLATERAL}',$data['COLLATERAL'],$content);
                $content = str_replace('{COLLATERALURL}',$data['COLLATERALURL'],$content);
                $content = str_replace('{ACTOR}',$data['ACTOR'],$content);
                return $content;
            break;

            case 'collateral-retrieval':
                $content = str_replace('{COLLATERAL}',$data['COLLATERAL'],$content);
                $content = str_replace('{COLLATERALURL}',$data['COLLATERALURL'],$content);
                $content = str_replace('{ACTOR}',$data['ACTOR'],$content);
                return $content;
            break;

             case 'collateral-retrieval-approval':
                $content = str_replace('{COLLATERAL}',$data['COLLATERAL'],$content);
                $content = str_replace('{COLLATERALURL}',$data['COLLATERALURL'],$content);
                $content = str_replace('{ACTOR}',$data['ACTOR'],$content);
                return $content;
            break;

            case 'asset-registration':
            case 'asset-tagging':
            case 'asset-approval':
            case 'asset-status-change':
            case 'asset-update':
            case 'asset-deletion':
            case 'collateral-deletion':
            case 'collateral-status-change':
            case 'collateral-update':
                $content = str_replace('{ASSET_NAME}',$data['ASSET_NAME'] ?? '',$content);
                $content = str_replace('{ASSET_ID}',$data['ASSET_ID'] ?? '',$content);
                $content = str_replace('{COLLATERAL}',$data['COLLATERAL'] ?? '',$content);
                $content = str_replace('{COLLATERALURL}',$data['COLLATERALURL'] ?? '',$content);
                $content = str_replace('{STATUS}',$data['STATUS'] ?? '',$content);
                $content = str_replace('{URL}',$data['URL'] ?? '',$content);
                $content = str_replace('{ACTOR}',$data['ACTOR'] ?? '',$content);
                return $content;
            break;

           

            default:
                return $content;
                break;
        }
    }

	//=============================================================
	function registration_email($username, $email_verification_link)
	{
    $login_link = base_url('auth/login');  

		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to LightAdmin!</p>
            <p>Active your account with the link above and start your Career :</p>  
            <p>'.$email_verification_link.'</p>

            <br>
            <br>

            <p>Regards, <br> 
               CodeGlamoour Team <br> 
            </p>
    ';
		return $tpl;		
	}

	//=============================================================
	function pwd_reset_email($username, $reset_link)
	{
		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to LightAdmin!</p>
            <p>We have received a request to reset your password. If you did not initiate this request, you can simply ignore this message and no action will be taken.</p> 
            <p>To reset your password, please click the link below:</p> 
            <p>'.$reset_link.'</p>

            <br>
            <br>

            <p>© 2018 CodeGlamoour - All rights reserved</p>
    ';
		return $tpl;		
	}

}
?>