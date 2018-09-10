<?php
declare(strict_types=1);

namespace SwipeStripe\Tests\DataObjects;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\Versioned\Versioned;
use SwipeStripe\Order\PurchasableInterface;
use SwipeStripe\Price\DBPrice;

/**
 * Class TestPurchasable
 * @package SwipeStripe\Tests\DataObjects
 */
class TestProduct extends DataObject implements PurchasableInterface
{
    /**
     * @var array
     */
    private static $db = [
        'Title'       => DBVarchar::class,
        'Description' => DBVarchar::class,
        'Price'       => DBPrice::class,
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class => Versioned::class . '.versioned',
    ];

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return $this->getField('Description');
    }

    /**
     * @inheritdoc
     */
    public function getPrice(): DBPrice
    {
        return $this->getField('Price');
    }
}
