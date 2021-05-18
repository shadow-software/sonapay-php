<?php

namespace SonaPay\API;

class TransactionResponse extends AbstractResponse {
    protected $transactionid;

    protected $avsresponse;

    protected $cvvresponse;

    protected $type;

    protected $cc_number;

    protected $checkaba;

    protected $customer_vault_id;

    protected $checkaccount;

    public function __construct($data = [])
    {
        foreach($data as $key => $param) {
            $this->$key = $param;
        }
    }

    public function getTransactionID() {
        return $this->transactionid;
    }

    public function getAVSResponse() {
        return $this->avsresponse;
    }

    public function getCVVResponse() {
        return $this->cvvresponse;
    }

    public function getType() {
        return $this->type;
    }

    public function getCCNumber() {
        return $this->cc_number;
    }

    public function getCheckAba() {
        return $this->checkaba;
    }

    public function getCustomerVaultID() {
        return $this->customer_vault_id;
    }

    public function getCheckAccount() {
        return $this->checkaccount;
    }
}