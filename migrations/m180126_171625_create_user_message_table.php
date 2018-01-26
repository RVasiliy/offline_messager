<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_message`.
 */
class m180126_171625_create_user_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_message', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx__user_message-user_id',
            'user_message',
            'user_id'
        );

        $this->createIndex(
            'idx__user_message-recipient_id',
            'user_message',
            'recipient_id'
        );

        $this->addForeignKey(
            'fk__user_message-user_id__user-id',
            'user_message',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk__user_message-recipient_id__user-id',
            'user_message',
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
            'fk__user_message-recipient_id__user-id',
            'user_message'
        );

        $this->dropForeignKey(
            'fk__user_message-user_id__user-id',
            'user_message'
        );

        $this->dropIndex(
            'idx__user_message-recipient_id',
            'user_message'
        );

        $this->dropIndex(
            'idx__user_message-user_id',
            'user_message'
        );

        $this->dropTable('user_message');
    }
}
