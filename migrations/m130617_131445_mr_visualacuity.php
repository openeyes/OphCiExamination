<?php

class m130617_131445_mr_visualacuity extends CDbMigration
{
	public function up()
	{
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')
			->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
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
		
		// add column on VA units to provide informational text to display in VA element
		$this->addColumn('ophciexamination_visual_acuity_unit', 'information', 'text');
		
		$this->update('ophciexamination_visual_acuity_unit', array('information' => 'ETDRS letters score is at 1m. For tests done at 4m, 30 letters should be added, at 2m, 15 letters should be added.'), 'id = :uid', array(':uid' => $etdrs_id));
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
		->where('name=:name', array(':name'=>'logMAR'))->queryRow();
		$logmar_id = $units['id'];
		
		// set up logMar unit values
		$logMar = 1.6;
		for ($i = 30; $i <= 125; $i+=5) {
			// dirty hack to avoid -0.0 as a value
			if ($logMar < 0 && $logMar + 0.05 > 0) {
				$logMar = 0;
			}
			$this->insert('ophciexamination_visual_acuity_unit_value', array(
					'unit_id' => $logmar_id,
					'value' => sprintf('%.1f', $logMar),
					'selectable' => true,
					'base_value' => $i));
			$logMar -= 0.1;
		}
		// logMar equiv for bottom end of scale
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $logmar_id,
				'value' => '1.78',
				'selectable' => false,
				'base_value' => 21));
		
		$this->update('ophciexamination_visual_acuity_unit', array('information' => 'logMAR score is at 1m. For tests done at 4m, subtract 0.6 logMAR, at 2m, subtract 0.3 logMar.'), 'id = :uid', array(':uid' => $logmar_id));
		// turn logMAR on
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $logmar_id));
	}

	public function down()
	{
		echo "***WARNING: down migration will remove selectable values for VA. Edit migration and remove return statement to perform this down step";
		//return false;
		$this->dropForeignKey('et_ophciexamination_visualacuity_unit_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'unit_id');
		$this->dropColumn('ophciexamination_visual_acuity_unit_value', 'selectable');
		$this->dropColumn('ophciexamination_visual_acuity_unit', 'tooltip');
		$this->dropColumn('ophciexamination_visual_acuity_unit', 'information');
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'logMar'))->queryRow();
		$logmar_id = $units['id'];
		
		// remove the logmar entries
		$this->delete('ophciexamination_visual_acuity_unit_value', 'unit_id = :uid', array(':uid' => $logmar_id));
		
		// remove the additional scale entries
		$this->delete('ophciexamination_visual_acuity_unit_value', 'base_value = :bv AND unit_id = :uid', array(':bv' => 21, ':uid' => $etdrs_id));
	}

}