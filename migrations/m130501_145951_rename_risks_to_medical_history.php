<?php

class m130501_145951_rename_risks_to_medical_history extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->update('element_type',array('name'=>'Medical history'),"event_type_id = $event_type->id and class_name = 'Element_OphCiExamination_Risks'");
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->update('element_type',array('name'=>'Risks'),"event_type_id = $event_type->id and class_name = 'Element_OphCiExamination_Risks'");
	}
}
