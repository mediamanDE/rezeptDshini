<?php

class LibraryBook extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'LibraryBook':
	 * @var integer $libraryID
	 * @var string $bookISBN
	 * @var string $location
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return LibraryBook the static model class
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
		return 'LibraryBook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bookISBN, location', 'required'),
			array('libraryID', 'numerical', 'integerOnly'=>true),
			array('bookISBN', 'length', 'max'=>22),
			array('location', 'length', 'max'=>80),
			array('bookISBN','exist','className'=>'Book','attributeName'=>'isbn'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('libraryID, bookISBN, location', 'safe', 'on'=>'search'),
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
			'book'=>array(self::BELONGS_TO, 'Book', 'bookISBN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'libraryID' => 'Library',
			'bookISBN' => 'Book Isbn',
			'location' => 'Location',
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

		$criteria->compare('libraryID',$this->libraryID);

		$criteria->compare('bookISBN',$this->bookISBN,true);

		$criteria->compare('location',$this->location,true);

		return new CActiveDataProvider('LibraryBook', array(
			'criteria'=>$criteria,
		));
	}
}