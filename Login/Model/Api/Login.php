<?php

namespace Tatix\Login\Model\Api;

use \Tatix\Login\Api\LoginInterface;
use \Magento\Integration\Api\CustomerTokenServiceInterface;
use \Tatix\Login\Helper\Data;
use \Magento\Framework\Webapi\Exception as ApiException;

class Login implements LoginInterface
{
    const TYPE_LOGIN_CLAXSON = 'D2C';

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Integration\Api\CustomerTokenServiceInterface
     */
    protected $customerTokenService;

    /**
     * @param Data $helper
     * @param CustomerTokenServiceInterface $customerTokenService
     */
    public function __construct(
        Data $helper,
        CustomerTokenServiceInterface $customerTokenService
    )
    {
        $this->helper = $helper;
        $this->customerTokenService = $customerTokenService;
    }

    /**
     * @inheritdoc
     */

    public function getPost(
        $usuario  = null,
        $senha  = null,
        $pais  = null,
        $operadora  = null
    )
    {

        try {

                if ($this->checkParameteres( [$usuario , $senha ,  $pais ,  $operadora ] )) {

                    if ($usuario){
                        $token = $this->customerTokenService->createCustomerAccessToken($usuario, $senha);
                        $returnToken = $this->helper->getTokenJwt($usuario, self::TYPE_LOGIN_CLAXSON);
                        $response = ['success' => true, 'token' => $token, 'jwt' => $returnToken];

                    }else{

                        //TODO implementar toolbox
                    }

                } else {
                    $this->processResponseError ("Some required fields are empty. See documentation.");
                }

        } catch (\Exception $e) {
            $this->processResponseError ($e->getMessage());
        }

        return json_encode($response);
    }

    /**
     * Check if the fields are filled and match their pairs
     * @param array $parameters
     * @return bool
     */
    private function checkParameteres(array $parameters): bool
    {
        $filled = false;

        foreach ($parameters as $parameter) {
            if (isset($parameter) && strlen($parameter) > 0) {
                $filled = true;
            }
        }

        if ($filled) {

            if ((isset($parameters[0]) && !isset($parameters[1])) || (!isset($parameters[0]) && isset($parameters[1]))) {
                $filled = false;
            }

            if ((isset($parameters[2]) && !isset($parameters[3])) || (!isset($parameters[2]) && isset($parameters[3]))) {
                $filled = false;
            }

        }

        return $filled;
    }


    /**
     * @param string $message
     * @throws ApiException
     */
    private function processResponseError(string $message){
        throw new ApiException(__($message), 401, 401);
    }
}
