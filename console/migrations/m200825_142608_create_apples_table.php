<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m200825_142608_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apples', [
            'id' => $this->primaryKey(),
            'color' => $this->string(64)->notNull(),
            'grown_date' => $this->integer()->notNull(),
            'falling_date' => $this->integer(),
            'state' => $this->string(24)->notNull(),
            'size' => $this->decimal(3,2)->defaultValue(1),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apples');
    }
}
