<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Levels extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->config->load("payroll");
        $this->config->load("image_valid");
        $this->search_type = $this->config->item('search_type');
    }

    public function index()
    {

        if (!$this->module_lib->hasActive('levels')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'levels');
        $this->session->set_userdata('sub_menu', 'levels/index');
        $data['title']       = 'Add levels';
        $data['title_list']  = 'Recent levels';
        $levels_result       = $this->levels_model->get();
        $data['levelslist']  = $levels_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/levels/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function add()
    {
        $this->session->set_userdata('top_menu', 'levels');
        $this->session->set_userdata('sub_menu', 'levels/index');
        $data['title']      = 'Add levels';
        $data['title_list'] = 'Recent levels'; 
        $this->form_validation->set_rules('level_name', $this->lang->line('level_name'), 'trim|required|xss_clean'); 
        
        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_name'          => form_error('level_name'),  
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'parent_id'    => $_POST['parent_id'] ? $_POST['parent_id'] : 0, 
                'level_name'   => $_POST['level_name'], 
                'status'       => 1, 
            );
            $insert_id = $this->levels_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('levels', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Levels List';
        $this->levels_model->remove($id);
        redirect('admin/levels/index');
    }

    public function create()
    {
        $data['title'] = 'Add Fees Master';
        $this->form_validation->set_rules('levels', 'Fees Master', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('levels/levelsCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'levels' => $this->input->post('levels'),
            );
            $this->levels_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">levels added successfully</div>');
            redirect('levels/index');
        }
    }

    public function getDataByid($id)
    {
        $data['title']       = 'Edit levels';
        $data['id']          = $id;
        $levels              = $this->levels_model->get($id);
        $data['levelslist']  = $this->levels_model->get();
        $data['level']       = $levels;
        $this->load->view('admin/levels/editModal', $data);
    }

    public function edit($id)
    {
        $data['title']       = 'Edit levels';
        $data['id']          = $id;
        $data['title_list']  = 'levels List'; 
        $this->form_validation->set_rules('level_name', $this->lang->line('level_name'), 'trim|required|xss_clean'); 
        if ($this->form_validation->run() == false) {
            $msg = array(
                'level_name'          => form_error('level_name'),  
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');

        } else {
            $data = array(
                'id' => $id, 
                'parent_id'    => $_POST['parent_id'] ? $_POST['parent_id'] : 0, 
                'level_name'   => $_POST['level_name'], 
                'status'       => 1, 
            );
            $insert_id = $this->levels_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

     
    public function bank_payment()
    {
        if (!$this->module_lib->hasActive('levels')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'levels');
        $this->session->set_userdata('sub_menu', 'levels/bank_payment');
        $data['title']       = 'Bank Payment';
        $data['title_list']  = 'Bank Payment';
        $data['levels'] =  $this->levels_model->get();
        $data['voucher_no']  = $this->levels_model->Spayment();
        $this->load->view('layout/header', $data); 
        $this->load->view('admin/levels/bank_payment', $data);
        $this->load->view('layout/footer', $data);
    }
    

    public function create_bank_payment(){
        $this->form_validation->set_rules('txtCode', 'txtCode'  ,'max_length[100]');
        $this->form_validation->set_rules('paytype', 'paytype'  ,'required|max_length[2]');
         $this->form_validation->set_rules('txtCode', 'code'  ,'required|max_length[30]');
          $this->form_validation->set_rules('txtAmount', 'amount'  ,'required|max_length[30]');
         if ($this->form_validation->run()) { 
        if ($this->levels_model->bank_payment_insert()) { 
          $this->session->set_flashdata('message', 'Save successfully');
          redirect('bank_payment');
        }else{
          $this->session->set_flashdata('exception', 'Please try again');
        }
        redirect("bank_payment");
        }else{
          $this->session->set_flashdata('exception',   validation_errors());
          redirect("bank_payment");
         }

    }


    public function bank_recieve()
    {
        if (!$this->module_lib->hasActive('levels')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'levels');
        $this->session->set_userdata('sub_menu', 'levels/bank_recieve');
        $data['title']       = 'Bank Receive';
        $data['title_list']  = 'Bank Receive';
        $data['levels'] =  $this->levels_model->get();
        $data['voucher_no']  = $this->levels_model->Creceive();
        $this->load->view('layout/header', $data); 
        $this->load->view('admin/levels/bank_recieve', $data);
        $this->load->view('layout/footer', $data);
    }
    
    
    
    
    
    public function levelsSearch()
    {
        if (!$this->rbac->hasPrivilege('levels_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/levels/levelssearch');
        $select     = 'levels.id,levels.date,levels.name,levels.invoice_no,levels.amount,levels.documents,levels.note,levels_head.levels_category,levels.inc_head_id';
        $join       = array('JOIN levels_head ON levels.inc_head_id = levels_head.id');
        $table_name = "levels";

        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        if (empty($search_type)) {
            $search_type = "";
            $listMessage = $this->report_model->getReport($select, $join, $table_name);
        } else {
            $search_table     = "levels";
            $search_column    = "date";
            $additional       = array();
            $additional_where = array();
            $listMessage      = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column);
        }
        $data['resultList']  = $listMessage;
        $data["searchlist"]  = $this->search_type;
        $data["search_type"] = $search_type;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/levels/levelsSearch', $data);
        $this->load->view('layout/footer', $data);
    }

    public function transactionreport($value = '')
    {
        if (!$this->rbac->hasPrivilege('transaction_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/levels/transactionreport');
        $search_type = $this->input->post("search_type");
        if (isset($search_type)) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }

        $parameter = array('OPD' => array('label' => 'OPD', 'table'               => 'opd_details', 'search_table' => 'opd_details',
            'search_column'                           => 'appointment_date', 'select' => 'opd_details.*,opd_details.appointment_date as date,opd_details.opd_no as reff, patients.id as pid,patients.patient_name,patients.patient_unique_id,staff.name, staff.surname',
            'join'                                    => array('LEFT JOIN staff ON opd_details.cons_doctor = staff.id',
                'LEFT JOIN patients ON opd_details.patient_id = patients.id',
            )),
            'IPD'                    => array('label' => 'IPD', 'table' => 'ipd_details', 'search_table' => 'payment',
                'search_column'                           => 'date',
                'select'                                  => 'ipd_details.ipd_no,payment.date,payment.paid_amount as amount,patients.id as pid,patients.patient_name,ipd_details.ipd_no as reff,patients.patient_unique_id',
                'join'                                    => array(
                    'JOIN staff ON ipd_details.cons_doctor = staff.id',
                    'JOIN patients ON ipd_details.patient_id = patients.id',
                    'JOIN payment ON payment.ipd_id = ipd_details.id',
                ),
            ),
            'Pharmacy'               => array('label' => 'Pharmacy', 'table' => 'pharmacy_bill_basic', 'search_table' => 'pharmacy_bill_basic',
                'search_column'                           => 'date',
                'select'                                  => 'pharmacy_bill_basic.*,patients.patient_name as patient_name,pharmacy_bill_basic.bill_no as reff,pharmacy_bill_basic.net_amount as amount',
                'join'                                    => array('JOIN patients ON patients.id = pharmacy_bill_basic.patient_id'),
            ),
            'Pathology'              => array('label' => 'Pathology', 'table' => 'pathology_report', 'search_table' => 'pathology_report',
                'search_column'                           => 'reporting_date',
                'select'                                  => 'pathology_report.*, pathology_report.apply_charge as amount,pathology_report.id as reff,pathology_report.reporting_date as date,pathology.id, pathology.short_name,charges.id as cid,charges.charge_category,charges.standard_charge,patients.patient_name',
                'join'                                    => array(
                    'JOIN pathology ON pathology_report.pathology_id = pathology.id',
                    'LEFT JOIN staff ON pathology_report.consultant_doctor = staff.id',
                    'JOIN charges ON charges.id = pathology.charge_id', 'JOIN patients ON pathology_report.patient_id=patients.id'),
            ),
            'Radiology'              => array('label' => 'Radiology', 'table' => 'radiology_report', 'search_table' => 'radiology_report',
                'search_column'                           => 'reporting_date',
                'select'                                  => 'radiology_report.*,radiology_report.apply_charge as amount,radiology_report.reporting_date as date, radiology_report.id as reff,radio.id, radio.short_name,charges.id as cid,charges.charge_category,charges.standard_charge,patients.patient_name',
                'join'                                    => array(
                    'JOIN radio ON radiology_report.radiology_id = radio.id',
                    'JOIN staff ON radiology_report.consultant_doctor = staff.id',
                    'JOIN charges ON charges.id = radio.charge_id', 'JOIN patients ON radiology_report.patient_id=patients.id',
                )),
            'Operation_Theatre'      => array('label' => 'Operation Theatre', 'table' => 'operation_theatre', 'search_table' => 'operation_theatre',
                'search_column'                           => 'date',
                'select'                                  => 'operation_theatre.*,operation_theatre.id as reff,patients.id as pid,patients.patient_unique_id,patients.patient_name,charges.id as cid,charges.charge_category,charges.code,charges.description,charges.standard_charge, operation_theatre.apply_charge as amount',
                'join'                                    => array(
                    'JOIN patients ON operation_theatre.patient_id=patients.id',
                    'JOIN staff ON staff.id = operation_theatre.consultant_doctor',
                    'JOIN charges ON operation_theatre.charge_id = charges.id',
                )),
            'Blood_Bank'             => array('label' => 'Blood Bank', 'table'        => 'blood_issue',
                'search_column'                           => 'created_at', 'search_table' => 'blood_issue',
                'select'                                  => 'blood_issue.*,blood_issue.id as reff,blood_issue.created_at as date,patients.patient_name',
                'join'                                    => array('JOIN patients ON blood_issue.recieve_to=patients.id')),
            'ambulance'              => array('label' => 'Ambulance', 'table' => 'ambulance_call', 'search_table' => 'ambulance_call',
                'search_column'                           => 'date',
                'select'                                  => 'ambulance_call.*,ambulance_call.id as reff,patients.patient_name',
                'join'                                    => array('JOIN patients ON ambulance_call.patient_name=patients.id')),
            'levels'                 => array('label' => 'General levels', 'table' => 'levels', 'search_table' => 'levels',
                'search_column'                           => 'date',
                'select'                                  => 'levels.*,levels.name as patient_name,levels.invoice_no as reff',
                'join'                                    => array('JOIN levels_head ON levels.inc_head_id = levels_head.id')),
            'expense'                => array('label' => 'Expenses', 'table' => 'expenses', 'search_table' => 'expenses',
                'search_column'                           => 'date',
                'select'                                  => 'expenses.*,expenses.name as patient_name,expenses.invoice_no as reff',
                'join'                                    => array('JOIN expense_head ON expenses.exp_head_id = expense_head.id')),
            'payroll'                => array('label' => 'Payroll', 'table' => 'staff_payslip', 'search_table' => 'staff_payslip',
                'search_column'                           => 'payment_date',
                'select'                                  => 'staff_payslip.*,staff.name as patient_name,staff.surname,staff.employee_id as patient_unique_id,staff_payslip.payment_date as date,staff_payslip.net_salary as amount,staff_payslip.id as reff',
                'join'                                    => array('JOIN staff ON staff_payslip.staff_id = staff.id')),
        );

        $i                 = 0;
        $data["parameter"] = $parameter;
        foreach ($parameter as $key => $value) {
            # code...

            $select     = $parameter[$key]['select'];
            $join       = $parameter[$key]['join'];
            $table_name = $parameter[$key]['table'];

            if (empty($search_type)) {

                $search_type = "";
                $resultList  = $this->report_model->getReport($select, $join, $table_name);
            } else {

                $search_table     = $parameter[$key]['search_table'];
                $search_column    = $parameter[$key]['search_column'];
                $additional       = array();
                $additional_where = array();
                $resultList       = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column);
            }

            $rd[$parameter[$key]['label']]         = $resultList;
            $data['parameter'][$key]['resultList'] = $resultList;
            $i++;
        }

        $resultList2 = $this->report_model->searchReport($select = 'ipd_details.ipd_no,ipd_billing.date,ipd_billing.net_amount as amount,patients.id as pid,patients.patient_name,ipd_details.ipd_no as reff,patients.patient_unique_id', $join = array('JOIN staff ON ipd_details.cons_doctor = staff.id',
            'LEFT JOIN patients ON ipd_details.patient_id = patients.id',
            //'LEFT  JOIN payment ON payment.ipd_id = ipd_details.id',
            'LEFT JOIN ipd_billing ON ipd_billing.ipd_id = ipd_details.id',
        ), $table_name = 'ipd_details', $search_type, $search_table = 'ipd_billing', $search_column = 'date');

        if (!empty($resultList2)) {
            foreach ($resultList2 as $key => $value) {
                array_push($rd["IPD"], $value);
                array_push($data['parameter']["IPD"]['resultList'], $value);
            }

        }

        $resultList3 = $this->report_model->searchReport($select = 'opd_details.opd_no,opd_billing.date,opd_billing.net_amount as amount,patients.id as pid,patients.patient_name,opd_details.opd_no as reff,patients.patient_unique_id', $join = array('JOIN staff ON opd_details.cons_doctor = staff.id',
            'LEFT JOIN patients ON opd_details.patient_id = patients.id',
            //'LEFT JOIN opd_payment ON opd_payment.opd_id = opd_details.id',
            'LEFT JOIN opd_billing ON opd_billing.opd_id = opd_details.id',
        ), $table_name = 'opd_details', $search_type, $search_table = 'opd_billing', $search_column = 'date');

        if (!empty($resultList3)) {
            foreach ($resultList3 as $key => $value) {
                array_push($rd["OPD"], $value);
                array_push($data['parameter']["OPD"]['resultList'], $value);
            }
        }

        $resultList4 = $this->report_model->searchReport($select = 'opd_details.opd_no,opd_payment.date,opd_payment.paid_amount as amount,patients.id as pid,patients.patient_name,opd_details.opd_no as reff,patients.patient_unique_id', $join = array('JOIN staff ON opd_details.cons_doctor = staff.id',
            'LEFT JOIN patients ON opd_details.patient_id = patients.id',
            'LEFT JOIN opd_payment ON opd_payment.opd_id = opd_details.id',
            //'LEFT JOIN opd_billing ON opd_billing.opd_id = opd_details.id',
        ), $table_name = 'opd_details', $search_type, $search_table = 'opd_payment', $search_column = 'date');

        if (!empty($resultList4)) {
            foreach ($resultList4 as $key => $value) {
                array_push($rd["OPD"], $value);
                array_push($data['parameter']["OPD"]['resultList'], $value);
            }

        }

        $data["resultlist"]  = $rd;
        $data["searchlist"]  = $this->search_type;
        $data["search_type"] = $search_type;
        //echo '<pre>'; print_r($data);exit;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/levels/transactionReport', $data);
        $this->load->view('layout/footer', $data);
    }

    public function levelsgroup()
    {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'reports/levelsgroup');
        if (isset($_POST['search_type'])) {
            $search_type = $this->input->post("search_type");
        } else {
            $search_type = "this_month";
        }
        $data['head_id'] = $head_id = "";
        if (isset($_POST['head']) && $_POST['head'] != '') {
            $data['head_id'] = $head_id = $_POST['head'];
        }
        $data["searchlist"]  = $this->search_type;
        $data["search_type"] = $search_type;
        $levelsList          = $this->levels_model->searchlevelsgroup($search_type, $head_id);
        $data['headlist']    = $this->levelshead_model->get();
        $data['levelsList']  = $levelsList;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/levels/grouplevelsReport', $data);
        $this->load->view('layout/footer', $data);
    }
}
