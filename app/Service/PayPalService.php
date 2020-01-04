<?php

namespace App\Service;

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payout;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPalService
{
    // apiContext
    private $apiContext;

    /**
     * PayPalService constructor.
     */
    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('paypal.account.client_id'),
                config('paypal.account.secret')
            )
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }


    /**
     * Payout
     * @param $email
     * @param $value
     * @return \PayPal\Api\PayoutBatch
     */
    public function createPayout($email, $value)
    {
        // Create a new instance of Payout object
        $payouts = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        // ### NOTE:
        // You can prevent duplicate batches from being processed. If you specify a `sender_batch_id` that was used in the last 30 days, the batch will not be processed. For items, you can specify a `sender_item_id`. If the value for the `sender_item_id` is a duplicate of a payout item that was processed in the last 30 days, the item will not be processed.

        // #### Batch Header Instance
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a payment");


        // #### Sender Item
        // Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem = new PayoutItem(
            array(
                "recipient_type" => "EMAIL",
                "receiver" => $email,
                "note" => "Thank you.",
                "sender_item_id" => uniqid(),
                "amount" => array(
                    "value" => $value,
                    "currency" => "USD"
                )

            )
        );

        $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);


        // ### Create Payout
        try {
            $output = $payouts->create(null, $this->apiContext);
        } catch (\Exception $ex) {
            abort('424');
        }

        return $output;
    }






}