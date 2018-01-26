<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_recipient`.
 */
class m180125_133526_create_user_recipient_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_recipient', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx__user_recipient-user_id',
            'user_recipient',
            'user_id'
        );

        $this->createIndex(
            'idx__user_recipient-recipient_id',
            'user_recipient',
            'recipient_id'
        );

        $this->addForeignKey(
            'fk__user_recipient-user_id__user-id',
            'user_recipient',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk__user_recipient-recipient_id__user-id',
            'user_recipient',
            'recipient_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk__user_recipient-recipient_id__user-id',
            'user_recipient'
        );

        $this->dropForeignKey(
            'fk__user_recipient-user_id__user-id',
            'user_recipient'
        );

        $this->dropIndex(
            'idx__user_recipient-recipient_id',
            'user_recipient'
        );

        $this->dropIndex(
            'idx__user_recipient-user_id',
            'user_recipient'
        );

        $this->dropTable('user_recipient');
    }
}
