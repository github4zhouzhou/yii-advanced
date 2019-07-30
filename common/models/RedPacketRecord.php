<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "red_packet_records".
 *
 * @property int $id
 * @property string $title 标题
 * @property int $owner_id 红包的拥有者
 * @property string $amount 红包金额
 * @property string $currency 货币种类
 * @property int $achieve_condition_type 红包领取类型:建仓手数，入金等
 * @property string $achieve_condition_value 满足条件类型值 如：大于10手数此处填10
 * @property int $expire_hours 过期小时数
 * @property int $relative_line 相对于什么时间  0注册时间  1活动开始时间
 * @property int $status 状态；0：未拆开 1：已拆开；2：已过期
 * @property string $add_condition 附加条件
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class RedPacketRecord extends \yii\db\ActiveRecord
{
	const EVENT_ID = 1903; 	// 定向红包都是同一个ID，由于是19年3月写的就定这个了

	const STATUS_N = 0;			// 未拆开
	const STATUS_Y = 1;			// 已拆开
	const STATUS_EXPIRED = 2; 	// 已过期

	const ACHIEVE_CONDITION_TYPE_HAND_CREATE = 1; 	// 建仓手数
	const ACHIEVE_CONDITION_TYPE_HAND_CLOSE = 2; 	// 平仓手数
	const ACHIEVE_CONDITION_TYPE_CASE_IN = 3; 		// 入金

	const RELATIVE_LINE_REG = 1;			// 相对注册时间
	const RELATIVE_LINE_EVENT_START = 2; 	// 相对活动开始时间
	const RELATIVE_LINE_FIRST_CASE_IN = 3; 	// 相对于首入金时间
	const RELATIVE_LINE_PRIZE_SHOW = 4; 	// 相对于奖品发放时间


	public static function achieveConditionTypes() {
		return [
			self::ACHIEVE_CONDITION_TYPE_HAND_CREATE => '建仓手数',
			self::ACHIEVE_CONDITION_TYPE_HAND_CLOSE => '平仓手数',
			self::ACHIEVE_CONDITION_TYPE_CASE_IN => '入金',
		];
	}

	public static function relativeLines() {
		return [
			self::RELATIVE_LINE_PRIZE_SHOW => '相对于奖品发放时间',
			self::RELATIVE_LINE_REG => '相对于注册时间',
			self::RELATIVE_LINE_FIRST_CASE_IN => '相对于首入金时间',
		];
	}

	// 额外条件
	public static function otherRelativeLines() {
		return [
			0 => '--请选择--',
			self::RELATIVE_LINE_PRIZE_SHOW => '奖品发放',
			self::RELATIVE_LINE_REG => '注册',
			self::RELATIVE_LINE_FIRST_CASE_IN => '首入金',
		];
	}

	public static function currencyList() {
		return ['USD' => 'USD'];
	}

	public static function statusList() {
		return [
			self::STATUS_N => '未拆开',
			self::STATUS_Y => '已拆开',
			self::STATUS_EXPIRED => '已过期',
		];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'red_packet_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id'], 'required'],
            [['owner_id', 'achieve_condition_type', 'expire_hours', 'relative_line', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['title'], 'string', 'max' => 32],
            [['currency'], 'string', 'max' => 8],
			[['achieve_condition_value'], 'string', 'max' => 10],
            [['add_condition'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'owner_id' => '领取人ID',
            'amount' => '领取金额',
            'currency' => '币种',
            'achieve_condition_type' => '领取类型',
            'achieve_condition_value' => '条件值',
            'expire_hours' => '过期时间（单位：小时）',
            'relative_line' => '起算时间',
            'status' => '状态',
            'add_condition' => '附加条件',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

	function beforeSave($insert)
	{
		if ($this->isNewRecord) {
			$this->created_at = time();
		}
		$this->updated_at = time();
		return parent::beforeSave($insert); // TODO: Change the autogenerated stub
	}

    public function getAddCondition() {
		$json = '';
		if (!empty($_POST['RedPacketRecord']['add-condition-from']) && !empty($_POST['RedPacketRecord']['add-condition-day'])
			&& !empty($_POST['RedPacketRecord']['add-condition-hand'])) {
			$tmp['from'] = intval(trim($_POST['RedPacketRecord']['add-condition-from']));
			$tmp['day'] = intval(trim($_POST['RedPacketRecord']['add-condition-day']));
			$tmp['hand'] = number_format(trim($_POST['RedPacketRecord']['add-condition-hand']), 2, '.', '');
			$json = json_encode($tmp);
		}

		return $json;
	}
}