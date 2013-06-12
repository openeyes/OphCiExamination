<?php

class m121127_171400_add_values_to_eyedraw_lookups extends OEMigration {

	public function up() {
		$this->addColumn('ophciexamination_anteriorsegment_pupil', 'value', 'varchar(64)');
		$this->addColumn('ophciexamination_anteriorsegment_nuclear', 'value', 'varchar(64)');
		$this->addColumn('ophciexamination_anteriorsegment_cortical', 'value', 'varchar(64)');
		foreach(array('Pupil','Nuclear','Cortical') as $table) {
			$class = 'OphCiExamination_AnteriorSegment_'.$table;
			foreach($class::model()->findAll() as $record) {
				if($record->name == 'None') {
					$record->value = '';
				} else {
					$record->value = $record->name;
				}
				$record->save();
			}
		}
	}

	public function down() {
		$this->dropColumn('ophciexamination_anteriorsegment_pupil', 'value');
		$this->dropColumn('ophciexamination_anteriorsegment_nuclear', 'value');
		$this->dropColumn('ophciexamination_anteriorsegment_cortical', 'value');
	}
}
