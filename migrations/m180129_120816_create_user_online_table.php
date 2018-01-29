<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_online`.
 */
class m180129_120816_create_user_online_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_online', [
            'user_id' => $this->integer()->notNull()->unique(),
            'last_time' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey(
           'pk__user_online-user_id',
           'user_online',
           'user_id'
        );

        $this->addForeignKey(
            'fk__user_online-user_id__user-id',
            'user_online',
            'user_id',
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
        $this->dropForeignKey('fk__user_online-user_id__user-id', 'user_online');
        $this->dropPrimaryKey('pk__user_online-user_id', 'user_online');
        $this->dropTable('user_online');
    }
}
