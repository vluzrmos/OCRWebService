<?php

namespace OCRWebService;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use OCRWebService\Response\AccountInformation;
use OCRWebService\Response\ProcessDocument;

class OCRWebService
{
    /**
     * Account username.
     * @var string
     */
    protected $user;

    /**
     * Account license key.
     * @var string
     */
    protected $key;

    /**
     * Base api url.
     * @var string
     */
    protected $apiUrl = "https://www.ocrwebservice.com/restservices";

    /**
     * Path to SSL certication file, true to auto detect or false to disable ssl verification.
     * @var bool|string
     */
    protected $verify = false;

    /**
     * Guzzle Http Client.
     * @var Client
     */
    protected $client;

    /**
     * OCRWebServiceManager constructor.
     * @param string $user
     * @param string $key
     */
    public function __construct($user, $key)
    {
        $this->user = $user;
        $this->key = $key;
    }

    /**
     * Perform an OCR into a document.
     * @param string $file Path to the file to be processed.
     * @param array $options Processing options
     * @return array
     */
    public function processDocument($file, $options = [])
    {
        $options = array_merge([
            'gettext' => 'true', 
            'pagerange' => 'allpages', 
            'language' => 'brazilian'
        ], $options);

        $client = $this->getHttpClient();

        $response = $client->post(__FUNCTION__, [
            'query' => $options,
            'body' => fopen($file, 'r')
        ]);
        
        $data = $this->responseToArray($response);

        return new ProcessDocument($data);
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return $this->client ? $this->client : $this->createHttpClient();
    }

    /**
     * Set default http client.
     * @param Client|null $client
     * @return Client
     */
    protected function createHttpClient()
    {
        if (!$this->client) {
            $baseUri = rtrim($this->apiUrl, ' /\\').'/';
            $auth =  [$this->user, $this->key];

            //both ~5.3 and ~6.0 compatibility
            $this->client = new Client([
                'base_uri' => $baseUri,
                'base_url' => $baseUri,
                'verify' => $this->verify,
                'auth' => $auth,
                'defaults' => [
                    'verify' => $this->verify,
                    'auth' => $auth,
                ]
            ]);
        }

        return $this->client;
    }

    /**
     * Converte a json respose into array.
     * @param $response
     * @return array
     */
    protected function responseToArray($response)
    {
        $body = (string)$response->getBody();

        return json_decode($body, true);
    }

    /**
     * Get information about the user account.
     * @return array
     */
    public function getAccountInformation()
    {
        $client = $this->getHttpClient();

        $response = $client->get(__FUNCTION__);

        $data = $this->responseToArray($response);

        return new AccountInformation($data);
    }

}