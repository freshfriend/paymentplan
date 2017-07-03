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
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the plan
     */
    public function index()
    {
        redirect('/dashboard');
    }
    
    /**
     * This function is used to load the plan list
     */
    function planListing()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->model('plan_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->plan_model->planListingCount($searchText);

			$returns = $this->paginationCompress ( "planListing/", $count, 10 );

            $data['planRecords'] = $this->plan_model->planListing($searchText, $returns["page"], $returns["segment"]);
            $data['segment'] = $returns["segment"];
            
            $this->global['pageTitle'] = 'PaymentPlan : Plan Listing';
            
            $this->loadViews("plans", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNewPlan()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->model('plan_model');
            $this->load->model('user_model');
            $data['customers'] = $this->user_model->userListing();
            $data['userId'] = $this->vendorId;
            
            $this->global['pageTitle'] = 'PaymentPlan : Add New Plan';

            $this->loadViews("addNewPlan", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to add new plan to the system
     */
    function onAddNewPlan()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric|xss_clean|max_length[11]|great_than[0]');
            $this->form_validation->set_rules('payDate','Pay Date','required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewPlan();
            }
            else
            {
                $title = $this->input->post('title');
                $summary = $this->input->post('summary');
                $amount = $this->input->post('amount');
                $payDate = $this->input->post('payDate');
                
                $planInfo = array('title'=>$title, 'summary'=>$summary, 'amount'=>$amount, 'payDate'=> $payDate,
                                    'userId'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('plan_model');
                $result = $this->plan_model->addNewPlan($planInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Plan created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Plan creation failed');
                }
                
                redirect('planListing');
            }
        }
    }

    
    /**
     * This function is used load plan edit information
     * @param number $planId : Optional : This is plan id
     */
    function editPlan($planId = NULL)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            if($planId == null)
            {
                redirect('planListing');
            }
            
            $data['planInfo'] = $this->plan_model->getPlanInfo($planId);
            $data['mode'] = 0;
            
            $this->global['pageTitle'] = 'PaymentPlan : Edit Plan';
            
            $this->loadViews("editPlan", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used load plan view information
     * @param number $planId : Optional : This is plan id
     */
    function viewPlan($planId = NULL)
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            if($planId == null)
            {
                redirect('planListing');
            }
            
            $data['planInfo'] = $this->plan_model->getPlanInfo($planId);
            $data['mode'] = 1;
            
            $this->global['pageTitle'] = 'PaymentPlan : Edit Plan';
            
            $this->loadViews("editPlan", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the plan information
     */
    function onEditPlan()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->library('form_validation');
            
            $planId = $this->input->post('planId');
            
            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric|xss_clean|max_length[11]|great_than[0]');
            $this->form_validation->set_rules('payDate','Pay Date','required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editPlan($planId);
            }
            else
            {
                $userId = $this->input->post('userId');
                $title = $this->input->post('title');
                $summary = $this->input->post('summary');
                $amount = $this->input->post('amount');
                $payDate = $this->input->post('payDate');
                $status = $this->input->post('status');
                
                $planInfo = array('title'=>$title, 'summary'=>$summary, 'amount'=>$amount, 'payDate'=> $payDate, 'status' => $status,
                                    'userid'=>$userId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('plan_model');
                $result = $this->plan_model->editPlan($planInfo, $planId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'New Plan updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Plan updation failed');
                }
                
                redirect('planListing');
            }
        }
    }


    /**
     * This function is used to delete the plan using planId
     * @return boolean $result : TRUE / FALSE
     */
    function deletePlan()
    {
        /*if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else*/
        {
            $planId = $this->input->post('planId');
            $planInfo = array('isDeleted'=>1, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->plan_model->deletePlan($planId, $planInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PaymentPlan : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>