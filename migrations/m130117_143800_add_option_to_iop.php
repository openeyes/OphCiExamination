<?php

class m130117_143800_add_option_to_iop extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_instrument', 'display_order', 'int(10) unsigned default 1');
		$i = 1;
		foreach (OphCiExamination_Instrument::model()->findAll() as $instrument) {
			if ($instrument->name == 'Other') {
				$instrument->display_order = 1000;
			} else {
				$instrument->display_order = $i * 10;
			}
			$instrument->save();
			$i++;
		}
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropColumn('ophciexamination_instrument', 'display_order');
		$this->delete('ophciexamination_instrument','id = 6');
	}

}
