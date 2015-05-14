<?php

class m150512_092929_near_visual_acuity extends OEMigration
{
	public function up()
	{
		//These tables are versioned seperately because the ID needs to be different from what PK creates for the FK to work
		$this->createOETable('et_ophciexamination_nearvisualacuity', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'event_id' => 'int(10) unsigned NOT NULL',
			'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3',
			'unit_id' => 'int(10) unsigned not null',
			'left_unable_to_assess' => 'tinyint(1) unsigned not null',
			'right_unable_to_assess' => 'tinyint(1) unsigned not null',
			'left_eye_missing' => 'tinyint(1) unsigned not null',
			'right_eye_missing' => 'tinyint(1) unsigned not null',
			'PRIMARY KEY (`id`)',
			'CONSTRAINT `et_ophciexamination_nearvisualacuity_unit_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`)',
			'CONSTRAINT `et_ophciexamination_nearvisualacuity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			'CONSTRAINT `et_ophciexamination_nearvisualacuity_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), false);

		$this->versionExistingTable('et_ophciexamination_nearvisualacuity');

		$this->createOETable('ophciexamination_nearvisualacuity_reading', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'element_id' => 'int(10) unsigned NOT NULL',
			'value' => 'int(10) unsigned NOT NULL',
			'method_id' => 'int(10) unsigned not null',
			'side' => 'tinyint(1) unsigned not null',
			'PRIMARY KEY (`id`)',
			'CONSTRAINT `ophciexamination_nearvisualacuity_reading_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_nearvisualacuity` (`id`)',
			'CONSTRAINT `ophciexamination_nearvisualacuity_reading_method_id_fk` FOREIGN KEY (`method_id`) REFERENCES `ophciexamination_visualacuity_method` (`id`)',
		), false);

		$this->versionExistingTable('ophciexamination_nearvisualacuity_reading');

		$visualFunction = $this->getDbConnection()->createCommand('select id from element_type where `name` = "Visual Function"')->queryRow();
		$eventType = $this->getDbConnection()->createCommand('select id from event_type where `name` = "Examination"')->queryRow();

		if($visualFunction && $eventType){
			$nearVisualElement = array(
				'name' => 'Near Visual Acuity',
				'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_NearVisualAcuity',
				'event_type_id' => $eventType['id'],
				'display_order' => 50,
				'default' => 1,
				'parent_element_type_id' => $visualFunction['id'],
				'required' => 0
			);
			$this->insert('element_type', $nearVisualElement);
		}

	}

	public function down()
	{
		$this->dropOETable('ophciexamination_nearvisualacuity_reading', true);
		$this->dropOETable('et_ophciexamination_nearvisualacuity', true);
		$this->delete('element_type', 'name = "Near Visual Acuity"');
	}

}