<?php

namespace App\Service;

use Eway\Rapid;
use Eway\Rapid\Client;
use Eway\Rapid\Enum\ApiMethod;
use Eway\Rapid\Enum\TransactionType;

class EwayService
{
    private $client;

    /**
     * EwayService constructor.
     */
    public function __construct()
    {
        $this->client = Rapid::createClient(
            config('eway.apiKey'),
            config('eway.apiPassword'),
            Client::MODE_PRODUCTION // Use MODE_PRODUCTION when you go live
        );
    }


    /**
     * Set credit card
     * @param $billing
     * @param $data
     * @return Rapid\Model\Response\CreateCustomerResponse
     */
    public function setCreditCard($billing, $data)
    {
        $customer = [
            'Title' => 'Mr.',
            'FirstName' => $billing->first_name,
            'LastName' => $billing->last_name,
            'Country' => 'nz',
            'CardDetails' => [
                'Name' => $data['holder-name'],
                'Number' => $data['EWAY_CARDNUMBER'],
                'ExpiryMonth' => $data['expire-month'],
                'ExpiryYear' => $data['expire-year'],
                'CVN' => $data['EWAY_CARDCVN'],
            ]
        ];

        return $this->client->createCustomer(ApiMethod::DIRECT, $customer);

    }


    /**
     * Get credit card from eway servers
     * @param $cardId
     * @return Rapid\Model\Response\QueryCustomerResponse
     */
    public function getCreditCard($cardId)
    {
        return $this->client->queryCustomer($cardId);
    }


    /**
     * Create payment
     * @param array $data
     * @return array
     */
    public function createPayment(array $data)
    {
        $transaction = [
            'Customer' => [
                'TokenCustomerID' => $data['card-id'],
            ],
            'Payment' => [
                'TotalAmount' => $data['price'],
                'InvoiceDescription' => $data['transaction-description'],
                'CurrencyCode' => 'NZD',
            ],
            'TransactionType' => TransactionType::RECURRING,
        ];

        $response = $this->client->createTransaction(ApiMethod::DIRECT, $transaction);

        return ['transaction-status' => $response->TransactionStatus, 'transaction-id' => $response->TransactionID];
    }
}