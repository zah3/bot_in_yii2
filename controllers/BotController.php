<?php
/**
 * Created by PhpStorm.
 * User: zachariasz
 * Date: 2018-02-02
 * Time: 22:05
 */

namespace app\controllers;


use app\models\Answer;
use app\models\Bot;
use yii\web\Controller;
use Yii;

class BotController extends Controller
{
    /**
     * bot page
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        if(!isset($_SESSION['conversation'])){
            $_SESSION['conversation'] = [];
            $_SESSION['conversation'][] = ['author' => Bot::AUTHOR_BOT, 'value' => 'Hello, If You are here, probably You would like to know something more about martial-arts,huh?'];
            $_SESSION['conversation'][] = ['author' => Bot::AUTHOR_BOT, 'value' => 'Do You prefer standing, ground, mixed, street fights ?'];
        }

        $value = strtolower(Yii::$app->request->post('value'));
        if(strlen(trim($value)) > 0){
            Bot::tellSomethingToBot(Bot::AUTHOR_USER,Yii::$app->request->post('value'));
            $answer = new Answer();
            $answer->makeAnswer($value);
        }
        return $this->render('index');
    }
}