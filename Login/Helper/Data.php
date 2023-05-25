<?php


namespace Tatix\Login\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH_TATIXCONFIG = 'tatixconfig/';

    public function getTokenJwt(string $userId, string $typeLogin):string
    {

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = [
            'sub' => $userId,
            'aud' => $typeLogin,
            'exp' => date('Y-m-d H:i:s', strtotime('+24 Hours'))
        ];
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $password = $this->getGeneralConfig('claxson_jwt_pass');

        $signature = hash_hmac('sha256',"$header.$payload",$password,true);
        $signature = base64_encode($signature);


        return "$header.$payload.$signature";
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_TATIXCONFIG .'general/'. $code, $storeId);
    }

    public function getMsoJson()
    {
        $client = new \GuzzleHttp\Client();

        $uri = $this->getConfigValue(self::XML_PATH_TATIXCONFIG .'general_toolbox/toolbox_login_url');
        $cp = $this->getConfigValue(self::XML_PATH_TATIXCONFIG .'general_toolbox/toolbox_chave_cp');
        $token = $this->getConfigValue(self::XML_PATH_TATIXCONFIG .'general_toolbox/toolbox_token');
        $response = $client->get($uri."v2/auth/$cp/mso.json?access_token=$token");

        return $response->getBody()->getContents();

    }
}
