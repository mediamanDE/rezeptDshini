<?php 
class MActiveRecord extends CActiveRecord{

	public function beforeSave() {
	    if ($this->isNewRecord)
	        $this->create = new CDbExpression('NOW()');
	    else
	        $this->update = new CDbExpression('NOW()');
	 
	    return parent::beforeSave();
	}
}