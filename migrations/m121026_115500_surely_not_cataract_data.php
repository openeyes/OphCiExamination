<?php

class m121026_115500_surely_not_cataract_data extends OEMigration {

	public function up() {
		$this->delete('ophciexamination_element_set_item');
		foreach(OphCiExamination_ElementSetRule::model()->findAll(array('order' => 'id desc')) as $rule) {
			$rule->delete();
		}
		$this->delete('ophciexamination_element_set');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
	}

}
