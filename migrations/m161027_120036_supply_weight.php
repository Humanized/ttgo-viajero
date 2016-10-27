<?php

use yii\db\Migration;

class m161027_120036_supply_weight extends Migration
{

    public function safeUp()
    {

        $this->addColumn('supply', 'weight', $this->integer()->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn('supply', 'weight');
        return true;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
