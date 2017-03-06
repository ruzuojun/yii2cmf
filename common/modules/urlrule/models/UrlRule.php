<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/6
 * Time: 下午9:38
 */

namespace common\modules\urlrule\models;


use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%url_rule}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $pattern
 * @property string $host
 * @property string $route
 * @property string $defaults
 * @property string $suffix
 * @property string $verb
 * @property integer $mode
 * @property integer $encodeParams
 * @property integer $status
 */
class UrlRule extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%url_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pattern', 'route'], 'required'],
            [['mode', 'encodeParams', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['pattern', 'host', 'route', 'defaults', 'suffix', 'verb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'pattern' => 'Pattern',
            'host' => 'Host',
            'route' => 'Route',
            'defaults' => 'Defaults',
            'suffix' => 'Suffix',
            'verb' => 'Verb',
            'mode' => 'Mode',
            'encodeParams' => 'Encode Params',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)== false) {
            return false;
        }

        if($insert == true) {
            $this->mode = 0;//0,1,2 分别代表适用于创建和解析.只能创建,只能解析
            $this->encodeParams = 1;
            $this->status = 1;
        }
        return true;
    }

    public static function getRuleByRoute($route,$params)
    {
        return static::findOne(['route' => $route, 'defaults' => http_build_query($params), 'status' => 1]);
    }

    public static function getRuleByPattern($pattern)
    {
        return static::findOne(['pattern' => $pattern, 'status' => 1]);
    }
}