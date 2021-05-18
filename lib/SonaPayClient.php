<?php

namespace SonaPay;
use GuzzleHttp\Client;

class SonaPayClient {

    const API_BASE = "https://sonapay.transactiongateway.com/api/transact.php";

    private $config;

    private $defaultOpts;

    private $timeout = '5.0';

    private $entityAbstractor;

    public $client;

    const VERSION = '0.0.1';

    public function __construct($config = [])
    {
        if (is_string($config)) {
            $config = ['api_key' => $config];
        } else if (!is_array($config)) {
            throw new \SonaPay\Exception\InvalidArgumentException('$config must be a string or an array');
        }

        $config = array_merge($this->getDefaultConfig(), $config);
        $this->validateConfig($config);

        $this->config = $config;
        $this->client = new Client(
            [
                'base_uri' => $this->config['api_base'], 
                'timeout' => $this->config['timeout'],
                'curl' => [CURLOPT_SSL_VERIFYPEER => false]
            ]
        );
    }

    public function getApiKey() 
    {
        return $this->config['api_key'];
    }

    public function request($params) 
    {
        $response = $this->client->request('POST', $this->config['api_base'], [
            'query' => array_merge($params, ['security_key' => $this->getApiKey()])
        ]);
        
        return $response;
    }

    public function __get($name) 
    {
        if ($this->entityAbstractor === null) {
            $this->entityAbstractor = new \SonaPay\EntityAbstractor($this);
        }

        return $this->entityAbstractor->__get($name);
    }

    private function getDefaultConfig() 
    {
        return [
            'api_key' => null,
            'api_base' => self::API_BASE,
            'timeout' => $this->timeout,
            'currency' => 'cad'
        ];
    }

    private function validateConfig($config) 
    {
        if ($config['api_key'] !== null && !is_string($config['api_key'])) {
            throw new \SonaPay\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if ($config['currency'] === null || !is_string($config['currency'])) {
            throw new \SonaPay\Exception\InvalidArgumentException('currency must be a string');
        }
    }
}