<?php

namespace y2i\shop\migrations;

use Yii;

class Migration extends \yii\db\Migration
{
    /**
     * @var $tableOptions string
     */
    protected $tableOptions;

    /**
     * @var $module \y2i\shop\Module
     */
    protected $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        switch (\Yii::$app->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
                break;
            case 'pgsql':
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }

        if (!Yii::$app->hasModule('shop')) {
            Yii::$app->setModule('shop', [
                'class' => 'y2i\shop\Module'
            ]);
        }
        $this->module = Yii::$app->getModule('shop');
    }
} 