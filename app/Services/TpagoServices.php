<?php
namespace App\Services;
use App\Services\TpagoClient;
class TpagoServices implements PaymentService{
    private $tpagoClient;

    public function __construct(TpagoClient $client)
    {
        $this->tpagoClient = $client;
    }
    public function generateLink(string $description, int $amount){
        return $this->tpagoClient->post("generate-payment-link",[
            'amount' => $amount,
            'description' => $description,
            'require_user_data' => false
        ]);
    }
    public function reversePayment(string $identifier){
        return $this->tpagoClient->put("payments/revert/{$identifier}");
    }
}