<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trade_account".
 *
 * @property int $id id
 * @property int $trade_server 关联trade_server的主键
 * @property string $server_name 服务器的唯一标识名
 * @property int $server_label 服务器标的类型，1=主标,2=白标
 * @property int $server_type 服务器类型:1=MT4,2=MT5
 * @property int $login_type 帐号类型:1=live,2=demo
 * @property int $account_type 交易帐户类型，同以前members表里的member_type
 * @property int $mid Member表中的mid
 * @property string $alias 帐号别名，用户可自定义
 * @property int $leverage 帐号杠杆
 * @property string $login_group 帐号分组,同mt4_group
 * @property int $login 账号
 * @property string $password 密码
 * @property string $password_investor 投资人密码
 * @property int $is_main 是否是主账户，同一个mid，确保只有一个is_main=1的帐号  1=是，0=否
 * @property int $is_star 是否是明星，同一个mid，确保只有一个is_star=1的帐号    1=是，0=否
 * @property int $is_copy 是否是跟单账号，同一个mid，确保只有一个is_copy=1的帐号 1=是，0=否
 * @property int $is_ib 是否是ib收佣帐号，同一个mid，确保只有一个is_ib=1的帐号   1=是，0=否
 * @property string $balance MT余额
 * @property string $equity MT净值
 * @property string $margin MT已用预付款
 * @property string $free_margin MT可用预付款
 * @property string $margin_level MT预付款比例
 * @property int $create_at 创建时间
 * @property int $update_at 更新时间
 * @property int $trade_count 交易次数
 * @property int $trade_win_count 交易盈利次数
 * @property int $trade_lose_count 交易亏损次数
 * @property string $trade_win_rate 交易胜率
 * @property string $daily_max_gain 单日最大涨幅
 * @property string $daily_max_drop 单日最大跌幅
 * @property string $weekly_max_gain 单周最大涨幅
 * @property string $weekly_max_drop 单周最大跌幅
 * @property string $trade_count_per_month 月均交易次数
 * @property string $average_position_time 平均持仓天数
 * @property string $last_day_profit_rate 前一日收益率
 * @property string $last_week_profit_rate 近一周收益率
 * @property string $monthly_profit 近30天收益金额
 * @property string $monthly_profit_rate 近30天收益率
 * @property string $yearly_profit_rate 近一年收益率
 * @property string $accum_profit 累计收益金额
 * @property string $accum_profit_rate 累计收益率
 * @property string $products 交易过的产品列表
 * @property string $score 综合评分
 * @property string $deposits 总入金
 * @property string $withdrawal 总提款
 * @property int $volumes 总交易量
 */
class TradeAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trade_account';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('forexDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trade_server', 'server_label', 'server_type', 'login_type', 'account_type', 'mid', 'leverage', 'login', 'is_main', 'is_star', 'is_copy', 'is_ib', 'create_at', 'update_at', 'trade_count', 'trade_win_count', 'trade_lose_count', 'volumes'], 'integer'],
            [['balance', 'equity', 'margin', 'free_margin', 'margin_level', 'trade_win_rate', 'daily_max_gain', 'daily_max_drop', 'weekly_max_gain', 'weekly_max_drop', 'trade_count_per_month', 'average_position_time', 'last_day_profit_rate', 'last_week_profit_rate', 'monthly_profit', 'monthly_profit_rate', 'yearly_profit_rate', 'accum_profit', 'accum_profit_rate', 'score', 'deposits', 'withdrawal'], 'number'],
            [['products'], 'required'],
            [['products'], 'string'],
            [['server_name', 'login_group'], 'string', 'max' => 32],
            [['alias'], 'string', 'max' => 64],
            [['password', 'password_investor'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_server' => 'Trade Server',
            'server_name' => 'Server Name',
            'server_label' => 'Server Label',
            'server_type' => 'Server Type',
            'login_type' => 'Login Type',
            'account_type' => 'Account Type',
            'mid' => 'Mid',
            'alias' => 'Alias',
            'leverage' => 'Leverage',
            'login_group' => 'Login Group',
            'login' => 'Login',
            'password' => 'Password',
            'password_investor' => 'Password Investor',
            'is_main' => 'Is Main',
            'is_star' => 'Is Star',
            'is_copy' => 'Is Copy',
            'is_ib' => 'Is Ib',
            'balance' => 'Balance',
            'equity' => 'Equity',
            'margin' => 'Margin',
            'free_margin' => 'Free Margin',
            'margin_level' => 'Margin Level',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'trade_count' => 'Trade Count',
            'trade_win_count' => 'Trade Win Count',
            'trade_lose_count' => 'Trade Lose Count',
            'trade_win_rate' => 'Trade Win Rate',
            'daily_max_gain' => 'Daily Max Gain',
            'daily_max_drop' => 'Daily Max Drop',
            'weekly_max_gain' => 'Weekly Max Gain',
            'weekly_max_drop' => 'Weekly Max Drop',
            'trade_count_per_month' => 'Trade Count Per Month',
            'average_position_time' => 'Average Position Time',
            'last_day_profit_rate' => 'Last Day Profit Rate',
            'last_week_profit_rate' => 'Last Week Profit Rate',
            'monthly_profit' => 'Monthly Profit',
            'monthly_profit_rate' => 'Monthly Profit Rate',
            'yearly_profit_rate' => 'Yearly Profit Rate',
            'accum_profit' => 'Accum Profit',
            'accum_profit_rate' => 'Accum Profit Rate',
            'products' => 'Products',
            'score' => 'Score',
            'deposits' => 'Deposits',
            'withdrawal' => 'Withdrawal',
            'volumes' => 'Volumes',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if ($this->products) {
            $pds = json_decode($this->products, true);
            $this->products = is_array($pds) ? $pds : [];
        } else {
            $this->products = [];
        }
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->create_at = time();
        }
        $this->update_at = time();
        $this->products = is_array($this->products) ? json_encode($this->products) : $this->products;
        return parent::beforeSave($insert);
    }
}
