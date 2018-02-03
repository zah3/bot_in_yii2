<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string $value
 *
 * @property Answer[] $answers
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
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
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['id' => 'answer_id'])
                    ->viaTable('answer_questions', ['question_id' => 'id']);
    }

    /**
     * return question
     * @param $questionValue
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getQuestion($questionValue)
    {
        return Question::find()->where([Question::tableName().'.value' => $questionValue])->one();
    }

    /**
     * if value is question then return true else return false
     * @param $value
     * @return bool
     */
    public function isValueAQuestion($value)
    {
        $cleanValue = trim($value);
        $endOfValue = substr($cleanValue, -1);
        return ($endOfValue ===  "?");
    }
    /**
     * if value is question then return true else return false
     * @param $value
     * @return bool
     */
    public function isValueASentence($value)
    {
        $cleanValue = trim($value);
        $endOfValue = substr($cleanValue, -1);
        return ($endOfValue ===  ".");
    }
}
