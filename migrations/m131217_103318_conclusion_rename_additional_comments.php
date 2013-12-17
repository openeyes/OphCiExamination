<?php

class m131217_103318_conclusion_rename_additional_comments extends CDbMigration
{
	public function up()
	{
		$this->renameTable('et_ophciexamination_conclusion','et_ophciexamination_additionalcomments');
		$db = Yii::app()->db;

		$db->createCommand("update element_type set name='Additional Comments' , class_name = 'Element_OphCiExamination_AdditionalComments' where class_name='Element_OphCiExamination_Conclusion';")->execute();

	}

	public function down()
	{
		$this->renameTable('et_ophciexamination_additionalcomments','et_ophciexamination_conclusion');
		$db = Yii::app()->db;

		$db->createCommand("update element_type set name='Conclusion' ,class_name = 'Element_OphCiExamination_Conclusion' where class_name='Element_OphCiExamination_AdditionalComments'")->execute();

	}

}
