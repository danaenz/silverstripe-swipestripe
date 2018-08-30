<?php
declare(strict_types=1);

namespace SwipeStripe\Order;

use SilverStripe\Omnipay\Model\Payment;
use SilverStripe\Omnipay\Service\ServiceResponse;
use SilverStripe\ORM\DataExtension;

/**
 * Class PaymentExtension
 * @package SwipeStripe\Order
 * @property Payment|PaymentExtension $owner
 * @property int $OrderID
 * @method null|Order Order()
 */
class PaymentExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_one = [
        'Order' => Order::class,
    ];

    /**
     * @param ServiceResponse $response
     */
    public function onCaptured(ServiceResponse $response): void
    {
        if ($this->Order()->exists()) {
            $this->Order()->paymentCaptured($this->owner, $response);
        }
    }
}
