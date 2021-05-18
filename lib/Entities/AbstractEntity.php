<?php

namespace SonaPay\Entities;

abstract class AbstractEntity
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    protected function request($params)
    {
        return $this->getClient()->request($params);
    }

    protected function processRequest($response)
    {
        $response_body = $response->getBody()->getContents();
        $data = [];
        parse_str($response_body, $data);
        return $data;
    }
}