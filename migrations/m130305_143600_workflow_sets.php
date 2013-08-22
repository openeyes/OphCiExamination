<?php

class m130305_143600_workflow_sets extends OEMigration
{
	public function up()
	{
		// Delete all the existing rules
		$this->delete('ophciexamination_element_set_item');
		foreach (Yii::app()->db->createCommand()->select("id")->from("ophciexamination_element_set_rule")->order("id desc")->queryAll() as $rule) {
			$this->delete("ophciexamination_element_set_rule","id={$rule['id']}");
		}
		$this->delete('ophciexamination_event_elementset_assignment');
		$this->delete('ophciexamination_element_set');
		$this->delete('ophciexamination_workflow');

		// Import new ones
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
	}

}
