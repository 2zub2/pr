<?php

namespace backend\models;

use yii\base\Model;

/**
 * Class Apple
 *
 * Table fields
 * @property-read integer id
 * @property string color
 * @property integer grown_date
 * @property integer falling_date
 * @property string state
 * @property float size
 * @property string created_at
 * @property string updated_at
 * @property integer created_by
 * @property integer updated_by
 * @property boolean is_deleted
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATE_ON_TREE = 'on_tree';
    const STATE_ON_GROUND = 'on_ground';
    const STATE_ROTTEN = 'rotten';

    const COLOR_RED = 'red';
    const COLOR_GREEN = 'green';
    const COLOR_YELLOW = 'yellow';

    /** @var $_state AppleState */
    private $_state;

    static protected $_prototype;

    /**
     * Apple constructor.
     * @param string $color
     * @param array $config
     */
    public function __construct(string $color, array $config = [])
    {
        $this->color = $color;
        $this->grown_date = rand(0, time());
        $this->setState(new AppleOnTree());
        $this->state = self::STATE_ON_TREE;
        $this->size = 1;

        parent::__construct($config);
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * @param AppleState $state
     */
    public function setState(AppleState $state)
    {
        $this->_state = $state;
    }

    /**
     * переопределен, чтобы предотвратить загрузку конструктора при заполнении из бд
     * и для установки статуса на основании данных из бд
     * @param array $row
     * @return Model|\yii\db\ActiveRecord
     */
    public static function instantiate($row)
    {
        $className = get_called_class();
        if ($className::$_prototype === null) {
            $className::$_prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($className), $className));
        }

        /** @var Apple $obj */
        $obj = clone $className::$_prototype;
        $obj->init();

        switch ($row['state']) {
            case self::STATE_ON_TREE:
                $obj->setState(new AppleOnTree());
                break;
            case self::STATE_ON_GROUND:
                $obj->setState(new AppleOnGround());
                break;
            case self::STATE_ROTTEN:
                $obj->setState(new AppleRotten());
                break;
        }

        return $obj;
    }

    /**
     * уронить яблоко на землю
     */
    public function fallToGround()
    {
        $this->_state->fallToGround($this);
    }

    /**
     * съесть часть яблока
     * @param $percent
     * @throws \Exception
     */
    public function eat($percent)
    {
        if ($percent <= 0 || $percent > 100) {
            throw new \Exception('неверно задан параметр');
        }

        $this->_state->checkRotten($this);
        $this->_state->eat($this, $percent);
    }
}