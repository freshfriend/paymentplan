<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Plan_model extends CI_Model
{
    public $table = 'tbl_plans';
    public $select_all = 'BaseTbl.id, BaseTbl.title, BaseTbl.userId, BaseTbl.customerId, User.name, Customer.name';
    public $from_default = ' as BaseTbl';
    public $join_user_key = 'tbl_users as User';
    public $join_customer_key = 'tbl_customers as Customer';
    public $join_user_value = 'User.userId = BaseTbl.userId';
    public $join_customer_value = 'Customer.id = BaseTbl.customerId';
    public $join_method = 'left';
    public $where_default = array('BaseTbl.isDeleted' => 0);
    public $criterias = array('title');
    public $suffix = 'BaseTbl.';

    function listAll ($userId, $search = '', $page = 0, $segment = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->join($this->join_customer_key, $this->join_customer_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('userId', $userId));
        if ($segment != 0) $this->db->limit($page, $segment);
        if ($search != '') $this->db->where($this->genCriteria($search));
        $query = $this->db->get();
        
        return $query->result();
    }

    function listAllCustomer ($userId, $customerId, $search = '', $page = 0, $segment = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->join($this->join_customer_key, $this->join_customer_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('userId', $userId));
        $this->db->where($this->genWhere('customerId', $customerId));
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
        $this->db->join($this->join_customer_key, $this->join_customer_value, $this->join_method);
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

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('isDeleted'=>1));
        return $this->db->affected_rows();
    }
}