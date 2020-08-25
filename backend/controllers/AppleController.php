<?php

namespace backend\controllers;

use backend\models\AppleClient;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AppleController
 * @package backend\controllers
 */
class AppleController extends Controller
{
    /**
     * init
     */
    public function init()
    {
        parent::init();
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param null $num
     * @return array
     * @throws \Exception
     */
    public function actionCreateRandom($num = null)
    {
        if ($num === null) {
            $num = rand(5, 15);
        }

        $ids = AppleClient::generateRandoms($num);

        $apples = AppleClient::find()->where(['id' => $ids])->all();

        $applesData = [];
        /** @var AppleClient $apple */
        foreach ($apples as $apple) {
            $applesData[] = $apple->clientData();
        }

        return [
            'apples' => $applesData,
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionApples()
    {
        $apples = AppleClient::find()->where(['is_deleted' => false])->limit(10)->all();

        $applesData = [];
        /** @var AppleClient $apple */
        foreach ($apples as $apple) {
            $applesData[] = $apple->clientData();
        }

        return [
            'apples' => $applesData,
        ];
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionFallToGround($id)
    {
        /** @var AppleClient $apple */
        if ($apple = AppleClient::findOne($id)) {
            $apple->fallToGround();

            if ($apple->save()) {
                return $apple->clientData();
            } else {
                throw new \Exception('не удалось сохранить');
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * @param $id
     * @param $percent
     * @return array
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionEat($id, $percent)
    {
        if ($apple = AppleClient::findOne($id)) {
            $apple->eat($percent);

            if ($apple->save()) {
                return $apple->clientData();
            } else {
                throw new \Exception('не удалось сохранить');
            }
        }

        throw new NotFoundHttpException();
    }
}