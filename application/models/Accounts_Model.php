<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Accounts_model extends CI_Model
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
    public function search($text = null, $start_date = null, $end_date = null)
    {
        if (!empty($text)) {
            $this->db->select('income.id,income.date,income.name,income.invoice_no,income.amount,income.documents,income.note,income_head.income_category,income.inc_head_id')->from('income');
            $this->db->join('income_head', 'income.inc_head_id = income_head.id');
            $this->db->like('income.name', $text);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('income.id,income.date,income.name,income.invoice_no,income.amount,income.documents,income.note,income_head.income_category,income.inc_head_id')->from('income');
            $this->db->join('income_head', 'income.inc_head_id = income_head.id');
            $this->db->where('income.date >=', $start_date);
            $this->db->where('income.date <=', $end_date);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function get($id = null)
    {
        $this->db->select('accounts.*, levels.level_name');
        $this->db->from('accounts'); 
        $this->db->join('levels','accounts.level_id = levels.id','left'); 
        if ($id != null) {
            $this->db->where('accounts.id', $id);
        } else {
            $this->db->order_by('accounts.id', 'DESC');
        }
        $query = $this->db->get();
        // echo '<pre>'; print_r($this->db->last_query());exit;
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getTotal($search = '')
    {
        if (!empty($search)) {
            $this->db->where($search);
        }
        $this->db->select('sum(income.amount) as amount')->from('income');
        $this->db->join('income_head', 'income.inc_head_id = income_head.id');
        $query  = $this->db->get();
        $result = $query->row_array();
        return $result["amount"];
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('accounts');
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
            $this->db->update('accounts', $data);
        } else {
            $result = '';
            if($data['level_no']){
                $this->db->select('COUNT(*) as count');
                $this->db->from('accounts');
                $this->db->where('level_no', $data['level_no']);
                $query = $this->db->get()->row()->count;
                $result  = $query + 1;
                $result = $data['level_no'].'.'.sprintf("%04d", $result);
            }
            $data['account_no'] = $result;
            $this->db->insert('accounts', $data);
            return $this->db->insert_id();
        }
    }

    public function check_Exits_group($data)
    {
        $this->db->select('*');
        $this->db->from('income');
        $this->db->where('session_id', $this->current_session);
        $this->db->where('feetype_id', $data['feetype_id']);
        $this->db->where('class_id', $data['class_id']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return false;
        } else {
            return true;
        }
    }

    public function getTypeByFeecategory($type, $class_id)
    {
        $this->db->select('income.id,income.session_id,income.amount,income.invoice_no,income.documents,income.note,income_head.class,feetype.type')->from('income');
        $this->db->join('income_head', 'income.class_id = income_head.id');
        $this->db->join('feetype', 'income.feetype_id = feetype.id');
        $this->db->where('income.class_id', $class_id);
        $this->db->where('income.feetype_id', $type);
        $this->db->where('income.session_id', $this->current_session);
        $this->db->order_by('income.id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTotalExpenseBydate($date)
    {
        $query = 'SELECT sum(amount) as `amount` FROM `income` where date=' . $this->db->escape($date);
        $query = $this->db->query($query);
        return $query->row();
    }

    public function getTotalExpenseBwdate($date_from, $date_to)
    {
        $query = 'SELECT sum(amount) as `amount` FROM `income` where date between ' . $this->db->escape($date_from) . ' and ' . $this->db->escape($date_to);
        $query = $this->db->query($query);
        return $query->row();
    }

    public function Spayment()
    {
        $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'BM-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
        // echo '<pre>'; print_r($this->db->last_query()); exit;
        return $data;
    }
    
    public function Creceive()
    {
      return  $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'BR-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }

    public function CPayment()
    {
      return  $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'CP-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }

    public function Creceipt()
    {
      return  $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'CR-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }
    
    public function bank_payment_insert(){

        $from_bank = $this->get($_POST['from_bank_id']);
        $to_bank = $this->get($_POST['to_bank_id']);
        $cc = array(
            'VNo'            =>  $_POST['txtVNo'], 
            'VDate'          =>  $_POST['dtpDate'],
            'account_id'     =>  $_POST['from_bank_id'],
            'account_no'     =>  $_POST['fromtxtCode'],
            'Narration'      =>  $_POST['txtRemarks'],
            'paytype'        =>  $_POST['paytype'],
            'Debit'          =>  0,
            'Credit'         =>  $_POST['creditAmount'],
            'CreateBy'       =>  1,
            'CreateDate'     =>  date('Y-m-d H:i:s'),
        );  
        
        $bankc = array(
            'VNo'            =>  $_POST['txtVNo'], 
            'VDate'          =>  $_POST['dtpDate'],
            'account_id'     =>  $_POST['to_bank_id'],
            'account_no'     =>  $_POST['txtCode'],
            'Narration'      =>  $_POST['txtRemarks'],
            'paytype'        =>  $_POST['paytype'],
            'Debit'          =>  $_POST['debitAmount'],
            'Credit'         =>  0,
            'CreateBy'       =>  1,
            'CreateDate'     =>  date('Y-m-d H:i:s'),
        );              
        if($this->input->post('paytype',TRUE) == 2){
            $this->db->insert('acc_transaction',$bankc); 
        }
        if($this->input->post('paytype',TRUE) == 2){
            $this->db->insert('acc_transaction',$cc);
        }

        $data['balance'] = $from_bank['balance'] - $_POST['creditAmount'];
        $data1['balance'] = $to_bank['balance'] + $_POST['debitAmount'];
        // echo '<pre>'; print_r($data); exit;
        
        $this->db->where('id', $from_bank['id']);
        $this->db->update('accounts', $data);
        
        $this->db->where('id', $to_bank['id']);
        $this->db->update('accounts', $data1);
        

        return true;
    }

    public function bank_recieve_insert(){

        if($_POST['from_bank_id']){
            $from_bank = $this->get($_POST['from_bank_id']);

            $cc = array(
                'VNo'            =>  $_POST['txtVNo'], 
                'VDate'          =>  $_POST['dtpDate'],
                'account_id'     =>  $_POST['from_bank_id'],
                'account_no'     =>  $_POST['fromtxtCode'],
                'Narration'      =>  $_POST['txtRemarks'],
                'paytype'        =>  $_POST['paytype'],
                'Debit'          =>  0,
                'Credit'         =>  $_POST['creditAmount'],
                'CreateBy'       =>  1,
                'CreateDate'     =>  date('Y-m-d H:i:s'),
            );   
            $this->db->insert('acc_transaction',$cc); 
            

            $data['balance'] = $from_bank['balance'] - $_POST['creditAmount'];
            $this->db->where('id', $from_bank['id']);
            $this->db->update('accounts', $data);
        
        }

        if($_POST['to_bank_id']){
            $to_bank = $this->get($_POST['to_bank_id']);
            // echo '<pre>'; print_r($to_bank); exit;

            $bankc = array(
                'VNo'            =>  $_POST['txtVNo'], 
                'VDate'          =>  $_POST['dtpDate'],
                'account_id'     =>  $_POST['to_bank_id'],
                'account_no'     =>  $_POST['txtCode'],
                'Narration'      =>  $_POST['txtRemarks'],
                'paytype'        =>  $_POST['paytype'],
                'Debit'          =>  $_POST['debitAmount'],
                'Credit'         =>  0,
                'CreateBy'       =>  1,
                'CreateDate'     =>  date('Y-m-d H:i:s'),
            );              
            // echo '<pre>'; print_r($data); exit;
             
            $this->db->insert('acc_transaction',$bankc);
           
            $data1['balance'] = $to_bank['balance'] + $_POST['debitAmount'];
            // echo '<pre>'; print_r($data); exit;
            $this->db->where('id', $to_bank['id']);
            $this->db->update('accounts', $data1);
        }

        return true;
    }


    public function get_all_transaction(){
        $this->db->select('acc_transaction.*, acc.name');
        $this->db->from('acc_transaction');
        $this->db->join('accounts as acc','acc.id = acc_transaction.account_id','left');
        $this->db->order_by('ID','desc');
        $result = $this->db->get()->result_array();
        // echo '<pre>'; print_r($this->db->last_query());exit;
        return $result;
    }
}
