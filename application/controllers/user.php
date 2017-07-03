<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('plan_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'PaymentPlan : Dashboard';

        $data['customers'] = $this->user_model->userListing();
        $data['customerCount'] = count($data['customers']);
        $today = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
        $lastmonth = date('Y-m-d', mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
        $lastyear = date('Y-m-d', mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")-1));
        $data['newCustomers'] = $this->user_model->newUserListing($lastmonth);
        $data['newCustomerCount'] = count($data['newCustomers']);
        $data['oldCustomers'] = $this->user_model->newUserListing($lastyear);
        $data['oldCustomerCount'] = count($data['oldCustomers']) == 0 ? 1 : count($data['oldCustomers']);
        $data['newCustomerRate'] = floor($data['newCustomerCount'] / $data['oldCustomerCount'] * 100);

        $data['plans'] = $this->plan_model->certainPlanListing($lastyear);
        $data['planCount'] = count($data['plans']);
        $data['activePlans'] = $this->plan_model->certainPlanListing($lastmonth, 1);
        $data['activePlanCount'] = count($data['activePlans']);
        $data['completePlans'] = $this->plan_model->certainPlanListing($lastmonth, 2);
        $data['completePlanCount'] = count($data['completePlans']);
        $data['outdatedPlans'] = $this->plan_model->outdatedPlanListing($lastmonth);
        $data['outdatedPlanCount'] = count($data['outdatedPlans']);
        $data['activePlanRate'] = floor(($data['activePlanCount']) / $data['planCount'] * 100);
        $data['completePlanRate'] = floor(($data['completePlanCount']) / $data['planCount'] * 100);
        $data['outdatedPlanRate'] = floor(($data['outdatedPlanCount']) / $data['planCount'] * 100);
        
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->model('user_model');
        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            $data['segment'] = $returns["segment"];
            
            $this->global['pageTitle'] = 'PaymentPlan : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'PaymentPlan : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            //$this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = 1;//$this->input->post('role');
                $mobile = $this->input->post('mobile');
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Customer created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Customer creation failed');
                }
                
                redirect('userListing');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        /*if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else*/
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'PaymentPlan : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }

    
    /**
     * This function is used load user information
     * @param number $userId : Optional : This is user id
     */
    function viewUser($userId = NULL)
    {
        /*if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else*/
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            $data['customerPlans'] = $this->plan_model->getCustomerPlans($userId);

            $status['totalPlan'] = 0;
            $status['totalPaid'] = 0;
            $status['remaining'] = 0;
            $planCount = count($data['customerPlans']);
            
            for ($i = 0; $i < $planCount; $i ++) {
                $plan = $data['customerPlans'][$i];

                if ($plan->status == 2)
                    $status['totalPaid'] += $plan->amount;
                else {
                    $status['totalPlan'] += $plan->amount;
                    $status['remaining'] ++;
                }
            }
            $data['status'] = $status;
            
            $this->global['pageTitle'] = 'PaymentPlan : View User';
            
            $this->loadViews("viewUser", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        /*if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else*/
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        /*if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else*/
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'PaymentPlan : Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PaymentPlan : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>