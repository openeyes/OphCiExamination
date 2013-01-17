<?php

class m121015_140200_attribute_delimiter extends OEMigration {

	public function up() {
		$this->addColumn('ophciexamination_attribute_option', 'delimiter', "varchar(255) NOT NULL DEFAULT ','");
		$element = ElementType::model()->find("class_name = ?", array('Element_OphCiExamination_History'));
		$attribute_id = Yii::app()->db->createCommand()->select("id")->from("ophciexamination_attribute")->where("element_type_id = $element->id and name = 'eye'")->queryScalar();
		$this->update("ophciexamination_attribute_option",array('delimiter'=>';'),"attribute_id = $attribute_id");
	}

	public function down() {
		$this->dropColumn('ophciexamination_attribute_option', 'delimiter');
	}

}
