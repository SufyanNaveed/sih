<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Levels_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */

    public function get($id = null)
    {
        $this->db->select('levels.*, parent_level.level_name as parent_name');
        $this->db->from('levels'); 
        $this->db->join('levels as parent_level','parent_level.id = levels.parent_id','left'); 
        if ($id != null) {
            $this->db->where('levels.id', $id);
        } else {
            $this->db->order_by('levels.id', 'asc');
        }
        $query = $this->db->get();
        // echo '<pre>'; print_r($this->db->last_query()); exit;
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

     
    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('levels');
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data)
    {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('levels', $data);
        } else {

            $this->db->insert('levels', $data);
            return $this->db->insert_id();
        }
    }
}
