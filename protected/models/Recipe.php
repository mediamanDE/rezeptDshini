<?php

/**
 * This is the model class for table "recipe".
 *
 * The followings are the available columns in table 'recipe':
 * @property integer $id
 * @property string $title
 * @property string $ingredients
 * @property string $preparation
 * @property integer $emotional
 * @property integer $rational
 * @property string $create
 * @property string $update
 */
class Recipe extends MActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recipe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recipe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
			array('ingredients, preparation, create, update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, ingredients, preparation, emotional, rational, create, update', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'emotional' => array(self::MANY_MANY, 'Emotional',
                	'recipe_emotional(recipe_id, emotional_id)'),
				'rational' => array(self::MANY_MANY, 'Rational',
	                'recipe_rational(recipe_id, rational_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'ingredients' => 'Ingredients',
			'preparation' => 'Preparation',
			'emotional' => 'Emotional',
			'rational' => 'Rational',
			'create' => 'Create',
			'update' => 'Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('ingredients',$this->ingredients,true);
		$criteria->compare('preparation',$this->preparation,true);
		$criteria->compare('emotional',$this->emotional);
		$criteria->compare('rational',$this->rational);
		$criteria->compare('create',$this->create,true);
		$criteria->compare('update',$this->update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}