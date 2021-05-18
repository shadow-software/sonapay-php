<?php

namespace SonaPay\Entities;

class Transaction extends AbstractEntity implements EntityInterface 
{
    const TRANSACTION_TYPES = ['sale', 'auth', 'refund', 'credit', 'validate', 'offline'];

    // --- Credit Card Data
    public $ccnumber;
    public $ccexp;
    public $cvv;

    // --- Customer Data
    public $first_name;
    public $last_name;
    public $company;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $phone;
    public $fax;
    public $email;
    public $drivers_license_number;
    public $drivers_license_dob;
    public $drivers_license_state;

    // --- Shipping Data
    public $shipping_firstname;
    public $shipping_lastname;
    public $shipping_company;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_city;

    // --- Transactional Data
    public $type;
    public $amount = 0.00;
    public $sucharge;
    public $cash_discount;
    public $currency;
    public $order_template;
    public $order_description;
    public $orderid;
    public $ipaddress;
    public $tax;
    public $shipping;
    public $ponumber;

    // --- Customer Vault Options
    const CUSTOMER_VAULT_OPTS = ['add_customer', 'update_customer'];
    public $customer_vault;
    public $customer_vault_id;

    public $required_fields = ['type', 'ccnumber', 'ccexp'];

    public function create($params = [], $opts = []) {
        $params['type'] = 'sale';
        $this->validate($params);

        $response = $this->request($params);
        $data = $this->processRequest($response);

        return new \SonaPay\API\TransactionResponse($data);
    }

    public function refund($params = [], $opts = []) {
        if (!array_key_exists('transactionid', $params) || empty($params['transactionid'])) {
            throw new \SonaPay\Exception\InvalidArgumentException("You need to supply a transactionid for refunds.");
        }
        $params['type'] = 'refund';

        $response = $this->request($params);
        $data = $this->processRequest($response);

        return new \SonaPay\API\TransactionResponse($data);
    }

    private function validate($params) {
        // General check
        /*
        foreach($this->required_fields as $required) {
            if(!array_key_exists($required, $params) || empty($params[$required])) {
                throw new \SonaPay\Exception\InvalidArgumentException("$required is a required key.");
            }
        }*/

        // Specific keys
        if(!in_array($params['type'], self::TRANSACTION_TYPES)) {
            throw new \SonaPay\Exception\InvalidArgumentException("Transaction type needs to be 'sale', 'auth', 'credit', 'validate' or 'offline'");
        }
    }
}