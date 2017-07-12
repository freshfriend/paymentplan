<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

require 'vendor/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Payment extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_model');
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
        $this->global['pageTitle'] = 'PaymentPlan : Payment';

        $searchText = $this->input->post('searchText');
        $data['searchText'] = $searchText;

        $count = $this->payment_model->countAll($this->vendorId);
        $returns = $this->paginationCompress ("payment/index", $count, 10 );
        $data['records'] = $this->payment_model->listAll($this->vendorId, $searchText, $returns["page"], $returns["segment"]);
        $data['plans'] = $this->plan_model->listAll($this->vendorId);
        $data['customers'] = $this->customer_model->listAll($this->vendorId);
        $data['userId'] = $this->vendorId;

        $data['view'] = $view;
        $data['param'] = $param;
        
        $this->loadViews("payment", $this->global, $data , NULL);
    }

    function create ($planId = 0) {
        $this->form_validation->set_rules('amount','Amount','trim|required|numeric|xss_clean|max_length[11]|great_than[0]');
        $this->form_validation->set_rules('dueDate','Due Date','required|xss_clean');
        //$this->form_validation->set_rules('customerId','Customer','trim|required');
        $this->form_validation->set_rules('planId','Plan','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $this->index(1);
        }
        else
        {
            $data = $this->input->post();
            $data['createdDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->payment_model->create($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Payment created successfully');
            else
                $this->session->set_flashdata('error', 'Payment creation failed');
            
            if ($planId == 0)
                redirect('payment/index');
            else
                redirect('customer/viewPlan/'.$planId);
        }
    }
    
    function edit ($id) {
        if (!$id) redirect('payment/index');
        $record = $this->payment_model->getOne($id);
        $data['plans'] = $this->plan_model->listAll($this->vendorId);
        $data['customers'] = $this->customer_model->listAll($this->vendorId);
        $data['userId'] = $this->vendorId;
        $data['param'] = $record[0];

        $this->loadViews("editPayment", $this->global, $data , NULL);
    }

    function update () {
        $this->form_validation->set_rules('amount','Amount','trim|required|numeric|xss_clean|max_length[11]|great_than[0]');
        $this->form_validation->set_rules('dueDate','Due Date','required|xss_clean');
        //$this->form_validation->set_rules('customerId','Customer','trim|required');
        $this->form_validation->set_rules('planId','Plan','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->edit($this->input->post('id'));
        }
        else
        {
            $data = $this->input->post();
            $data['updatedDtm'] = date('Y-m-d H:i:s');
            
            $result = $this->payment_model->update($data);
            
            if($result > 0)
                $this->session->set_flashdata('success', 'Payment updated successfully');
            else
                $this->session->set_flashdata('error', 'Payment updation failed');
            
            redirect('payment/index');
        }
    }

    function decline ($ses, $param, $id) {
        $payment = $this->payment_model->getOne($id);
        $result = $this->payment_model->updateStatus($payment[0]->id, 2);
        if ($ses == 1) {
            redirect ('customer/viewPlan/'.$param);
        } else if ($ses == 2) {
            redirect ('user/index/'.$param);
        }
    }

    function approve ($ses, $param, $id) {
        $payment = $this->payment_model->getOne($id);
        $plan = $this->plan_model->getOne($payment[0]->planId);
        $customer = $this->customer_model->getOne($plan[0]->customerId);
        $amount = $payment[0]->amount;
        /* Create a merchantAuthenticationType object with authentication details
           retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
        $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
        
        // Set the transaction's refId
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($customer[0]->cardNumber);
        $creditCard->setExpirationDate($customer[0]->expireDate);
        $creditCard->setCardCode($customer[0]->cardCode);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber("ID - " . $payment[0]->id);
        $order->setDescription($payment[0]->title);

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($customer[0]->name);
        $customerAddress->setLastName("");
        $customerAddress->setCompany($customer[0]->company);
        $customerAddress->setAddress($customer[0]->address);
        $customerAddress->setCity($customer[0]->city);
        $customerAddress->setState($customer[0]->state);
        $customerAddress->setZip($customer[0]->zipcode);
        $customerAddress->setCountry($customer[0]->country);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($customer[0]->id);
        $customerData->setEmail($customer[0]->email);

        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("60");

        // Add some merchant defined fields. These fields won't be stored with the transaction,
        // but will be echoed back in the response.
        //$merchantDefinedField1 = new AnetAPI\UserFieldType();
        //$merchantDefinedField1->setName("customerLoyaltyNum");
        //$merchantDefinedField1->setValue("1128836273");

        //$merchantDefinedField2 = new AnetAPI\UserFieldType();
        //$merchantDefinedField2->setName("favoriteColor");
        //$merchantDefinedField2->setValue("blue");

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authOnlyTransaction"); 
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
        //$transactionRequestType->addToUserFields($merchantDefinedField1);
        //$transactionRequestType->addToUserFields($merchantDefinedField2);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        $let = array();
        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == \SampleCode\Constants::RESPONSE_OK) {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
            
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $let['State'] = 'success';
                    $let["TransactionID"] = $tresponse->getTransId();
                    $let["TransactionResponseCode"] = $tresponse->getResponseCode();
                    $let["MessageCode"] = $tresponse->getMessages()[0]->getCode();
                    $let["AuthCode"] = $tresponse->getAuthCode();
                    $let["Description"] = $tresponse->getMessages()[0]->getDescription();
                } else {
                    $let['State'] = 'failed';
                    if ($tresponse->getErrors() != null) {
                        $let["ErrorCode"] = $tresponse->getErrors()[0]->getErrorCode();
                        $let["ErrorMessage"] = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
            } else {
                $let['State'] = 'failed';
                $tresponse = $response->getTransactionResponse();
            
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $let["ErrorCode"] = $tresponse->getErrors()[0]->getErrorCode();
                    $let["ErrorMessage"] = $tresponse->getErrors()[0]->getErrorText();
                } else {
                    $let["ErrorCode"] = $response->getMessages()->getMessage()[0]->getCode();
                    $let["ErrorMessage"] = $response->getMessages()->getMessage()[0]->getText();
                }
            }      
        } else {
            $let['State'] = 'noresponse';
        }

        //if ($let['State'] == 'success') {
            $result = $this->payment_model->updateStatus($payment[0]->id, 1);
            echo $result;
        //}

        //echo json_encode($let);
        if ($ses == 1) {
            redirect ('customer/viewPlan/'.$param);
        } else if ($ses == 2) {
            redirect ('user/index/'.$param);
        }
    }

    function delete () {
        $itemId = $this->input->post('itemId');
        $result = $this->payment_model->delete($itemId);
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