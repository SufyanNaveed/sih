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
            $result = 0;
            if($data['parent_id']){
                $this->db->select('id, parent_id, level_no, COUNT(*) as count');
                $this->db->from('levels');
                $this->db->where('parent_id', $data['parent_id']);
                $result = $this->db->get()->row_array();
                // echo '<pre>'; print_r($result); exit;
                if(!empty($result['id']) && $result['count'] > 0){
                    $levels_array = explode('.',$result['level_no']);
                    $counter = sizeof($levels_array);
                    $val =  $levels_array[$counter-1] + $result['count'];
                    $levels_array[$counter-1] = sprintf("%0".$counter."d", $val);
                    $result = implode('.',$levels_array);
                }else{
                    $this->db->select('parent_id,level_no,COUNT(*) as count');
                    $this->db->from('levels');
                    $this->db->where('id', $data['parent_id']);
                    $result_response = $this->db->get()->row_array();
                    // echo '<pre>'; print_r($result_response); exit;
                    if($result_response['parent_id'] > 0){
                        $this->db->select('parent_id,level_no, COUNT(*) as count');
                        $this->db->from('levels');
                        $this->db->where('id', $result_response['parent_id']);
                        $level_response = $this->db->get()->row_array();
                        // echo '<pre>'; print_r($level_response); exit;
                        if($level_response['parent_id'] > 0){
                            $result = $level_response['count'] > 0 ? $level_response['level_no'].'.'.sprintf("%04d", ($level_response['count'])) : $level_response['level_no'].'.'.sprintf("%04d", 1);
                        }else{
                            $result = $result_response['count'] > 0 ? $result_response['level_no'].'.'.sprintf("%03d", ($result_response['count'])) : $result_response['level_no'].'.'.sprintf("%03d", 1);
                        }
                    }else{
                        $result = $result['count'] > 0 ? $result_response['level_no'].'.'.sprintf("%02d", ($result['count'] + 1)) : $result_response['level_no'].'.'.sprintf("%02d", 1);
                    }
                }
            }else{
                $this->db->select('COUNT(*) as count');
                $this->db->from('levels');
                $this->db->where('parent_id', 0);
                $result = $this->db->get()->row()->count;
                $result = $result > 0 ? $result + 1 : '1';
            }
            $data['level_no'] = $result;
            // echo '<pre>'; print_r($data); exit;
            $this->db->insert('levels', $data);
            return $this->db->insert_id();
        }
    }
}
