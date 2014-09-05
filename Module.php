<?php

namespace y2i\shop;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'y2i\shop\controllers';

    public $tablePrefix = 'shop_';

    public $categoryTable = 'category';
    public $productsTable = 'products';
    public $orderTable = 'order';
    public $orderPositionTable = 'order_position';
    public $customerTable = 'customer';
    public $addressTable = 'address';
    public $imageTable = 'image';
    public $shippingMethodTable = 'shipping_method';
    public $paymentMethodTable = 'payment_method';
    public $taxTable = 'tax';
    public $productSpecificationTable = 'product_specification';
    public $productVariationTable = 'product_variation';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
