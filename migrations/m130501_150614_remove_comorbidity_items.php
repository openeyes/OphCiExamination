<?php

class m130501_150614_remove_comorbidity_items extends CDbMigration
{
	public function up()
	{
		$this->delete('ophciexamination_attribute_option',"value='crusting of lashes'");
		$this->delete('ophciexamination_attribute_option',"value='lower lid ectropion'");
		$this->delete('ophciexamination_attribute_option',"value='injected lid margins'");
	}

	public function down()
	{
	}
}
