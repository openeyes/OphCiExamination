<?php

class m140620_143832_ishihara_spelling_correction extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('update ophciexamination_colourvision_method set name =\'Ishihara /15\' where name=\'Isihara /15\'')->query();
		Yii::app()->db->createCommand('update ophciexamination_colourvision_method set name =\'Ishihara /21\' where name=\'Isihara /21\'')->query();
	}

	public function down()
	{
		Yii::app()->db->createCommand('update ophciexamination_colourvision_method set name =\'Isihara /15\' where name=\'Ishihara /15\'')->query();
		Yii::app()->db->createCommand('update ophciexamination_colourvision_method set name =\'Isihara /21\' where name=\'Ishihara /21\'')->query();
	}
}