<?php

namespace severApp\Controllers\Sendinblue;

use Exception;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\EmailCampaignsApi;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateEmailCampaign;
use SendinBlue\Client\Model\GetAccount;
use SendinBlue\Client\Model\SendSmtpEmail;

class SendinblueController
{
    protected array  $aData     = [];
    protected string $mailAPI   = 'https://api.sendinblue.com/v3/smtp/email';
    protected string $username  = '';
    protected string $code      = '';
    private string   $apiKey    = '';
    private array    $aReceiver = [];

    public function __construct()
    {
        $this->apiKey = "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";
    }

    public function setReceiver($email, $name): SendinblueController
    {
        $this->aReceiver = [
            [
                'email' => $email,
                'name'  => $name
            ]
        ];
        return $this;
    }

    public function setUsername($username): SendinblueController
    {
        $this->username = $username;
        return $this;
    }

    public function setCode($code): SendinblueController
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function sendMail(): bool
    {
        $aData = [];
        $oInfo = $this->getInfoAccount();
        $aData = [
            'sender' => [
                'name'  => 'Peaceful Hotel',
                'email' => $oInfo->getEmail()
            ],
            'type'   => 'classic'
        ];
        $aData['subject'] = 'Hello, You can reset password';
        $aData['to'] = $this->aReceiver;
        $aData['htmlContent'] = sprintf('<html>
                    <head>Peaceful Hotel</head>
                                    <body>
                                    <p>Username: %s</p>
                                    <p>If this was a mistake, just ignore this email and nothing will happen.To reset your password,code %s</p>
                                    </body>
                    </html>', $this->username, $this->code);
        //var_dump($headers);die();
        $curl = curl_init();
        $jData = json_encode($aData);
      ///  header("Content-Type: application/json; charset=UTF-8");
       // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,
        // X-Requested-With");
        curl_setopt($curl, CURLOPT_URL, $this->mailAPI);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jData);
        //curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeadersCurl());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($curl);
        curl_close($data);
        return true;
    }

    public function getInfoAccount(): GetAccount
    {
        try {
            //get Account info
            $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->apiKey);
            $apiInstance = new AccountApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
                new Client(),
                $config
            );

            return $apiInstance->getAccount();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getHeadersCurl(): array
    {
        return [
            'accept: application/json',
            'api-key: ' .$this->apiKey,
            'content-type: application/json',
        ];
    }
}