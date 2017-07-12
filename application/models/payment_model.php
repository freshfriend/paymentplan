<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model
{
    public $table = 'tbl_payments';
    public $select_all = 'BaseTbl.id, BaseTbl.dueDate, BaseTbl.amount, BaseTbl.status, BaseTbl.userId, BaseTbl.planId, User.name, Plan.title';
    public $from_default = ' as BaseTbl';
    public $join_user_key = 'tbl_users as User';
    public $join_plan_key = 'tbl_plans as Plan';
    public $join_user_value = 'User.userId = BaseTbl.userId';
    public $join_plan_value = 'Plan.id = BaseTbl.planId';
    public $join_method = 'left';
    public $where_default = array('BaseTbl.isDeleted' => 0);
    public $criterias = array('id');
    public $suffix = 'BaseTbl.';

    function listAll($userId, $search = '', $page = 0, $segment = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->join($this->join_plan_key, $this->join_plan_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('userId', $userId));
        if ($segment != 0) $this->db->limit($page, $segment);
        if ($search != '') $this->db->where($this->genCriteria($search));
        $query = $this->db->get();
        
        return $query->result();
    }

    function listAllPlan ($userId, $planId, $search = '', $page = 0, $segment = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->join($this->join_plan_key, $this->join_plan_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('userId', $userId));
        $this->db->where($this->genWhere('planId', $planId));
        if ($segment != 0) $this->db->limit($page, $segment);
        if ($search != '') $this->db->where($this->genCriteria($search));
        $query = $this->db->get();
        
        return $query->result();
    }

    function countAll($userId) { return count($this->listAll($userId)); }

    function getOne ($id) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->join($this->join_plan_key, $this->join_plan_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('id', $id));
        $query = $this->db->get();
        
        return $query->result();
    }

    function genCriteria($search) {
        $criteria = '(';
        $i = 0;
        $count = count($this->criterias);
        foreach ($this->criterias as $value) {
            $criteria .= $this->suffix . $value . ' LIKE "%' . $search . '%"';
            if (++$i != $count)
                $criteria .= ' OR ';
        }
        $criteria .= ')';
        return $criteria;
    }

    function genWhere($key, $value) {
        return array($this->suffix . $key => $value);
    }

    function create($data) {
        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update($data) {
        $this->db->where('id', $data['id']);
        $this->db->update($this->table, $data);
        return TRUE;
    }

    function updateStatus($id, $status) {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('status'=>$status));
        return TRUE;
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('isDeleted'=>1));
        return $this->db->affected_rows();
    }
}