<?php
namespace Tatix\ForgotEmail\Model;

use Tatix\ForgotEmail\Api\ForgotEmailInterface;
use \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use \Magento\Framework\UrlInterface;

class ForgotEmail extends \Magento\Framework\Model\AbstractModel  implements ForgotEmailInterface
{

    protected $_customerFactory;

    protected $_urlBuilder;

    public function __construct(CollectionFactory $customerFactory, UrlInterface $urlInterface) 
    {
        $this->_customerFactory = $customerFactory;
        $this->_urlInterface = $urlInterface;
        
    }

    /**
     * {@inheritdoc}
    */
    public function get($taxvat)
    {
        $customerCollection = $this->getCustomerCollection();

        foreach ($customerCollection as $customer) {
            if ($customer->getTaxvat() == $taxvat) {
                return $this->maskEmail($customer->getEmail());
            }
          
        }      
    }

    public function getCustomerCollection() 
    {
        return $this->_customerFactory->create();
    }


    public function maskEmail($email){
        $em   = explode("@",$email);
        $name = implode(array_slice($em, 0, count($em)-1), '@');
        $len  = floor(strlen($name)/2);
        return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
        
    }
    
    public function getForgotEmailUrl()
    {
        return $this->_urlBuilder->getUrl('customer/account/forgotemail');
    }

}
