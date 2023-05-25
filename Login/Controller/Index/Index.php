<?php
namespace Tatix\Login\Controller\Index;



class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_httpservice;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ){
        $this->_pageFactory = $pageFactory;

        return parent::__construct($context);
    }

    public function execute()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("http://api-cert.tbxnet.com/v2/auth/hotgo_br/mso.json?access_token=1ujtCLeSJfgpoenQvaC73RjP98ibijJ8");
        $responseBody = $response->getBody()->getContents();

        return $this->_pageFactory->create();
    }
}
