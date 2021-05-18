<?php

namespace SonaPay;
use SonaPay\Entities\Transaction;
use SonaPay\Entities\Customer;

class EntityAbstractor {

    private $client;

    private $entites;

    public function __construct($client) 
    {
        $this->client = $client;
        $this->entities = [];
    }

    private static $entityRegistry = [
        'transaction' => Transaction::class,
        'customer' => Customer::class,
    ];

    public function __get($name) {
        $entityClass = $this->getEntityClass($name);
        if ($entityClass !== null) {
            if (!array_key_exists($name, $this->entities)) {
                $this->entities[$name] = new $entityClass($this->client);
            }
            return $this->entities[$name];
        }

        return null;
    }

    protected function getEntityClass($name)
    {
        return array_key_exists($name, self::$entityRegistry) ? self::$entityRegistry[$name] : null;
    }
}