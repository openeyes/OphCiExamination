<?php

class m130617_104158_va_scale_update extends CDbMigration
{
	public function up()
	{
		// foreach scale that exists, need to increment the current base value mapping by 20
		// (we are using 20 to give more wriggle room for any special values or smaller values that might be required later)
		$values = $this->dbConnection->createCommand()->select(array('id', 'base_value'))
			->from('ophciexamination_visual_acuity_unit_value')
			->where('base_value > :bv', array(':bv' => 4))
			->queryAll();

		foreach ($values as $val) {
			$this->update('ophciexamination_visual_acuity_unit_value', array('base_value' => $val['base_value']+20), 'id = :id', array(':id' => $val['id']));
		}

		$records = $this->dbConnection->createCommand()->select(array('id', 'value'))
			->where('value > :bv', array(':bv' => 4))
			->from('ophciexamination_visualacuity_reading')
			->queryAll();
		foreach ($records as $rec) {
			$this->update('ophciexamination_visualacuity_reading', array('value' => $rec['value']+20), 'id = :id', array(':id' => $rec['id']));
		}

		// now add the new va values for snellen metre
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];

		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '1/60',
				'base_value' => 21));

		if (!$this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit_value')
			->where('unit_id=:ui and value=:val', array(':ui'=>$snellen_id,':val'=>'2/60'))->queryRow()) {
				$this->insert('ophciexamination_visual_acuity_unit_value', array(
						'unit_id' => $snellen_id,
						'value' => '2/60',
						'base_value' => 36));
		}


	}

	public function down()
	{
		if ($this->dbConnection->createCommand()->select('id')->from('ophciexamination_visualacuity_reading')
			->where('value > :non_readings AND value < :min_reading', array(':non_readings'=>4,':min_reading'=>25))->queryRow()) {
				echo "CANNOT MIGRATE DOWN - atleast one VA reading exists that cannot be recorded on original VA base scale\n";
				return false;
		}
		// remove the additional va values for snellen metre
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];

		$this->delete('ophciexamination_visual_acuity_unit_value',
				'unit_id = :unit_id AND value = :value',
				array(
					':unit_id' => $snellen_id,
					':value' => '1/60',
				) );

		// revert conversion scales
		$values = $this->dbConnection->createCommand()->select(array('id', 'base_value'))
			->from('ophciexamination_visual_acuity_unit_value')
			->where('base_value > :bv', array(':bv' => 4))
			->queryAll();

		foreach ($values as $val) {
			$this->update('ophciexamination_visual_acuity_unit_value', array('base_value' => $val['base_value']-20), 'id = :id', array(':id' => $val['id']));
		}

		$records = $this->dbConnection->createCommand()->select(array('id', 'value'))
			->where('value > :bv', array(':bv' => 4))
			->from('ophciexamination_visualacuity_reading')
			->queryAll();
		foreach ($records as $rec) {
			$this->update('ophciexamination_visualacuity_reading', array('value' => $rec['value']-20), 'id = :id', array(':id' => $rec['id']));
		}


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
