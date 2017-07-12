<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    public $table = 'tbl_customers';
    public $select_all = 'BaseTbl.id, BaseTbl.name, BaseTbl.email, BaseTbl.cardNumber, BaseTbl.expireDate, BaseTbl.cardCode,
        BaseTbl.company, BaseTbl.address, BaseTbl.city, BaseTbl.state, BaseTbl.zipcode, BaseTbl.country, User.userId';
    public $from_default = ' as BaseTbl';
    public $join_user_key = 'tbl_users as User';
    public $join_user_value = 'User.userId = BaseTbl.userId';
    public $join_method = 'left';
    public $where_default = array('BaseTbl.isDeleted' => 0);
    public $criterias = array('name', 'email');
    public $suffix = 'BaseTbl.';

    function listAll($userId, $search = '', $page = 0, $segment = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->where($this->where_default);
        $this->db->where($this->genWhere('userId', $userId));
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

    function checkEmailExists($email, $userId = 0) {
        $this->db->select($this->select_all);
        $this->db->from($this->table . $this->from_default);
        $this->db->join($this->join_user_key, $this->join_user_value, $this->join_method);
        $this->db->where($this->genWhere('email', $email));
        if($userId != 0) $this->db->where($this->genWhere('userId !=', $userId));
        $this->db->where($this->where_default);
        $query = $this->db->get();

        return $query->result();
    }
}