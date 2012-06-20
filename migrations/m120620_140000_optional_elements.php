<?php

class m120620_140000_optional_elements extends CDbMigration {

	public function up() {
		$this->addColumn('ophciexamination_element_set_item', 'default', 'boolean NOT NULL');
	}

	public function down() {
		$this->dropColumn('ophciexamination_element_set_item', 'default');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}