<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Plan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plan_model');
        $this->load->model('customer_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index($view = 0, $param = null)
    {
        $this->global['pageTitle'] = 'PaymentPlan : Plan';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->plan_model->countAll($this->vendorId);
        $returns = $this->paginationCompress ("plan/index", $count, 10 );
        $data['records'] = $this->plan_model->listAll($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
        $data['customers'] = $this->customer_model->listAll($this->vendorId);
        $data['userId'] = $this->vendorId;

        $data['view'] = $view;
        $data['param'] = $param;
        
        $this->loadViews("plan", $this->global, $data , NULL);
    }

    function create ($customerId = 0) {
        $this->form_validation->set_rules('title','Title','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('customerId','Customer','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index(1);
        }
        else
        {
            $data = $this->input->post();
            $data['createdDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->plan_model->create($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Plan created successfully');
            else
                $this->session->set_flashdata('error', 'Plan creation failed');
            
            if ($customerId == 0)
                redirect('plan/index');
            else
                redirect('customer/view/' . $customerId);
        }
    }
    
    function edit ($id) {
        if (!$id) redirect('plan/index');
        $record = $this->plan_model->getOne($id);
        $data['customers'] = $this->customer_model->listAll($this->vendorId);
        $data['param'] = $record[0];

        $this->loadViews("editPlan", $this->global, $data , NULL);
    }

    function update () {
        $this->form_validation->set_rules('title','Title','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('customerId','Customer','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($this->input->post('id'));
        }
        else
        {
            $data = $this->input->post();
            $data['updatedDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->plan_model->update($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Plan updated successfully');
            else
                $this->session->set_flashdata('error', 'Plan updation failed');
            
            redirect('plan/index');
        }
    }

    function delete () {
        $itemId = $this->input->post('itemId');
        $result = $this->plan_model->delete($itemId);
        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PaymentPlan : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>