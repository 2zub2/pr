<?php

namespace backend\models;

/**
 * Class AppleOnGround
 * @package backend\models
 */
class AppleOnGround implements AppleState
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
        $size = $apple->size;
        if ($size <= 0) {
            throw new \Exception('нельзя съесть');
        }

        $size -= $percent / 100.0;

        if ($size <= 0) {
            $size = 0;
            $apple->is_deleted = true;
        }

        $apple->size = $size;
    }

    /**
     * @param Apple $apple
     */
    public function checkRotten(Apple $apple)
    {
        $diff = time() - $apple->falling_date;
        if ($diff > 5 * 60 * 60) {
            $apple->state = Apple::STATE_ROTTEN;
            $apple->setState(new AppleRotten());
        }
    }
}