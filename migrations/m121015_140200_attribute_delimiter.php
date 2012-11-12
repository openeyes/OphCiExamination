<?php

class m121015_140200_attribute_delimiter extends OEMigration {

	public function up() {
		$this->addColumn('ophciexamination_attribute_option', 'delimiter', "varchar(255) NOT NULL DEFAULT ','");
		$element = ElementType::model()->find("class_name = ?", array('Element_OphCiExamination_History'));
		$attribute = OphCiExamination_Attribute::model()->find("element_type_id = ? AND name = ?", array($element->id, 'eye'));
		foreach(OphCiExamination_AttributeOption::model()->findAll('attribute_id = ?', array($attribute->id)) as $option) {
			$option->delimiter = ';';
			$option->save();
		}
	}

	public function down() {
		$this->dropColumn('ophciexamination_attribute_option', 'delimiter');
	}

}
