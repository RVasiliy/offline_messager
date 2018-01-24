<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_detail`.
 */
class m180124_131919_create_user_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_detail', [
            'user_id' => $this->integer()->notNull(),
            'param_name' => $this->string()->notNull(),
            'param_value' => $this->string()->notNull(),
            'param_type' => $this->string(10)->notNull(),
        ]);

        $this->createIndex(
            'idx__user_detail-user_id',
            'user_detail',
            'user_id'
        );

        $this->createIndex(
            'idx__user_detail-param_name',
            'user_detail',
            'param_name'
        );

        $this->addForeignKey(
            'fk__user_detail-user_id__user-id',
            'user_detail',
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
        $this->dropForeignKey(
            'fk__user_detail-user_id__user-id',
            'user_detail'
        );

        $this->dropIndex(
            'idx__user_detail-param_name',
            'user_detail'
        );

        $this->dropIndex(
            'idx__user_detail-user_id',
            'user_detail'
        );

        $this->dropTable('user_detail');
    }
}
