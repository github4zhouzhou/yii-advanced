<?php
namespace backend\models;

use common\helpers\Util;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_admin;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误。');
            }
        }
    }

    /**
     * Signs in a user using the provided username and password.
     * @return Admin|null whether the user is logged in successfully
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function login()
    {
        if ($this->validate()) {
            $admin = $this->getAdmin();
            $res = Yii::$app->user->login($admin, $this->rememberMe ? 3600 * 24 * 30 : 0);
            if ($res) {
                // $admin->last_ip = Util::GetIP();
                $admin->save();
            }
            return $res;
        } else {
            return false;
        }
    }

    /**
     * Finds user by username
     *
     * @return Admin|null
     */
    protected function getAdmin()
    {
        if ($this->_admin === null) {
            $this->_admin = Admin::findOne(['username' => $this->username]);
        }

        return $this->_admin;
    }
}
