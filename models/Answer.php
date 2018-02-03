<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $value
 * @property int $question_id
 *
 * @property Question $question
 */
class Answer extends \yii\db\ActiveRecord
{

    const ANSWER_NOT_UNDERSTAND = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
                    ->viaTable('answer_questions', ['answer_id' => 'id']);
    }

    /**
     * make answer for user question
     * @param $questionValue
     */
    public function makeAnswer($questionValue)
    {
        $question = new Question();
        $questionValue = trim($questionValue);
        if($question->isValueAQuestion($questionValue) || $question->isValueASentence($questionValue))
            $questionValue = substr($questionValue,0,-1);
        $questionFromDB = Question::getQuestion($questionValue);
        if(!$questionFromDB)
            return $this->getRandomAnswerForNotUnderstoodQuestion();
        $this->getRandomAnswer($questionFromDB->answers);
    }

    /**
     * get all default values of answers for wrong question
     * @return mixed
     */
    public function getRandomAnswerForNotUnderstoodQuestion()
    {
       return $this->getRandomAnswer(self::find()->select(self::tableName().'.value')->joinWith(['questions'])->where(['answer_questions.question_id' => self::ANSWER_NOT_UNDERSTAND])->all());
    }

    /**
     * generate random answer for any grouping
     * @param $arrayWithAnswers
     * @return mixed
     *
     */
    public function getRandomAnswer($arrayWithAnswers)
    {
        $ranodomNumer = rand(0,count($arrayWithAnswers) - 1);
        $_SESSION['conversation'][] = ['author' => Bot::AUTHOR_BOT, 'value' => $arrayWithAnswers[$ranodomNumer]['value']];
    }
}
