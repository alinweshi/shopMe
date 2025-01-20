<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\productOrder;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ProductOrderObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the productOrder "created" event.
     */
    public function creating(Order $productOrder): voidweb
    {
        $productOrder->status = "pending";
        $productOrder->is_completed = false;
        $productOrder->is_paid = false;
        $productOrder->is_cancelled = false;
    }

    /**
     * Handle the productOrder "updated" event.
     */
    public function updated(Order $productOrder): void
    {
        //
    }

    /**
     * Handle the productOrder "deleted" event.
     */
    public function deleted(Order $productOrder): void
    {
        //
    }

    /**
     * Handle the productOrder "restored" event.
     */
    public function restored(Order $productOrder): void
    {
        //
    }

    /**
     * Handle the productOrder "force deleted" event.
     */
    public function forceDeleted(Order $productOrder): void
    {
        //
    }
}
