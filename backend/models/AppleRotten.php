<?php

namespace backend\models;

/**
 * Class AppleRotten
 * @package backend\models
 */
class AppleRotten implements AppleState
{

    /**
     * @param Apple $apple
     * @throws \Exception
     */
    public function fallToGround(Apple $apple)
    {
        throw new \Exception('Не может упасть');
    }

    /**
     * @param Apple $apple
     * @param $percent
     * @throws \Exception
     */
    public function eat(Apple $apple, $percent)
    {
        throw new \Exception('Нельзя съесть');
    }

    /**
     * @param Apple $apple
     */
    public function checkRotten(Apple $apple)
    {
        return;
    }
}