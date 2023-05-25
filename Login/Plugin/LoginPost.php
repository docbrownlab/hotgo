<?php


namespace Tatix\Login\Plugin;

use \PHPUnit\Runner\Exception;
use \Tatix\Login\Helper\Data;
use \Magento\Customer\Model\Session;
use \Magento\Framework\Controller\ResultFactory;
use \Tatix\Login\Logger\Logger;

class LoginPost
{

    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var Session
     */
    protected $_customerSession;
    /**
     * @var ResultFactory
     */
    protected $resultRedirectFactory;

    const TYPE_LOGIN_CLAXSON = 'D2C';

    /**
     * @var Logger
     */
    protected $_logger;

    public function __construct(
        Data $helper,
        Session $session,
        ResultFactory $resultRedirectFactory,
        Logger $logger
    ){
        $this->helper = $helper;
        $this->_customerSession = $session;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->_logger = $logger;
    }

    /**
     * @param \Magento\Customer\Controller\Account\LoginPost $subject
     * @param $result
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|mixed
     */
    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result
    ) {

        if ($subject->getRequest()->getOriginalPathInfo() === "/customer/account/loginPost/"){

            if ($this->_customerSession->isLoggedIn()) {

                try {

                    $postLogin = $subject->getRequest()->getPost('login');
                    $returnToken = $this->helper->getTokenJwt($postLogin['username'], self::TYPE_LOGIN_CLAXSON);
                    $returnUrl = $this->helper->getGeneralConfig('claxson_login_url');
                    $result = $this->resultRedirectFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
                    $result->setPath("$returnUrl?jwt=$returnToken");

                }catch (Exception $e){
                    $this->_logger->info($e->getMessage());
                }

            }

       }

        return $result;

    }
}
