<?php

class m140617_123338_rename_management_plan_elements extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand("update element_type set name = 'Glaucoma Current Management plan' where class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_CurrentManagementPlan'")->query();
		Yii::app()->db->createCommand("update element_type set name = 'Glaucoma Overall Management plan' where class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_OverallManagementPlan'")->query();
	}

	public function down()
	{
		Yii::app()->db->createCommand("update element_type set name = 'Current Management plan' where class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_CurrentManagementPlan'")->query();
		Yii::app()->db->createCommand("update element_type set name = 'Overall Management plan' where class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_OverallManagementPlan'")->query();
	}

}