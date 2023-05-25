<?php
namespace Tatix\ForgotEmail\Controller\Account;

use \Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use \Magento\Customer\Api\AccountManagementInterface;
use \Magento\Customer\Model\AccountManagement;
use \Magento\Customer\Model\Session;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Escaper;
use \Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Framework\Exception\SecurityViolationException;
use  \Tatix\ForgotEmail\Model\ForgotEmail as ForgotEmailModel;


class ForgotEmailPost extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    protected $_model;

    protected $_escaper;
    
    public function __construct(
        Context $context, 
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Escaper $escaper,
        ForgotEmailModel $model
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_model = $model;
        $this->escaper = $escaper;
        parent::__construct($context);

    }

    
    public function execute()
    {
       
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $taxvat = (string)$this->getRequest()->getPost('taxvat');

        if ($taxvat) {
            $email = $this->_model->get($taxvat);
            if ($email) {
                $this->messageManager->addSuccessMessage($this->getSuccessMessage($email));
                return $resultRedirect->setPath('*/*/');
            }  else {
                $this->messageManager->addErrorMessage($this->getErrorMessage());
                return $resultRedirect->setPath('*/*/');
            }
          
        }
    }


    protected function getSuccessMessage($email)
    {
        $message =__('Your email is: ') . $email;
        return $message;
    }

    protected function getErrorMessage()
    {
        
        $message =__('The Taxvat informed does not have an account.');
        return $message;
    }
}
