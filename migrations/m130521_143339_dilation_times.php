<?php

class m130521_143339_dilation_times extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_dilation_treatment','treatment_time','time NOT NULL');

		foreach (Yii::app()->db->createCommand()->select("*")->from("et_ophciexamination_dilation")->queryAll() as $dilation) {
			$this->update('ophciexamination_dilation_treatment',array('treatment_time'=>$dilation['right_time']),"element_id = {$dilation['id']} and side = 0");
			$this->update('ophciexamination_dilation_treatment',array('treatment_time'=>$dilation['left_time']),"element_id = {$dilation['id']} and side = 1");
		}

		$this->dropColumn('et_ophciexamination_dilation','right_time');
		$this->dropColumn('et_ophciexamination_dilation','left_time');
	}

	public function down()
	{
		$this->addColumn('et_ophciexamination_dilation','left_time','time NOT NULL');
		$this->addColumn('et_ophciexamination_dilation','right_time','time NOT NULL');

		$this->dropColumn('ophciexamination_dilation_treatment','treatment_time');
	}
}
