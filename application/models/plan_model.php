<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Plan_model extends CI_Model
{
    /**
     * This function is used to get the plan listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function planListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, BaseTbl.status, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title  LIKE '%".$searchText."%'
                            OR  BaseTbl.summary  LIKE '%".$searchText."%'
                            OR  User.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return count($query->result());
    }

    /**
     * This function is used to get the certain plan listing
     * @param string $lastDate : This is optional search date
     * @param number $status : This is optional search status
     * @return number $count : This is row count
     */
    function certainPlanListing($lastDate, $status = 0)
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, BaseTbl.status, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.createdDtm >=', $lastDate);
        if ($status != 0)
            $this->db->where('BaseTbl.status', $status);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get the out dated plan listing
     * @param string $date : This is optional search date
     * @param number $status : This is optional search status
     * @return number $count : This is row count
     */
    function outdatedPlanListing($date, $status = 1)
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, BaseTbl.status, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.payDate <', $date);
        if ($status != 0)
            $this->db->where('BaseTbl.status', $status);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get the customer plan listing
     * @param string $date : This is optional search date
     * @param number $status : This is optional search status
     * @return number $count : This is row count
     */
    function getCustomerPlans($userId)
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, BaseTbl.status, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.userId', $userId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get the plan listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function planListing($searchText = '', $page = 0, $segment = -1)
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, Pstatus.status, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        $this->db->join('tbl_pstatuses as Pstatus', 'Pstatus.pstatusId = BaseTbl.status','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title  LIKE '%".$searchText."%'
                            "/*OR  BaseTbl.summary  LIKE '%".$searchText."%'*/."
                            OR  User.name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        if ($segment != -1)
            $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to add new paln to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewPlan($planInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_plans', $planInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get plan information by id
     * @param number $planId : This is plan id
     * @return array $result : This is plan information
     */
    function getPlanInfo($planId)
    {
        $this->db->select('BaseTbl.planId, BaseTbl.title, BaseTbl.summary, BaseTbl.amount, BaseTbl.payDate, BaseTbl.status, BaseTbl.userId, User.name');
        $this->db->from('tbl_plans as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.userId','left');
        $this->db->where('BaseTbl.isDeleted', 0);
		//$this->db->where('roleId !=', 1);
        $this->db->where('BaseTbl.planId', $planId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
    /**
     * This function is used to update the plan information
     * @param array $planInfo : This is plans updated information
     * @param number $planId : This is plan id
     */
    function editPlan($planInfo, $planId)
    {
        $this->db->where('planId', $planId);
        $this->db->update('tbl_plans', $planInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the plan information
     * @param number $planId : This is plan id
     * @return boolean $result : TRUE / FALSE
     */
    function deletePlan($planId, $planInfo)
    {
        $this->db->where('planId', $planId);
        $this->db->update('tbl_plans', $planInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }
}

  