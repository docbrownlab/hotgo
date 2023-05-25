<?php
namespace Tatix\ForgotEmail\Block\Account;

use \Magento\Customer\Model\Url;
use \Magento\Framework\View\Element\Template;

class Forgotemail extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Url
     */
    protected $customerUrl;

    /**
     * @param Template\Context $context
     * @param Url $customerUrl
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Url $customerUrl,
        array $data = []
    ) {
        $this->customerUrl = $customerUrl;
        parent::__construct($context, $data);
    }


    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */

    public function getFormAction()
    {
        return '/customer/account/forgotemail';
    }


    /**
     * Get login URL
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->customerUrl->getLoginUrl();
    }
}
