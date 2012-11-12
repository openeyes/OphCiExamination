<?php

class m121012_130734_set_management_element_to_be_default_for_cataract_subspecialty extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Management'));

		$this->insert('ophciexamination_element_set_item',array('set_id'=>2,'element_type_id'=>$element_type->id));
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Management'));

		$this->delete('ophciexamination_element_set_item','set_id=2 and element_type_id='.$element_type->id);
	}
}
