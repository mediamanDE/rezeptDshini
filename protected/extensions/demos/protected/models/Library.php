<?php

class Library extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Library':
	 * @var integer $id
	 * @var string $name
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Library the static model class
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
		return 'Library';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'books' => array(self::MANY_MANY, 'Book', 'LibraryBook(libraryID, bookISBN)'),
			'services' => array(self::MANY_MANY, 'Service', 'LibraryService(libraryID, serviceID)'),
			'libraryBooks'=>array(self::HAS_MANY, 'LibraryBook', 'libraryID'),
			'libraryComments'=>array(self::HAS_MANY, 'LibraryComment', 'libraryID'),
		);
	}
	
	public function behaviors(){
		return array(
			'CSaveRelationsBehavior' => array(
				'class' => 'CSaveRelationsBehavior',
				'relations' => array(
					'libraryBooks'=>array("message"=>"Please, check the books"),
					'libraryComments'=>array("message"=>"Please, check the comments"),
					'services'=>array("message"=>"Please, check the services")
				)
			)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'libraryBooks' => 'Available books',
			'services' => 'Available services'
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

		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider('Library', array(
			'criteria'=>$criteria,
		));
	}
	
	public function addBook() {
		$this->addRelatedRecord('libraryBooks',new LibraryBook,true);
	}

	public function deleteBook($idx) {
		$libraryBooksArray = $this->libraryBooks;
		unset($libraryBooksArray[$idx]);
		$this->libraryBooks = $libraryBooksArray;
	}
	
	public function addComment() {
		$this->addRelatedRecord('libraryComments',new LibraryComment,true);
	}

	public function deleteComment($idx) {
		$libraryCommentsArray = $this->libraryComments;
		unset($libraryCommentsArray[$idx]);
		$this->libraryComments = $libraryCommentsArray;
	}
}