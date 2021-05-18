<?php

namespace SonaPay\Entities;

class Customer extends AbstractEntity implements EntityInterface 
{
    const VAULT_ACTIONS = ['add_customer', 'update_customer', 'delete_customer'];

    const ACTION_ADD_CUSTOMER = 'add_customer';
    const ACTION_UPDATE_CUSTOMER = 'update_customer';
    const ACTION_DELETE_CUSTOMER = 'delete_customer';

    public $customer_vault;

    public $billing_id;

    // --- Credit Card Data
    public $ccnumber;
    public $ccexp;

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
    public $shipping_id;
    public $shipping_firstname;
    public $shipping_lastname;
    public $shipping_company;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_city;

    // --- Transaction Data
    public $source_transaction_id;

    public function create($params = [], $opts = []) 
    {
        $params['customer_vault'] = self::ACTION_ADD_CUSTOMER;
        $response = $this->request($params);

        $data = $this->processRequest($response);

        return new \SonaPay\API\TransactionResponse($data);
    }

    public function update($params = [], $opts = [])
    {
        if (!array_key_exists('customer_vault_id', $params) || empty($params['customer_vault_id'])) {
            throw new \SonaPay\Exception\InvalidArgumentException("You need to supply a customer vault id.");
        }

        $params['customer_vault'] = self::ACTION_UPDATE_CUSTOMER;
        $response = $this->request($params);

        $data = $this->processRequest($response);

        return new \SonaPay\API\TransactionResponse($data);
    }

    public function delete($params = [], $opts = [])
    {
        if (!array_key_exists('customer_vault_id', $params) || empty($params['customer_vault_id'])) {
            throw new \SonaPay\Exception\InvalidArgumentException("You need to supply a customer vault id.");
        }

        $params['customer_vault'] = self::ACTION_DELETE_CUSTOMER;
        $response = $this->request($params);

        $data = $this->processRequest($response);

        return new \SonaPay\API\TransactionResponse($data);
    }
}