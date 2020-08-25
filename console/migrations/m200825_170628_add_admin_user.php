<?php

use common\models\User;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use yii\db\Migration;

/**
 * Class m200825_170628_add_admin_user
 */
class m200825_170628_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = '1@1.ru';
        $user->setPassword('Gfhjkm1');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200825_170628_add_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200825_170628_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
