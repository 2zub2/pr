<?php

namespace backend\models;

/**
 * Class AppleOnTree
 * @package backend\models
 */
class AppleOnTree implements AppleState
{

    /**
     * @param Apple $apple
     */
    public function fallToGround(Apple $apple)
    {
        $apple->falling_date = time();
        $apple->state = Apple::STATE_ON_GROUND;
        $apple->setState(new AppleOnGround());
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