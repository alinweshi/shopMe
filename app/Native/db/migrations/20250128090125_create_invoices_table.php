<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateInvoicesTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        // Create the invoices table
        $table = $this->table('invoices', ['id' => 'integer', 'signed' => false, 'identity' => true]);
        if (!$this->hasTable('invoices')) {

            // Add columns
            $table->addColumn('invoice_number', 'string', ['limit' => 255, 'null' => false]) // Unique invoice number
                ->addIndex(['invoice_number'], ['unique' => true]) // Unique and indexed

                ->addColumn('order_id', 'biginteger', ['null' => false]) // Link to orders table
                ->addColumn('user_id', 'biginteger', ['null' => true])  // Link to users table (nullable)

                ->addColumn('subtotal', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false]) // Subtotal
                ->addColumn('tax', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true]) // Tax amount
                ->addColumn('discount_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true]) // Discount
                ->addColumn('shipping_fee', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true]) // Shipping fee
                ->addColumn('total', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false]) // Total amount

                ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'KD']) // Currency
                ->addColumn('status', 'enum', ['values' => ['pending', 'paid', 'canceled', 'refunded'], 'default' => 'pending']) // Status

                ->addColumn('billed_at', 'timestamp', ['null' => true]) // Billing date
                ->addColumn('payment_date', 'timestamp', ['null' => true]) // Payment date
                ->addColumn('payment_method', 'string', ['limit' => 255, 'null' => true]) // Payment method

                ->addColumn('billing_address', 'string', ['limit' => 255, 'null' => true]) // Billing address
                ->addColumn('shipping_address', 'string', ['limit' => 255, 'null' => true]) // Shipping address
                ->addColumn('notes', 'text', ['null' => true]) // Notes

                ->addTimestamps() // Created_at and updated_at timestamps

                // Add foreign keys
                ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION']);

            // Create the table
            $table->create();
        }
    }
}
