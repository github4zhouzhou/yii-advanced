<?php

namespace backend\models;

use common\helpers\Util;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $cellphone 手机号码
 * @property string $email 邮箱地址
 * @property string $password 登录密码
 * @property string $auth_key authentication key for cookie
 * @property string $last_ip 最后一次登录IP
 * @property int $status 状态,1=正常,2=禁用
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const GLOBAL_SALT = 'slaemmiocne';
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'cellphone', 'email', 'password', 'auth_key', 'last_ip'], 'required'],
            [['create_at', 'update_at'], 'integer'],
            [['username', 'cellphone', 'auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 128],
            [['last_ip'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 1],
            [['username'], 'unique'],
            [['cellphone'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '状态',
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'last_ip' => 'IP地址',
            'cellphone' => '手机号',
            'create_at' => '创建时间',
            'update_at' => '最后更新',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Do not implement.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->generatePasswordHash($password, $this->auth_key);
    }

    /**
     * 生成密码hash值。
     *
     * @param $password
     * @param $salt
     * @return string
     */
    private function generatePasswordHash($password, $salt)
    {
        return md5(md5($password) . $salt . self::GLOBAL_SALT);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $this->generatePasswordHash($password, $this->auth_key);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->create_at = time();
            $this->generateAuthKey();
        }
        $this->update_at = time();
        $this->last_ip = Util::GetIP();
        $this->setPassword($this->password);
        return parent::beforeSave($insert);
    }
}
