<?php

namespace Tatix\Login\Block\Form;

use \Tatix\Login\Helper\Data;

use \Magento\Framework\View\Element\Template\Context ;
use \Magento\Customer\Model\Session ;
use \Magento\Customer\Model\Url ;

class Login extends  \Magento\Customer\Block\Form\Login
{

    /**
     * @var Data
     */
    protected $helper;

    public function __construct(
        Context $context,
        Session $customerSession,
        Url $customerUrl,
        Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $customerSession, $customerUrl, $data);

    }

    public function getCountries()
    {
        $_countries["SL"] =  "-- SELECIONE -- ";
        $values = json_decode($this->helper->getMsoJson());

        foreach ($values as $value){

            $_countries[$value->countryCode] =  strtoupper($value->country) ;
        }
        asort($_countries);

        return $_countries;
    }

    public function getUrlSubmitToolbox()
    {
        return $this->getBaseUrl() . "toolbox/index/index";
    }

    public function getUrlIdp(){
        return $this->getBaseUrl() . "toolbox/idp/index";
    }
}
