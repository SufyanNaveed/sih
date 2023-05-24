<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Accounts extends Admin_Controller
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

        if (!$this->module_lib->hasActive('accounts')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'accounts');
        $this->session->set_userdata('sub_menu', 'accounts/index');
        $data['title']       = 'Add Accounts';
        $data['title_list']  = 'Recent Accounts';
        $accounts_result       = $this->accounts_model->get();
        $data['accountslist']  = $accounts_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/accounts/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function add()
    {
        $this->session->set_userdata('top_menu', 'accounts');
        $this->session->set_userdata('sub_menu', 'accounts/index');
        $data['title']      = 'Add accounts';
        $data['title_list'] = 'Recent accountss'; 
        $this->form_validation->set_rules('balance', $this->lang->line('balance'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean'); 
        $this->form_validation->set_rules('account_no', $this->lang->line('account_no'), 'trim|required|xss_clean'); 
        $this->form_validation->set_rules('acc_type', $this->lang->line('acc_type'), 'trim|required|xss_clean'); 
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name'          => form_error('name'),
                'account_no'    => form_error('account_no'),
                'account_type'      => form_error('acc_type'),
                'adate'          => date('Y-m-d H:i:s'),
                'balance'       => form_error('balance'), 
                'description'   => form_error('description'), 
            );

            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');
        } else {
            $data = array(
                'name'          => $_POST['name'],
                'account_no'    => $_POST['account_no'],
                'account_type'  => $_POST['acc_type'],
                'adate'          => Date('Y-m-d H:i:s'),
                'balance'       => $_POST['balance'], 
                'description'   => $_POST['description'], 
            );
            $insert_id = $this->accounts_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('success_message'));
        }
        echo json_encode($array);
    }

    public function download($documents)
    {
        $this->load->helper('download');
        $filepath = "./uploads/hospital_accounts/" . $this->uri->segment(6);
        $data     = file_get_contents($filepath);
        $name     = $this->uri->segment(6);
        force_download($name, $data);
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('accounts', 'can_view')) {
            access_denied();
        }
        $data['title']  = 'Fees Master List';
        $accounts         = $this->accounts_model->get($id);
        $data['accounts'] = $accounts;
        $this->load->view('layout/header', $data);
        $this->load->view('accounts/accountsShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('accounts', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->accounts_model->remove($id);
        redirect('admin/accounts/index');
    }

    public function create()
    {
        $data['title'] = 'Add Fees Master';
        $this->form_validation->set_rules('accounts', 'Fees Master', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('accounts/accountsCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'accounts' => $this->input->post('accounts'),
            );
            $this->accounts_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">accounts added successfully</div>');
            redirect('accounts/index');
        }
    }

    public function handle_upload()
    {
        $image_validate = $this->config->item('file_validate');
        if (isset($_FILES["documents"]) && !empty($_FILES['documents']['name'])) {
            $file_type         = $_FILES["documents"]['type'];
            $file_size         = $_FILES["documents"]["size"];
            $file_name         = $_FILES["documents"]["name"];
            $allowed_extension = $image_validate['allowed_extension'];
            $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_mime_type = $image_validate['allowed_mime_type'];
            if ($files = @filesize($_FILES['documents']['tmp_name'])) {
                if (!in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Type Not Allowed');
                    return false;
                }

                if (!in_array(strtolower($ext), $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', 'File Extension Not Allowed');
                    return false;
                }
                if ($file_size > $image_validate['upload_size']) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', "Error File Uploading");
                return false;
            }

            return true;
        }
        return true;
    }

    public function getDataByid($id)
    {
        $data['title']       = 'Edit Accounts';
        $data['id']          = $id;
        $accounts              = $this->accounts_model->get($id);
        $data['account']      = $accounts;
        $this->load->view('admin/accounts/editModal', $data);
    }

    public function edit($id)
    {
        $data['title']       = 'Edit Accounts';
        $data['id']          = $id;
        $data['title_list']  = 'Accounts List'; 
        $this->form_validation->set_rules('account_no', $this->lang->line('account_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean'); 
        if ($this->form_validation->run() == false) {
            $msg = array(
                'name'          => form_error('name'),
                'account_no'    => form_error('account_no'),
            );
            $array = array('status' => 'fail', 'error' => $msg, 'message' => '');

        } else {
            $data = array(
                'id'            => $id,
                'name'          => $this->input->post("name"),
                'account_no'    => $this->input->post("account_no"),
                'description'   => $this->input->post("description")
            );
            $insert_id = $this->accounts_model->add($data);
            $array = array('status' => 'success', 'error' => '', 'message' => $this->lang->line('update_message'));
        }

        echo json_encode($array);
    }

     
    public function bank_payment()
    {
        if (!$this->module_lib->hasActive('accounts')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'accounts');
        $this->session->set_userdata('sub_menu', 'accounts/bank_payment');
        $data['title']       = 'Bank Payment';
        $data['title_list']  = 'Bank Payment';
        $data['accounts'] =  $this->accounts_model->get();
        $data['voucher_no']  = $this->accounts_model->Spayment();
        $this->load->view('layout/header', $data); 
        $this->load->view('admin/accounts/bank_payment', $data);
        $this->load->view('layout/footer', $data);
    }
    

    public function create_bank_payment(){
        $this->form_validation->set_rules('txtCode', 'txtCode'  ,'max_length[100]');
        $this->form_validation->set_rules('paytype', 'paytype'  ,'required|max_length[2]');
         $this->form_validation->set_rules('txtCode', 'code'  ,'required|max_length[30]');
          $this->form_validation->set_rules('txtAmount', 'amount'  ,'required|max_length[30]');
         if ($this->form_validation->run()) { 
        if ($this->accounts_model->bank_payment_insert()) { 
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
        if (!$this->module_lib->hasActive('accounts')) {
            access_denied();
        } 
        $this->session->set_userdata('top_menu', 'accounts');
        $this->session->set_userdata('sub_menu', 'accounts/bank_recieve');
        $data['title']       = 'Bank Receive';
        $data['title_list']  = 'Bank Receive';
        $data['accounts'] =  $this->accounts_model->get();
        $data['voucher_no']  = $this->accounts_model->Creceive();
        $this->load->view('layout/header', $data); 
        $this->load->view('admin/accounts/bank_recieve', $data);
        $this->load->view('layout/footer', $data);
    }
    
    
    
    
    
    public function accountsSearch()
    {
        if (!$this->rbac->hasPrivilege('accounts_report', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/accounts/accountssearch');
        $select     = 'accounts.id,accounts.date,accounts.name,accounts.invoice_no,accounts.amount,accounts.documents,accounts.note,accounts_head.accounts_category,accounts.inc_head_id';
        $join       = array('JOIN accounts_head ON accounts.inc_head_id = accounts_head.id');
        $table_name = "accounts";

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
            $search_table     = "accounts";
            $search_column    = "date";
            $additional       = array();
            $additional_where = array();
            $listMessage      = $this->report_model->searchReport($select, $join, $table_name, $search_type, $search_table, $search_column);
        }
        $data['resultList']  = $listMessage;
        $data["searchlist"]  = $this->search_type;
        $data["search_type"] = $search_type;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/accounts/accountsSearch', $data);
        $this->load->view('layout/footer', $data);
    }

    public function transactionreport($value = '')
    {
        if (!$this->rbac->hasPrivilege('transaction_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'admin/accounts/transactionreport');
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
            'accounts'                 => array('label' => 'General accounts', 'table' => 'accounts', 'search_table' => 'accounts',
                'search_column'                           => 'date',
                'select'                                  => 'accounts.*,accounts.name as patient_name,accounts.invoice_no as reff',
                'join'                                    => array('JOIN accounts_head ON accounts.inc_head_id = accounts_head.id')),
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
        $this->load->view('admin/accounts/transactionReport', $data);
        $this->load->view('layout/footer', $data);
    }

    public function accountsgroup()
    {
        $this->session->set_userdata('top_menu', 'Reports');
        $this->session->set_userdata('sub_menu', 'reports/accountsgroup');
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
        $accountsList          = $this->accounts_model->searchaccountsgroup($search_type, $head_id);
        $data['headlist']    = $this->accountshead_model->get();
        $data['accountsList']  = $accountsList;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/accounts/groupaccountsReport', $data);
        $this->load->view('layout/footer', $data);
    }
}
