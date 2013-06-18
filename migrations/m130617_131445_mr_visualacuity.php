<?php

class m130617_131445_mr_visualacuity extends CDbMigration
{
	public function up()
	{
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')
			->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')
			->where('ref_spec=:ref', array(':ref'=>'MR'))->queryRow();
		$mr_id = $subspecialty['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// insert the setting for subspecialty
		$this->insert('setting_subspecialty', array('subspecialty_id' => $mr_id, 'element_type_id' => $va_id, 'key' => 'unit_id', 'value' => $etdrs_id));
		
		// now keeping track of the units used to record the va
		// up until now, they've all been Snellen Metre
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];
		
		$this->addColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned');
		
		$this->update('et_ophciexamination_visualacuity', array('unit_id' => $snellen_id));
		
		$this->alterColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_unit_fk', 'et_ophciexamination_visualacuity', 'unit_id', 'ophciexamination_visual_acuity_unit', 'id');
		
		// add flag to unit_value table to indicate whether the conversion value is just there for display, or is a valid value to be recorded
		$this->addColumn('ophciexamination_visual_acuity_unit_value', 'selectable', 'boolean NOT NULL DEFAULT true');
		
		// ETDRS equivalent of 1/60
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $etdrs_id,
				'value' => 'N/A',
				'selectable' => false,
				'base_value' => 21));
		
		// add column on VA units to flag whether it should be shown in conversion tool tip
		$this->addColumn('ophciexamination_visual_acuity_unit', 'tooltip', 'boolean NOT NULL DEFAULT false');
		
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $snellen_id));
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $etdrs_id));
		
	}

	public function down()
	{
		echo "***WARNING: down migration will remove selectable values for VA. Edit migration and remove return statement to perform this down step";
		//return false;
		$this->dropForeignKey('et_ophciexamination_visualacuity_unit_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'unit_id');
		$this->dropColumn('ophciexamination_visual_acuity_unit_value', 'selectable');
		$this->dropColumn('ophciexamination_visual_acuity_unit', 'tooltip');
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('ref_spec=:ref', array(':ref'=>'MR'))->queryRow();
		$mr_id = $subspecialty['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// remove the setting for subspecialty
		$this->delete('setting_subspecialty', 'subspecialty_id=:ss_id AND element_type_id=:et_id AND `key`=:ky', array(':ss_id' => $mr_id, ':et_id' => $va_id, ':ky' => "unit_id"));
		
		// remove the additional scale entries
		$this->delete('ophciexamination_visual_acuity_unit_value', 'base_value = :bv', array(':bv' => 5));
	}

}