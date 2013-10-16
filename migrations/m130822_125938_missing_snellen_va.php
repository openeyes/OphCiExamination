<?php

class m130822_125938_missing_snellen_va extends CDbMigration
{
	public function up()
	{
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];

		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '6/96',
				'base_value' => 50));
	}

	public function down()
	{
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];

		$this->delete('ophciexamination_visual_acuity_unit_value',
			'unit_id = :unit_id AND value = :value',
			array(
				':unit_id' => $snellen_id,
				':value' => '6/96',
			) );
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}