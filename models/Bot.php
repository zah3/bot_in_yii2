<?php
/**
 * Created by PhpStorm.
 * User: zachariasz
 * Date: 2018-02-02
 * Time: 22:50
 */

namespace app\models;

use Yii;

class Bot
{
    const AUTHOR_USER = 'user';
    const AUTHOR_BOT = 'bot';

    /**
     * function adding to session new element of conversation between user and bot
     * @param $author
     * @param $value
     */
    public static function tellSomethingToBot($author,$value)
    {
        $_SESSION['conversation'][] = ['author' => $author, 'value' => $value];
    }







}