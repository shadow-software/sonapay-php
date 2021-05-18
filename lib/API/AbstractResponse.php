<?php

namespace SonaPay\API;

abstract class AbstractResponse
{
    const RESPONSE_STATUSES = [
        1 => 'Transaction Approved',
        2 => 'Transaction Declined',
        3 => 'Error in transaction data or system error'
    ];

    const RESPONSE_SUCCESSFUL = 1;

    const RESULT_CODES = [
        100 => 'Transaction was approved.', 200 => 'Transaction was declined by processor.', 201 => 'Do not honor.', 202 => 'Insufficient funds.', 203 => 'Over limit.',
        204 => 'Transaction not allowed.', 220 => 'Incorrect payment information.', 221 => 'No such card issuer.', 222 => 'No card number on file with issuer.', 
        223 => 'Expired card.', 224 => 'Invalid expiration date.', 225 => 'Invalid card security code.', 226 => 'Invalid PIN.', 240 => 'Call issuer for further information.',
        250 => 'Pick up card.', 251 => 'Lost card.', 252 => 'Stolen card.', 253 => 'Fraudulent card.', 260 => 'Declined with further instructions available. (See response text)',
        261 => 'Declined-Stop all recurring payments.', 262 => 'Declined-Stop this recurring program.', 263 => 'Declined-Update cardholder data available.', 
        264 => 'Declined-Retry in a few days.', 300 => 'Transaction was rejected by gateway.', 400 => 'Transaction error returned by processor.', 410 => 'Invalid merchant configuration.',
        411 => 'Merchant account is inactive.', 420 => 'Communication error.', 421 => 'Communication error with issuer.', 430 => 'Duplicate transaction at processor.',
        440 => 'Processor format error.', 441 => 'Invalid transaction information.', 460 => 'Processor feature not available.', 461 => 'Unsupported card type.'
    ];

    protected $response;

    protected $response_code;

    protected $response_text;

    public function __construct($data = [])
    {
        if (array_key_exists('response', $data) && array_key_exists('response_code', $data) && array_key_exists('responsetext', $data)) {
            $this->response = $data['response'];
            $this->response_code = $data['response_code'];
            $this->response_text = $data['responsetext'];
        } else {
            throw new \SonaPay\Exception\InvalidArgumentException("Required response values were not provided.");
        }
    }

    public function getCode() {
        return $this->response_code;
    }

    public function getText() {
        $this->response_text;
    }

    public function getStatus() {
        return array_key_exists($this->response, self::RESPONSE_STATUSES) ? self::RESPONSE_STATUSES[$this->response] : 'Unknown status';
    }

    public function getDetails() {
        return array_key_exists($this->getCode(), self::RESULT_CODES) ? self::RESULT_CODES[$this->getCode()] : 'Unknown response code';
    }

    public function wasSuccessful() {
        return (int)$this->response === 1;
    }
}