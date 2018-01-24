<?php

use yii\db\Migration;

/**
 * Handles adding id to table `user_detail`.
 */
class m180124_191432_add_id_column_to_user_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_detail', 'id', $this->primaryKey());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_detail', 'id');
    }
}
