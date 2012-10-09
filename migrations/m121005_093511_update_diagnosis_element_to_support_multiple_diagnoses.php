<?php

class m121005_093511_update_diagnosis_element_to_support_multiple_diagnoses extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_diagnosis',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_diagnoses_id' => 'int(10) unsigned NOT NULL',
				'disorder_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'principal' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_diagnosis_element_diagnoses_id_fk` (`element_diagnoses_id`)',
				'KEY `ophciexamination_diagnosis_disorder_id_fk` (`disorder_id`)',
				'KEY `ophciexamination_diagnosis_eye_id_fk` (`eye_id`)',
				'KEY `ophciexamination_diagnosis_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_diagnosis_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_diagnosis_element_diagnoses_id_fk` FOREIGN KEY (`element_diagnoses_id`) REFERENCES `et_ophciexamination_diagnosis` (`id`)',
				'CONSTRAINT `ophciexamination_diagnosis_disorder_id_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `ophciexamination_diagnosis_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `ophciexamination_diagnosis_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_diagnosis_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->renameTable('et_ophciexamination_diagnosis','et_ophciexamination_diagnoses');

		foreach (Yii::app()->db->createCommand("select * from et_ophciexamination_diagnoses")->queryAll() as $row) {
			$d = new OphCiExamination_Diagnosis;
			$d->element_diagnoses_id = $row['id'];
			$d->disorder_id = $row['disorder_id'];
			$d->eye_id = $row['eye_id'];
			$d->save();
		}

		$this->dropForeignKey('et_ophciexamination_diagnosis_disorder_id_fk','et_ophciexamination_diagnoses');
		$this->dropIndex('et_ophciexamination_diagnosis_disorder_id_fk','et_ophciexamination_diagnoses');
		$this->dropColumn('et_ophciexamination_diagnoses','disorder_id');

		$this->dropForeignKey('et_ophciexamination_diagnosis_eye_id_fk','et_ophciexamination_diagnoses');
		$this->dropIndex('et_ophciexamination_diagnosis_eye_id_fk','et_ophciexamination_diagnoses');
		$this->dropColumn('et_ophciexamination_diagnoses','eye_id');

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Diagnosis'));
		$element_type->name = 'Diagnoses';
		$element_type->class_name = 'Element_OphCiExamination_Diagnoses';
		$element_type->save();
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Diagnoses'));
		$element_type->name = 'Diagnosis';
		$element_type->class_name = 'Element_OphCiExamination_Diagnosis';
		$element_type->save();

		$this->addColumn('et_ophciexamination_diagnoses','eye_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->alterColumn('et_ophciexamination_diagnoses','eye_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_diagnosis_eye_id_fk','et_ophciexamination_diagnoses','eye_id');
		$this->addForeignKey('et_ophciexamination_diagnosis_eye_id_fk','et_ophciexamination_diagnoses','eye_id','eye','id');

		$this->addColumn('et_ophciexamination_diagnoses','disorder_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->alterColumn('et_ophciexamination_diagnoses','disorder_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_diagnosis_disorder_id_fk','et_ophciexamination_diagnoses','disorder_id');
		$this->addForeignKey('et_ophciexamination_diagnosis_disorder_id_fk','et_ophciexamination_diagnoses','disorder_id','disorder','id');

		foreach (Yii::app()->db->createCommand("select * from ophciexamination_diagnosis")->queryAll() as $row) {
			Yii::app()->db->createCommand("update et_ophciexamination_diagnoses set disorder_id = {$row['disorder_id']}, eye_id = {$row['eye_id']} where id = {$row['element_diagnoses_id']}")->query();
		}

		$this->renameTable('et_ophciexamination_diagnoses','et_ophciexamination_diagnosis');

		$this->dropTable('ophciexamination_diagnosis');
	}
}
