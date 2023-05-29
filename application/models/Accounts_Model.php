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

    public function Spayment()
    {
        $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'PM-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
        // echo '<pre>'; print_r($this->db->last_query()); exit;
        return $data;
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

    public function searchincomegroup($search_type, $head_id = null)
    {
        $return    = 1;
        $condition = '';
        if ($search_type == 'period') {
            $this->form_validation->set_rules('date_from', $this->lang->line('date_from'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_to', $this->lang->line('date_to'), 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                echo form_error();
                $return = 0;
            } else {
                $from_date  = $this->input->post('date_from');
                $to_date    = $this->input->post('date_to');
                $date_from  = date("Y-m-d", $this->customlib->datetostrtotime($from_date));
                $date_to    = date("Y-m-d", $this->customlib->datetostrtotime($to_date));
                $start_date = $date_from;
                $end_date   = $date_to;
            }
        } else if ($search_type == 'today') {
            $today      = strtotime('today');
            $first_date = date('Y-m-d', $today);
            $start_date = $first_date;
            $end_date   = $first_date;
        } else if ($search_type == 'this_week') {
            $this_week_start = strtotime('-1 week monday');
            $this_week_end   = strtotime('sunday');
            $first_date      = date('Y-m-d', $this_week_start);
            $last_date       = date('Y-m-d', $this_week_end);
            $start_date      = $first_date;
            $end_date        = $last_date;
        } else if ($search_type == 'last_week') {
            $last_week_start = strtotime('-2 week monday');
            $last_week_end   = strtotime('-1 week sunday');
            $first_date      = date('Y-m-d', $last_week_start);
            $last_date       = date('Y-m-d', $last_week_end);
            $start_date      = $first_date;
            $end_date        = $last_date;
        } else if ($search_type == 'this_month') {
            $first_date = date('Y-m-01');
            $last_date  = date('Y-m-t');
            $start_date = $first_date;
            $end_date   = $last_date;
        } else if ($search_type == 'last_month') {
            $month      = date("m", strtotime("-1 month"));
            $first_date = date('Y-' . $month . '-01');
            $last_date  = date('Y-' . $month . '-' . date('t', strtotime($first_date)));
            $start_date = $first_date;
            $end_date   = $last_date;
        } else if ($search_type == 'last_3_month') {
            $month      = date("m", strtotime("-2 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday   = date('Y-' . 'm' . '-01');
            $last_date  = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date   = $last_date;
        } else if ($search_type == 'last_6_month') {
            $month      = date("m", strtotime("-5 month"));
            $first_date = date('Y-' . $month . '-01');
            $firstday   = date('Y-' . 'm' . '-01');
            $last_date  = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date   = $last_date;
        } else if ($search_type == 'last_12_month') {
            $first_date = date('Y-m' . '-01', strtotime("-11 month"));
            $firstday   = date('Y-' . 'm' . '-01');
            $last_date  = date('Y-' . 'm' . '-' . date('t', strtotime($firstday)));
            $start_date = $first_date;
            $end_date   = $last_date;
        } else if ($search_type == 'last_year') {
            $search_year = date('Y', strtotime("-1 year"));
            $first_date  = '01-01-' . $search_year;
            $last_date   = '31-12-' . $search_year;
            $start_date  = date('Y-m-d', strtotime($first_date));
            $end_date    = date('Y-m-d', strtotime($last_date));
        } else if ($search_type == 'this_year') {
            $search_year = date('Y');
            $first_date  = '01-01-' . $search_year;
            $last_date   = '31-12-' . $search_year;
            $start_date  = date('Y-m-d', strtotime($first_date));
            $end_date    = date('Y-m-d', strtotime($last_date));
        } else if ($search_type == '') {
            $return = 0;
        }

        $this->db->select('GROUP_CONCAT(income.id,"@",income.name,"@",income.invoice_no,"@",income.date,"@",income.amount) as income, income_head.income_category,sum(income.amount) as total_amount')->from('income');
        $this->db->join('income_head', 'income.inc_head_id = income_head.id');
        if ($return == 1) {
            $this->db->where('income.date >=', $start_date);
            $this->db->where('income.date <=', $end_date);
        }
        if ($head_id != null) {
            $this->db->where('income.inc_head_id', $head_id);
        }
        $this->db->group_by('income.inc_head_id');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function supplier_payment_insert(){

        // $bank_id = $this->input->post('bank_id',TRUE);
        // if(!empty($bank_id)){
        // //  $bankname     = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
        // //  $bankcoaid    = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
        //    }else{
        //     $bankcoaid = '';
        //    }
           $voucher_no = addslashes(trim($this->input->post('txtVNo',TRUE)));
            $Vtype     = "PM";
            $cAID      = $this->input->post('cmbDebit',TRUE);
            $dAID      = $this->input->post('txtCode',TRUE);
            $Debit     = $this->input->post('txtAmount',TRUE);
            $Credit    = 0;
            $VDate     = $this->input->post('dtpDate',TRUE);
            $Narration = addslashes(trim($this->input->post('txtRemarks',TRUE)));
            $IsPosted  = 1;
            $IsAppove  = 1;
            $sup_id    = $this->input->post('supplier_id',TRUE);

            $CreateBy  = $this->session->userdata('id');
            $createdate= date('Y-m-d H:i:s');
            $dbtid     = $dAID;
            $Damnt     = $Debit;
            $supplier_id = $sup_id;
            $supinfo   = $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
            $supplierdebit = array(
              'VNo'            =>  $voucher_no,
              'Vtype'          =>  $Vtype,
              'VDate'          =>  $VDate,
              'COAID'          =>  $dbtid,
              'Narration'      =>  $Narration,
              'Debit'          =>  $Damnt,
              'Credit'         =>  0,
              'IsPosted'       => $IsPosted,
              'CreateBy'       => $CreateBy,
              'CreateDate'     => $createdate,
              'IsAppove'       => 1
            ); 
             $cc = array(
              'VNo'            =>  $voucher_no,
              'Vtype'          =>  $Vtype,
              'VDate'          =>  $VDate,
              'COAID'          =>  1020101,
              'Narration'      =>  'Paid to '.$supinfo->supplier_name,
              'Debit'          =>  0,
              'Credit'         =>  $Damnt,
              'IsPosted'       =>  1,
              'CreateBy'       =>  $CreateBy,
              'CreateDate'     =>  $createdate,
              'IsAppove'       =>  1
            ); 
             $bankc = array(
              'VNo'            =>  $voucher_no,
              'Vtype'          =>  $Vtype,
              'VDate'          =>  $VDate,
              'COAID'          =>  $bankcoaid,
              'Narration'      =>  'Supplier Payment To '.$supinfo->supplier_name,
              'Debit'          =>  0,
              'Credit'         =>  $Damnt,
              'IsPosted'       =>  1,
              'CreateBy'       =>  $CreateBy,
              'CreateDate'     =>  $createdate,
              'IsAppove'       =>  1
            ); 
              

           
              $this->db->insert('acc_transaction',$supplierdebit);

              if($this->input->post('paytype',TRUE) == 2){
                 $this->db->insert('acc_transaction',$bankc); 
              }
                if($this->input->post('paytype',TRUE) == 1){
                   $this->db->insert('acc_transaction',$cc);
                }
            $this->session->set_flashdata('message', display('save_successfully'));
          redirect('supplier_payment_received/'.$supplier_id.'/'.$voucher_no.'/'.$dbtid);
    
    }

    public function Creceive()
    {
      return  $data = $this->db->select("VNo as voucher")
            ->from('acc_transaction') 
            ->like('VNo', 'CR-', 'after')
            ->order_by('ID','desc')
            ->get()
            ->result_array();
           
    }
}
