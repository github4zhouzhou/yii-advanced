<?php

use yii\db\Migration;

/**
 * Class m180810_033656_add_col_category_to_symbol_table
 */
class m180810_033656_add_col_category_to_symbol_table extends Migration
{
    private $table = '{{%symbol}}';

    public function up()
    {
        //$this->addColumn($this->table, 'category', $this->smallInteger(6)->defaultValue(0)->comment('分类；外汇(101)，商品(201)，指数(301)等'));
        //$this->update($this->table, ['category' => 101]);


        $symbols = $this->db->createCommand("SELECT `symbol` FROM `symbol`")->queryAll();


        // 商品
        $a201 = ['XAGUSD', 'XAUUSD']; // 贵金属
        $a202 = ['XBRUSD', 'XNGUSD', 'XTIUSD']; // 能源
        // 指数
        $a301 = ['USA500', 'US30', 'GER30', 'HK50', 'NAS100', 'EUSTX50', 'JPN225'];
        // 外汇
//        $a101 = ['AUDCAD', 'AUDUSD', 'AUDJPY', 'AUDCHF', 'AUDNZD', 'CADJPY', 'CADCHF', 'USDSGD', 'USDCAD', 'USDCHN', 'USDJPY', 'USDCHF', 'EURAUD', 'EURCAD', 'EURUSD',
//            'EURJPY', 'EURCHF', 'EURNZD', 'EURGBP', 'CHFJPY', 'NZDCAD', 'NZDUSD', 'NZDJPY', 'NZDCHF', 'GBPSGD', 'GBPAUD', 'GBPCAD', 'GBPUSD', 'GBPJPY', 'GBPCHF',
//            'GBPNZD', 'SGDJPY', 'EURSGD'];

        $b201 = [];
        $b202 = [];
        $b301 = [];
        // $b101 = [];

        $result = [];
        foreach ($symbols as $item) {
            $symbol = $item['symbol'];
            if (strlen($symbol) > 6) {
                continue;
            }
            $result[$symbol] = 1 ;
//            foreach ($a201 as $a) {
//                if (strstr($symbol, $a)) {
//                    $b201[] = $symbol;
//                }
//            }
//            foreach ($a202 as $a) {
//                if (strstr($symbol, $a)) {
//                    $b202[] = $symbol;
//                }
//            }
//
//            foreach ($a301 as $a) {
//                if (strstr($symbol, $a)) {
//                    $b301[] = $symbol;
//                }
//            }
        }

        $currencies = [];
        foreach ($result as $key => $val) {
            $c1 = substr($key, 0, 3);
            $c2 = substr($key, 3);
            $currencies[$c1] = 1;
            $currencies[$c2] = 1;
        }

        echo json_encode($currencies);

//        $this->update($this->table, ['category' => 201], ['symbol' => $b201]);
//        $this->update($this->table, ['category' => 202], ['symbol' => $b202]);
//        $this->update($this->table, ['category' => 301], ['symbol' => $b301]);
    }

    public function down()
    {
        //$this->dropColumn($this->table, 'category');
    }
}
