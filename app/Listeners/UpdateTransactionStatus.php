<?php

namespace App\Listeners;

use App\Events\TransactionsStatusChanged;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTransactionStatus
{
    public function handle(TransactionsStatusChanged $event)
    {
        $data = $event->data;

        Log::info('Handling TransactionsStatusChanged', ['data' => $data]);

        // Validate the essential fields
        $transactionId = $data['TransactionId'] ?? null;
        $status = $data['TransactionStatus'] ?? null;

        if (! $transactionId || ! $status) {
            Log::warning('Missing required data for TransactionStatusChanged', ['data' => $data]);

            return;
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Retrieve the transaction record
            $transaction = Transaction::where('transaction_id', $transactionId)->first();

            if (! $transaction) {
                // Log warning if the transaction is not found
                Log::warning('Transaction not found', ['transaction_id' => $transactionId]);

                return;
            }

            // Update the transaction status
            $transaction->update([
                'status' => $status,
                'updated_at' => now(),
            ]);

            // Commit the transaction
            DB::commit();

            // Log success
            Log::info('Transaction status updated successfully', [
                'transaction_id' => $transactionId,
                'status' => $status,
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            // Log the error
            Log::error('Error updating transaction status', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId,
            ]);
        }
    }
}
