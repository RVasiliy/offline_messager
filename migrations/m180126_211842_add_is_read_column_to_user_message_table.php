<?php

use yii\db\Migration;

/**
 * Handles adding is_read to table `user_message`.
 */
class m180126_211842_add_is_read_column_to_user_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_message', 'is_read', $this->boolean());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_message', 'is_read');
    }
}
