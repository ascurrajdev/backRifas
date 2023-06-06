<?php
namespace App\Services;
interface PaymentService{
    public function generateLink(string $description, int $amount);
    public function reversePayment(string $identifier);
}