<?php

class m130614_131445_mr_visualacuity extends CDbMigration
{
	public function up()
	{
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('ref_spec=:ref', array(':ref'=>'MR'))->queryRow();
		$mr_id = $subspecialty['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// insert the setting for subspecialty
		$this->insert('setting_subspecialty', array('subspecialty_id' => $mr_id, 'element_type_id' => $va_id, 'key' => 'unit_id', 'value' => $etdrs_id));
		
		//now keeping track of the units used to record the va
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];
		
		$this->addColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned');
		
		$this->update('et_ophciexamination_visualacuity', array('unit_id' => $snellen_id));
		
		$this->alterColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_unid_fk', 'et_ophciexamination_visualacuity', 'unit_id', 'ophciexamination_visual_acuity_unit', 'id');
		
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_visualacuity', 'unit_id');
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('ref_spec=:ref', array(':ref'=>'MR'))->queryRow();
		$mr_id = $subspecialty['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// insert the setting for subspecialty
		$this->delete('setting_subspecialty', 'subspecialty_id=:ss_id AND element_type_id=:et_id AND `key`=:ky', array(':ss_id' => $mr_id, ':et_id' => $va_id, ':ky' => "unit_id"));
	}

}