<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRepository
{
    /**
     * Update the status of an order.
     *
     * @param int $orderId
     * @param string $status
     * @throws ModelNotFoundException
     */
    public function updateOrderStatus(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();
    }

    /**
     * Save a transaction.
     *
     * @param array $transactionData
     * @return Transaction
     */
    public function saveTransaction(array $transactionData): Transaction
    {
        return Transaction::create($transactionData);
    }

    /**
     * Find an order by invoice number.
     *
     * @param string $invoiceNumber
     * @return Order|null
     */
    public function findOrderByInvoiceNumber(string $invoiceNumber): ?Order
    {
        return Order::where('invoice_number', $invoiceNumber)->first();
    }
}
