<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Customer extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('plan_model');
        $this->load->model('payment_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index($view = 0, $param = null)
    {
        $this->global['pageTitle'] = 'PaymentPlan : Customer';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->customer_model->countAll($this->vendorId);
        $returns = $this->paginationCompress ("customer/index", $count, 10 );
        $data['records'] = $this->customer_model->listAll($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
        $data['userId'] = $this->vendorId;

        $data['view'] = $view;
        $data['param'] = $param;
        
        $this->loadViews("customer", $this->global, $data , NULL);
    }

    function create ($customerId = 0) {
        $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email Address','trim|required|valid_email|xss_clean|max_length[128]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index(1);
        }
        else
        {
            $data = $this->input->post();
            $data['createdDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->customer_model->create($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Customer created successfully');
            else
                $this->session->set_flashdata('error', 'Customer creation failed');
            
            redirect('customer/index');
        }
    }

    function checkEmail() {
        $email = $this->input->post("email");
        $userId = $this->input->post("userId");
        if (!isset($userId)) $userId = 0;
        $result = $this->customer_model->checkEmailExists($email, $userId);
        if (empty($result))
            echo("true");
        else
            echo("false");
    }
    
    function edit ($id) {
        if (!$id) redirect('customer/index');
        $record = $this->customer_model->getOne($id);
        $data['param'] = $record[0];

        $this->loadViews("editCustomer", $this->global, $data , NULL);
    }

    function update () {
        $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email Address','trim|required|valid_email|xss_clean|max_length[128]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($this->input->post('id'));
        }
        else
        {
            $data = $this->input->post();
            $data['updatedDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->customer_model->update($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Customer updated successfully');
            else
                $this->session->set_flashdata('error', 'Customer updation failed');
            
            redirect('customer/index');
        }
    }

    function delete () {
        $itemId = $this->input->post('itemId');
        $result = $this->customer_model->delete($itemId);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    function view ($id, $mode = 1, $view = 0, $param = null) {
        $this->global['pageTitle'] = 'PaymentPlan : Customer';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $data['customer'] = $this->customer_model->getOne($id)[0];

        $count = $this->plan_model->countAll($this->vendorId);
        $returns = $this->paginationCompress ("plan/index", $count, 10 );
        $plans = $this->plan_model->listAllCustomer($this->vendorId, $id, $searchText, $returns["page"], $returns["segment"]);

        $summaries = array();
        $declined = array();
        $billed = array();
        $futurePayments = array();
        $total = array('totalAmount' => 0, 'paid' => 0, 'due' => 0);
        $totalDeclined = 0;
        $totalBilled = 0;
        $totalFuture = 0;

        foreach ($plans as $index => $plan) {
            $summary = array('totalAmount' => 0, 'paid' => 0, 'due' => 0, 'remainingPayments' => 0);
            $payments = $this->payment_model->listAllPlan ($this->vendorId, $plan->id);
            foreach ($payments as $pIndex => $payment) {
                $summary['totalAmount'] += $payment->amount;
                if ($payment->status == 0) {
                    $summary['due'] += $payment->amount;
                    $summary['remainingPayments'] ++;

                    $futurePayment = array('title' => $plan->title, 'payment' => $payment);
                    array_push($futurePayments, $futurePayment);
                    $totalFuture += $payment->amount;
                } else if ($payment->status == 1) {
                    $summary['paid'] += $payment->amount;

                    $bill = array('title' => $plan->title, 'payment' => $payment);
                    array_push($billed, $bill);
                    $totalBilled += $payment->amount;
                } else {
                    $decline = array('title' => $plan->title, 'payment' => $payment);
                    array_push($declined, $decline);
                    $totalDeclined += $payment->amount;
                }
            }
            $summaries[$index] = $summary;
            $total['totalAmount'] += $summary['totalAmount'];
            $total['paid'] += $summary['paid'];
            $total['due'] += $summary['due'];
        }

        $data['summaries'] = $summaries;
        $data['declined'] = $declined;
        $data['billed'] = $billed;
        $data['futurePayments'] = $futurePayments;
        $data['total'] = $total;
        $data['totalDeclined'] = $totalDeclined;
        $data['totalBilled'] = $totalBilled;
        $data['totalFuture'] = $totalFuture;

        $data['plans'] = $plans;
        $data['userId'] = $this->vendorId;
        $data['mode'] = $mode;
        $data['view'] = $view;
        $data['param'] = $param;
        
        $this->loadViews("viewCustomer", $this->global, $data , NULL);
    }

    function viewPlan ($id, $mode = 1, $view = 0, $param = null) {
        $this->global['pageTitle'] = 'PaymentPlan : Plan';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;
        $data['plan'] = $this->plan_model->getOne($id)[0];

        $payments = $this->payment_model->listAllPlan($this->vendorId, $id, $searchText);
        $data['payments'] = $payments;

        $data['userId'] = $this->vendorId;
        $data['mode'] = $mode;
        $data['view'] = $view;
        $data['param'] = $param;

        $this->loadViews("viewPlan", $this->global, $data , NULL);
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PaymentPlan : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>