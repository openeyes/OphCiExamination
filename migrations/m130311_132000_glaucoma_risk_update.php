<?php

class m130311_132000_glaucoma_risk_update extends OEMigration
{
	public function up()
	{
		$this->update('element_type', array('name' => 'Glaucoma Risk Stratification'), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_GlaucomaRisk'));
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id');
	}

	public function down()
	{
	}
}
