<?php

use yii\db\Migration;

class m161012_154539_init extends Migration
{

    protected $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        //User Language Spoken
        $this->createTable('user_language', [

            'user_id' => $this->integer(),
            'language' => $this->string(2)
                ], $this->tableOptions);

        $this->addPrimaryKey('pk_user_language', 'user_language', ['user_id', 'language']);
        $this->addForeignKey('fk_user_language', 'user_language', 'user_id', 'user', 'id', 'cascade', 'cascade');


        $this->createTable('supply', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'description_public' => $this->text(),
            'description_private' => $this->text(),
            'has_wifi' => $this->boolean(true),
            'has_kitchen' => $this->boolean(true),
            'has_shower' => $this->boolean(true),
                ], $this->tableOptions);
        $this->addForeignKey('fk_supply_user', 'supply', 'user_id', 'user', 'id', 'cascade', 'cascade');

        //FK USER
        $this->createTable('accommodation', [
            'id' => $this->primaryKey(),
            'supply_id' => $this->integer()->notNull(),
            'accommodation_date' => $this->date()->notNull(),
            'accommodation_count' => $this->integer()->notNull(),
                ], $this->tableOptions);

        $this->addForeignKey('fk_accommodation_supply', 'accommodation', 'supply_id', 'supply', 'id', 'cascade', 'cascade');

        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'is_new' => $this->boolean()->notNull(),
            'request_date' => $this->dateTime()->notNull(),
            'request_message' => $this->text()->notNull(),
            'response_date' => $this->dateTime(),
            'response_message' => $this->text(),
                ], $this->tableOptions);
        $this->addForeignKey('fk_request_user', 'request', 'user_id', 'user', 'id', 'cascade', 'cascade');

        $this->createTable('accommodation_request', [
            'id' => $this->primaryKey(),
            'accommodation_id' => $this->integer()->notNull(),
            'request_id' => $this->integer()->notNull(),
            'request_count' => $this->integer()->notNull(),
            'is_accepted' => $this->boolean(),
                ]
                , $this->tableOptions);

        $this->addForeignKey('fk_accomodation_request_a', 'accommodation_request', 'accommodation_id', 'accommodation', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_accomodation_request_r', 'accommodation_request', 'request_id', 'request', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {

        $this->dropTable('accommodation_request');
        $this->dropTable('request');
        $this->dropTable('accommodation');
        $this->dropTable('supply');
        $this->dropTable('user_language');
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
