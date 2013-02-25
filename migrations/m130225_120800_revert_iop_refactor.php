<?php

class m130225_120800_revert_iop_refactor extends OEMigration {

	public function up() {
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'display_order', 'tinyint(3) unsigned DEFAULT \'0\'');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'name', 'varchar(3) COLLATE utf8_bin DEFAULT NULL');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_reading_id', 'int(10) unsigned NOT NULL');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_reading_id', 'int(10) unsigned NOT NULL');
		Yii::app()->db->schema->refresh();
		$elements = Element_OphCiExamination_IntraocularPressure::model()->findAll();
		foreach($elements as $element) {
			$left_reading = OphCiExamination_IntraocularPressure_Reading::model()->find('side = 1 AND element_id = ?', array($element->id));
			if($left_reading) {
				$this->update('et_ophciexamination_intraocularpressure', array('left_reading_id' => $left_reading->value));
			}
			$right_reading = OphCiExamination_IntraocularPressure_Reading::model()->find('side = 0 AND element_id = ?', array($element->id));
			if($right_reading) {
				$this->update('et_ophciexamination_intraocularpressure', array('right_reading_id' => $right_reading->value));
			}
			$this->update('et_ophciexamination_intraocularpressure', array('eye_id' => 2));
		}
		$this->dropForeignKey('ophciexamination_intraocularpressure_reading_eid_fk', 'ophciexamination_intraocularpressure_reading');
		$this->delete('ophciexamination_intraocularpressure_reading');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'side');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'element_id');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'measurement_timestamp');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'dilated');
		Yii::app()->db->schema->refresh();
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_comments');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_comments');
		$this->createIndex('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure','left_reading_id');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure','left_reading_id','ophciexamination_intraocularpressure_reading','id');
		$this->createIndex('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure','right_reading_id');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure','right_reading_id','ophciexamination_intraocularpressure_reading','id');
	}

	public function down() {
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_lri_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_rri_fk', 'et_ophciexamination_intraocularpressure');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_comments', 'text');
		$this->delete('ophciexamination_intraocularpressure_reading');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'side', 'TINYINT(1) UNSIGNED NOT NULL');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'element_id', 'INT(10) UNSIGNED NOT NULL');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'measurement_timestamp', 'TIME');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'dilated', 'TINYINT(1) UNSIGNED NOT NULL');
		$this->addForeignKey('ophciexamination_intraocularpressure_reading_eid_fk', 'ophciexamination_intraocularpressure_reading', 'element_id', 'et_ophciexamination_intraocularpressure', 'id');
		Yii::app()->db->schema->refresh();
		$elements = $this->getDbConnection()->createCommand()
		->select('*')
		->from('et_ophciexamination_intraocularpressure')
		->queryAll();
		foreach($elements as $element) {
			$eyes = 0;
			if($element['left_reading_id']) {
				$left_reading = new OphCiExamination_IntraocularPressure_Reading();
				$left_reading->value = $element['left_reading_id'];
				$left_reading->element_id = $element['id'];
				$left_reading->side = 1;
				$left_reading->measurement_timestamp = date('H:i',strtotime($element['created_date']));
				$left_reading->dilated = 0;
				$left_reading->save();
				$eyes = 2;
			}
			if($element['right_reading_id']) {
				$right_reading = new OphCiExamination_IntraocularPressure_Reading();
				$right_reading->value = $element['right_reading_id'];
				$right_reading->element_id = $element['id'];
				$right_reading->side = 0;
				$right_reading->measurement_timestamp = date('H:i',strtotime($element['created_date']));
				$right_reading->dilated = 0;
				$right_reading->save();
				$eyes += 1;
			}
			if($eyes) {
				$this->update('et_ophciexamination_intraocularpressure', array('eye_id' => $eyes));
			} else {
				throw new CException('Invalid eye');
			}
		}
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'display_order');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'name');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_reading_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_reading_id');
	}

}
