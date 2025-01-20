<?php

namespace App\Interfaces\Payments;

interface PaymentServiceInterface
{
    public function sendPayment(array $paymentData, int $orderId): array;
    public function saveTransactionData(array $data): array;
    public function updatePaymentStatus(array $data): array;
    public function getPaymentStatus(array $data): array;
}
