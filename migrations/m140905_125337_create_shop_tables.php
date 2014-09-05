<?php

use yii\db\Schema;
use y2i\shop\migrations\Migration;

class m140905_125337_create_shop_tables extends Migration
{
    public function up()
    {
        $prefix = $this->module->tablePrefix;

        $categoryTable = $prefix.$this->module->categoryTable;
        $productsTable = $prefix.$this->module->productsTable;
        $orderTable = $prefix.$this->module->orderTable;
        $orderPositionTable = $prefix.$this->module->orderPositionTable;
        $customerTable = $prefix.$this->module->customerTable;
        $addressTable = $prefix.$this->module->addressTable;
        $imageTable = $prefix.$this->module->imageTable;
        $specificationTable = $prefix.$this->module->productSpecificationTable;
        $variationTable = $prefix.$this->module->productVariationTable;
        $taxTable = $prefix.$this->module->taxTable;
        $shippingMethodTable = $prefix.$this->module->shippingMethodTable;
        $paymentMethodTable = $prefix.$this->module->paymentMethodTable;

        $this->createTable($specificationTable, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'input_type' => "enum('none', 'select','textfield','image') NOT NULL DEFAULT 'select'",
            'required' => Schema::TYPE_BOOLEAN
        ], $this->tableOptions);

        $this->createTable($variationTable, [
            'id' => Schema::TYPE_PK,
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'specification_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'position' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'price_adjustion' => Schema::TYPE_FLOAT . ' NOT NULL',
            'weight_adjustion' => Schema::TYPE_FLOAT . ' NOT NULL',
        ], $this->tableOptions);

        $this->createTable($taxTable, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'percent' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);

        $this->createTable($shippingMethodTable, [
            'id' => Schema::TYPE_PK,
            'weight_range' => Schema::TYPE_STRING . '(255) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NULL',
            'tax_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL'
        ], $this->tableOptions);

        $this->createTable($paymentMethodTable, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NULL',
            'tax_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL'
        ], $this->tableOptions);

        $this->createTable($categoryTable, [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER . ' NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NULL',
            'language' => Schema::TYPE_STRING . '(45) NULL',
        ], $this->tableOptions);

        $this->createTable($productsTable, [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tax_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NULL',
            'keywords' => Schema::TYPE_STRING . '(255) NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'language' => Schema::TYPE_STRING . '(45) NULL',
            'specifications' => Schema::TYPE_TEXT . ' NULL',
        ], $this->tableOptions);

        $this->createTable($customerTable, [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NULL',
            'address_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'delivery_address_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'billing_address_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'email' => Schema::TYPE_STRING . '(45) NOT NULL',
            'phone' => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $this->tableOptions);

        $this->createTable($orderTable, [
            'id' => Schema::TYPE_PK,
            'customer_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'delivery_address_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'billing_address_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'ordering_date' => Schema::TYPE_INTEGER . ' NOT NULL',
			'delivery_date' => Schema::TYPE_INTEGER . ' NOT NULL',
			'delivery_time' => Schema::TYPE_INTEGER . ' NOT NULL',
			'status' => "enum('new', 'in_progress', 'done', 'cancelled') NOT NULL DEFAULT 'new'",
			'ordering_done' => Schema::TYPE_BOOLEAN . ' NULL',
			'ordering_confirmed' => Schema::TYPE_BOOLEAN . ' NULL',
			'payment_method' => Schema::TYPE_INTEGER . ' NOT NULL',
			'shipping_method' => Schema::TYPE_INTEGER . ' NOT NULL',
			'comment' => Schema::TYPE_TEXT . ' NULL',
        ], $this->tableOptions);

        $this->createTable($orderPositionTable, [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'amount' => Schema::TYPE_INTEGER . ' NOT NULL',
			'specifications' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $this->tableOptions);

        $this->createTable($addressTable, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
			'firstname' => Schema::TYPE_STRING . '(255) NOT NULL',
			'lastname' => Schema::TYPE_STRING . '(255) NOT NULL',
			'street' => Schema::TYPE_STRING . '(255) NOT NULL',
			'zipcode' => Schema::TYPE_STRING . '(255) NOT NULL',
			'city' => Schema::TYPE_STRING . '(255) NOT NULL',
			'country' => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $this->tableOptions);

        $this->createTable($imageTable, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(45) NOT NULL',
			'filename' => Schema::TYPE_STRING . '(45) NOT NULL',
			'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);

        $this->createIndex('fk_order_customer', $orderTable, 'customer_id');
        $this->createIndex('fk_order_payment', $orderTable, 'payment_method');
        $this->createIndex('fk_order_shipping', $orderTable, 'shipping_method');
        $this->addForeignKey('fk_order_customer', $orderTable, 'customer_id', $customerTable, 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_order_payment', $orderTable, 'payment_method', $paymentMethodTable, 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_order_shipping', $orderTable, 'shipping_method', $shippingMethodTable, 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('fk_image_products', $imageTable, 'product_id');
        $this->addForeignKey('fk_image_products', $imageTable, 'product_id', $productsTable, 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('fk_products_category', $productsTable, 'category_id');
        $this->addForeignKey('fk_products_category', $productsTable, 'category_id', $categoryTable, 'id', 'NO ACTION', 'NO ACTION');

        $this->createIndex('fk_variation_product', $variationTable, 'product_id');
        $this->createIndex('fk_variation_specification', $variationTable, 'specification_id');
        $this->addForeignKey('fk_variation_product', $variationTable, 'product_id', $productsTable, 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_variation_specification', $variationTable, 'specification_id', $specificationTable, 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $prefix = $this->module->tablePrefix;

        $this->dropTable($prefix.$this->module->productSpecificationTable);
    }
}
