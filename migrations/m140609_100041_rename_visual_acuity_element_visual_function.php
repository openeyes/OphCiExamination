<?php

class m140609_100041_rename_visual_acuity_element_visual_function extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand("update element_type set name = 'Visual Function' where class_name = 'Element_OphCiExamination_VisualAcuity'")->query();
	}

	public function down()
	{
		Yii::app()->db->createCommand("update element_type set name = 'Visual Acuity' where class_name = 'Element_OphCiExamination_VisualAcuity'")->query();
	}
}