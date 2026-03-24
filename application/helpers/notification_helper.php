<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get emails of users with specific role designations
 * @param array $flags Array of designation columns (e.g. ['is_asset_approver', 'is_asset_initiator'])
 * @return string Comma separated emails
 */
function get_recipients_by_designation($flags)
{
    $CI =& get_instance();
    $CI->db->select('email');
    $CI->db->from('users');
    $CI->db->join('roles', 'roles.admin_role_id = users.admin_role_id');
    
    $CI->db->group_start();
    foreach($flags as $flag) {
        $CI->db->or_where('roles.'.$flag, 1);
    }
    $CI->db->group_end();
    
    $CI->db->where('users.is_active', 1);
    $query = $CI->db->get();
    $emails = [];
    foreach($query->result_array() as $row) {
        $emails[] = $row['email'];
    }
    return implode(',', array_unique($emails));
}

/**
 * Send notification for Asset events
 */
function notify_asset_event($asset_id, $event_type)
{
    $CI =& get_instance();
    $CI->load->library('mailer');
    $CI->load->model('admin/common_model');
    
    $asset = $CI->db->get_where('assets', ['id' => $asset_id])->row_array();
    if(!$asset) return;

    $designations = [];
    $slug = 'general-notification';
    
    switch($event_type) {
        case 'new':
            $designations = ['is_asset_initiator', 'is_asset_approver'];
            $slug = 'asset-registration';
            break;
        case 'tagging':
            $designations = ['is_asset_initiator', 'is_asset_approver', 'is_asset_tagger'];
            $slug = 'asset-tagging';
            break;
        case 'approve':
            $designations = ['is_asset_initiator', 'is_asset_tagger'];
            $slug = 'asset-approval';
            break;
        case 'delete':
            $designations = ['is_asset_initiator', 'is_asset_approver', 'is_asset_tagger'];
            $slug = 'asset-deletion';
            break;
        case 'status':
        case 'update':
            $designations = ['is_asset_initiator', 'is_asset_approver', 'is_asset_tagger'];
            $slug = ($event_type == 'status') ? 'asset-status-change' : 'asset-update';
            break;
    }

    $recipients = get_recipients_by_designation($designations);
    if(empty($recipients)) return;

    $mail_data = [
        'ASSET_NAME' => $asset['name'],
        'ASSET_ID' => $asset['assetcode'],
        'STATUS' => $asset['status'],
        'URL' => base_url('admin/asset/asset_details/'.$asset_id),
        'ACTOR' => nameofuser($CI->session->userdata('id'))
    ];

    $CI->mailer->mail_template($recipients, $slug, $mail_data);
}

/**
 * Send notification for Collateral events
 */
function notify_collateral_event($collateral_id, $event_type)
{
    $CI =& get_instance();
    $CI->load->library('mailer');
    
    $collateral = $CI->db->get_where('collaterals', ['id' => $collateral_id])->row_array();
    if(!$collateral) return;

    $designations = [];
    $slug = 'general-notification';

    switch($event_type) {
        case 'new':
            $designations = ['is_collateral_initiator', 'is_collateral_approver', 'is_collateral_tagger'];
            $slug = 'collateral-registration';
            break;
        case 'status':
        case 'update':
            $designations = ['is_collateral_initiator', 'is_collateral_approver', 'is_collateral_tagger'];
            $slug = ($event_type == 'status') ? 'collateral-status-change' : 'collateral-update';
            break;
        case 'delete':
            $designations = ['is_collateral_initiator', 'is_collateral_approver', 'is_collateral_tagger'];
            $slug = 'collateral-deletion';
            break;
    }

    $recipients = get_recipients_by_designation($designations);
    if(empty($recipients)) return;

    $mail_data = [
        'COLLATERAL' => $collateral['name'] . ' - ' . $collateral['customername'],
        'COLLATERALURL' => base_url('admin/asset/collateraldetails/'.$collateral_id),
        'STATUS' => $collateral['status'],
        'ACTOR' => nameofuser($CI->session->userdata('id'))
    ];

    $CI->mailer->mail_template($recipients, $slug, $mail_data);
}
