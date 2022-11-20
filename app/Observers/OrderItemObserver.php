<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Traits\Observers\UploadsManipulation;
use App\Traits\Observers\AttributesManipulation;

class OrderItemObserver
{
    use AttributesManipulation;
    use UploadsManipulation;
    
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;

    /**
     * Handle the OrderItems "saved" event.
     *
     * @param Product $order_item
     * @return void
     */
    public function saved(OrderItem $order_item)
    {

    }

    /**
     * Handle the OrderItems "deleting" event.
     *
     * @param OrderItem $order_item
     * @return void
     */
    public function deleted(OrderItem $order_item)
    {
        // DONE: Added model attributes relationships and values removal
        // TODO: Add uploads-relations removal from UploadsManipulation.php trait

        $this->removeModelCustomAttributes($order_item);
    }
}
