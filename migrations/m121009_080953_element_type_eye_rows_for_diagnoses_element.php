<?php

class m121009_080953_element_type_eye_rows_for_diagnoses_element extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Diagnoses'));

		$this->insert('element_type_eye',array('element_type_id'=>$element_type->id,'eye_id'=>2,'display_order'=>1));
		$this->insert('element_type_eye',array('element_type_id'=>$element_type->id,'eye_id'=>3,'display_order'=>2));
		$this->insert('element_type_eye',array('element_type_id'=>$element_type->id,'eye_id'=>1,'display_order'=>3));
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Diagnoses'));

		$this->delete('element_type_eye','element_type_id='.$element_type->id);
	}
}
