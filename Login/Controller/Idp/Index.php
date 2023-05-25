<?php
namespace Tatix\Login\Controller\Idp;



class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_httpservice;

    protected $resultJsonFactory;

    protected $helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Tatix\Login\Helper\Data $helper
    ){
        $this->_pageFactory = $pageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {

        $_Idp = $this->getRequest()->getParam('idp');

        $result = $this->resultJsonFactory->create();

        $html = '';

        if ($_Idp !==  "SL") {

            $values = json_decode($this->helper->getMsoJson());

            foreach ($values as $value){
                if ($value->countryCode == $_Idp){

                    foreach ($value->idp as $value2){
                        $html.='<option value="'.$value2->shortName.'">'.strtoupper($value2->description).'</option>';
                    }
                }

            }

        }

        return $result->setData(['success' => true,'value'=>$html]);

    }
}
