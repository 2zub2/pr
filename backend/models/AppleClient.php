<?php

namespace backend\models;

/**
 * Class AppleClient
 * @package backend\models
 *
 * @property-read string stateName
 * @property-read string grownDate
 * @property-read string fallingDate
 */
class AppleClient extends Apple
{
    /**
     * @return array
     */
    public static function states()
    {
        return [
            self::STATE_ON_TREE => 'на дереве',
            self::STATE_ON_GROUND => 'на земле',
            self::STATE_ROTTEN => 'гнилое',
        ];
    }

    /**
     * @return array
     */
    public static function colors()
    {
        return [
            self::COLOR_GREEN,
            self::COLOR_YELLOW,
            self::COLOR_RED,
        ];
    }

    /**
     * @return mixed|string
     */
    public function getStateName()
    {
        $states = static::states();

        return $states[$this->state] ?? '';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getGrownDate()
    {
        return $this->_unixTimestampToString($this->grown_date);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getFallingDate()
    {
        return $this->falling_date
            ? $this->_unixTimestampToString($this->falling_date)
            : null;
    }

    /**
     * @param int $timestamp
     * @return string
     * @throws \Exception
     */
    private function _unixTimestampToString(int $timestamp)
    {
        return (new \DateTime())->setTimestamp($timestamp)->format('Y-m-d H:i:s');
    }

    /**
     * @return array
     */
    public function clientData()
    {
        return array_merge($this->getAttributes([
            'id',
            'color',
            'size',
        ]), [
            'state' => $this->stateName,
            'grown_date' => $this->grownDate,
            'falling_date' => $this->fallingDate,
            'is_deleted' => $this->is_deleted,
        ]);
    }

    /**
     * @param int $num
     * @return array
     * @throws \Exception
     */
    public static function generateRandoms(int $num)
    {
        if ($num < 1) {
            throw new \Exception('кол-во моделей не может быть меньше одного');
        }

        $ids = [];
        $colors = static::colors();
        for($i = 0; $i < $num; $i++) {
            $idx = array_rand($colors);
            $model = new static($colors[$idx]);
            if ($model->save()) {
                $ids[] = $model->id;
            } else {
                throw new \Exception('во время сохранения произошла ошибка');
            }
        }

        return $ids;
    }
}