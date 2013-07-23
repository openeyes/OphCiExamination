<?php

class m130226_133800_rename_elements extends CDbMigration
{
	public function up()
	{
		$history_element_type_id = ElementType::model()->find("class_name = 'Element_OphCiExamination_History'")->id;
		$this->update('element_type', array('name'=> 'Clinical Management'), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_Management'));
		$this->update('element_type', array('name'=> 'Comorbidities', 'display_order' => 10, 'parent_element_type_id' => $history_element_type_id ), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_Risks'));
	}

	public function down()
	{
		$this->update('element_type', array('name'=> 'Management'), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_Management'));
		$this->update('element_type', array('name'=> 'Risks', 'display_order' => 25, 'parent_element_type_id' => null ), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_Risks'));
	}

}
