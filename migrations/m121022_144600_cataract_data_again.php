<?php

class m121022_144600_cataract_data_again extends OEMigration {

	public function up() {
		$this->delete('ophciexamination_element_set_item');
		foreach (Yii::app()->db->createCommand()->select("id")->from("ophciexamination_element_set_rule")->order("id desc")->queryAll() as $rule) {
			$this->delete("ophciexamination_element_set_rule","id={$rule['id']}");
		}
		$this->delete('ophciexamination_element_set');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
	}

}
