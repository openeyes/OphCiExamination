<?php

class m141003_135433_gpt_shortcode extends CDbMigration
{
	public function up()
	{
		$exam_event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')
			->where('name=:name', array(':name'=>'Examination'))->queryRow();

		$exam_event_type_id = $exam_event_type['id'];

		$this->insert(
			'patient_shortcode',
			array(
				'default_code' => 'ptg',
				'code' => 'ptg',
				'description' => 'Patient Ticket Glaucoma',
				'event_type_id' => $exam_event_type_id,
				'method' => 'getGlaucomaPatientTicket',
			)
		);
	}

	public function down()
	{
		$this->delete('patient_shortcode', 'description = ?', array('Patient Ticket Glaucoma'));
	}
}