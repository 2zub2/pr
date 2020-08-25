<?php

namespace backend\models;

Interface AppleState
{
    public function fallToGround(Apple $apple);
    public function eat(Apple $apple, $percent);
    public function checkRotten(Apple $apple);
}