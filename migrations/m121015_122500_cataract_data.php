<?php

class m121015_122500_cataract_data extends OEMigration {

	public function up() {
		$this->delete('ophciexamination_attribute_option');
		$this->delete('ophciexamination_attribute');
		$this->delete('ophciexamination_element_set_item');
		foreach (Yii::app()->db->createCommand()->select("id")->from("ophciexamination_element_set_rule")->order("id desc")->queryAll() as $rule) {
			$this->delete("ophciexamination_element_set_rule","id={$rule['id']}");
		}
		$this->delete('ophciexamination_element_set');
		$this->delete('ophciexamination_visualacuity_method');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
	}

}
