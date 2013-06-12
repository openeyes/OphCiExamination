<?php

class m130604_134337_patient_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$event_type->registerShortcode('hpc','getLetterHistory','History of presenting complaint');
		$event_type->registerShortcode('ipb','getLetterIOPReadingBoth','Intraocular pressure in both eyes');
		$event_type->registerShortcode('ipl','getLetterIOPReadingLeft','Intraocular pressure in the left eye');
		$event_type->registerShortcode('ipp','getLetterIOPReadingPrincipal','Intraocular pressure in the principal eye');
		$event_type->registerShortcode('ipr','getLetterIOPReadingRight','Intraocular pressure in the right eye');
		$event_type->registerShortcode('asl','getLetterAnteriorSegmentLeft','Anterior segment findings in the left eye');
		$event_type->registerShortcode('asp','getLetterAnteriorSegmentPrincipal','Anterior segment findings in the principal eye');
		$event_type->registerShortcode('asr','getLetterAnteriorSegmentRight','Anterior segment findings in the right eye');
		$event_type->registerShortcode('psl','getLetterPosteriorPoleLeft','Posterior pole findings in the left eye');
		$event_type->registerShortcode('psp','getLetterPosteriorPolePrincipal','Posterior pole findings in the principal eye');
		$event_type->registerShortcode('psr','getLetterPosteriorPoleRight','Posterior pole findings in the right eye');
		$event_type->registerShortcode('vbb','getLetterVisualAcuityBoth','Best visual acuity in both eyes');
		$event_type->registerShortcode('vbl','getLetterVisualAcuityLeft','Best visual acuity in the left eye');
		$event_type->registerShortcode('vbp','getLetterVisualAcuityPrincipal','Best visual acuity in the principal eye');
		$event_type->registerShortcode('vbr','getLetterVisualAcuityRight','Best visual acuity in the right eye');
		$event_type->registerShortcode('con','getLetterConclusion','Conclusion');
		$event_type->registerShortcode('man','getLetterManagement','Management');
		$event_type->registerShortcode('adr','getLetterAdnexalComorbidityRight','Adnexal comorbidity in the right eye');
		$event_type->registerShortcode('adl','getLetterAdnexalComorbidityLeft','Adnexal comorbidity in the left eye');
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$this->delete('patient_shortcode','event_type_id=:etid',array(':etid'=>$event_type->id));
	}
}
