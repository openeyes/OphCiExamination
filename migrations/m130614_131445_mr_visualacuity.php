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
		
	}

	public function down()
	{
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name', array(':name'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('refspec=:ref', array(':ref'=>'MR'))->queryRow();
		$mr_id = $subspecialty['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// insert the setting for subspecialty
		$this->delete('setting_subspecialty', array('subspecialty_id' => $mr_id, 'element_type_id' => $va_id, 'key' => 'unit_id'));
	}

}