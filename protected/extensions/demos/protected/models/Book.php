<?php

class Book extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Book':
	 * @var integer $id
	 * @var string $isbn
	 * @var string $title
	 * @var string $release_date
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Book the static model class
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
		return 'Book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isbn, title, release_date', 'required'),
			array('isbn', 'length', 'max'=>22),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, isbn, title, release_date', 'safe', 'on'=>'search'),
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
			'libraries' => array(self::MANY_MANY, 'Library', 'LibraryBook(libraryID, bookISBN)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'isbn' => 'Isbn',
			'title' => 'Title',
			'release_date' => 'Release Date',
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

		$criteria->compare('isbn',$this->isbn,true);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('release_date',$this->release_date,true);

		return new CActiveDataProvider('Book', array(
			'criteria'=>$criteria,
		));
	}
}