<?php

namespace models;

use gerjansteenbeek\multilingual\behaviors\MultilingualBehavior;
use gerjansteenbeek\multilingual\db\MultilingualLabelsTrait;
use gerjansteenbeek\multilingual\db\MultilingualQuery;

class PostAdvanced extends \yii\db\ActiveRecord
{

    use MultilingualLabelsTrait;

    public static function tableName()
    {
        return '{{%post_advanced}}';
    }
    
    public function behaviors()
    {
        return [
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'attributes' => [
                    'title', 'content',
                ],
                'languages' => [
                    'en-US' => 'English',
                    'es' => 'Español',
                ],
                'languageField' => 'lang',
                'languageForeignKey' => 'post_id',
                'translationClassName' => 'models\PostAdvancedLanguage',
            ],
        ];
    }

    public function rules()
    {
        return [
                [['slug'], 'string', 'max' => 127],
                [['title', 'content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     * @return MultilingualQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = ['translations'], $recursive = true)
    {
        return parent::toArray($fields, $expand, $recursive);
    }

}
