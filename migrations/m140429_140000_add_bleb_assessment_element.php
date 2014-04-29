<?php 
class m140429_140000_add_bleb_assessment_element extends OEMigration
{
	public function up()
	{
		$event_type_id = $this->dbConnection->createCommand()->select("id")->from("event_type")->where("class_name = :class_name",array(":class_name" => "OphCiExamination"))->queryScalar();

		$element_types = array(
			'Element_OphCiExamination_Bleb_Assessment' => array('name' => 'Bleb Assessment', 'display_order' => 110),
		);
		$this->insertOEElementType($element_types, $event_type_id);

		$this->createOETable('ophciexamination_bleb_assessment_central_area', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'area' => 'int(10) unsigned NOT NULL',
			'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'active' => 'tinyint(1) unsigned not null DEFAULT 1',
			'PRIMARY KEY (`id`)',
			'UNIQUE (`area`)',
		));

		$this->createOETable('ophciexamination_bleb_assessment_max_area', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'area' => 'int(10) unsigned NOT NULL',
			'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'active' => 'tinyint(1) unsigned not null DEFAULT 1',
			'PRIMARY KEY (`id`)',
			'UNIQUE (`area`)',
		));

		$this->createOETable('ophciexamination_bleb_assessment_height', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'height' => 'int(10) unsigned NOT NULL',
			'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'active' => 'tinyint(1) unsigned not null DEFAULT 1',
			'PRIMARY KEY (`id`)',
			'UNIQUE (`height`)',
		));

		$this->createOETable('ophciexamination_bleb_assessment_vascularity', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'vascularity' => 'int(10) unsigned NOT NULL',
			'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'active' => 'tinyint(1) unsigned not null DEFAULT 1',
			'PRIMARY KEY (`id`)',
			'UNIQUE (`vascularity`)',
		));

		$this->createOETable('et_ophciexamination_bleb_assessment', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'event_id' => 'int(10) unsigned NOT NULL',
			'eye_id' => "int(10) unsigned NOT NULL DEFAULT '3'",
			'left_central_area_id' => 'int(10) unsigned DEFAULT NULL',
			'left_max_area_id' => 'int(10) unsigned DEFAULT NULL',
			'left_height_id' => 'int(10) unsigned DEFAULT NULL',
			'left_vasc_id' => 'int(10) unsigned DEFAULT NULL',
			'right_central_area_id' => 'int(10) unsigned DEFAULT NULL',
			'right_max_area_id' => 'int(10) unsigned DEFAULT NULL',
			'right_height_id' => 'int(10) unsigned DEFAULT NULL',
			'right_vasc_id' => 'int(10) unsigned DEFAULT NULL',
			'PRIMARY KEY (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
  			'CONSTRAINT `et_ophciexamination_bleb_assessment_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_left_central_id_fk` FOREIGN KEY (`left_central_area_id`) REFERENCES `ophciexamination_bleb_assessment_central_area` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_left_max_id_fk` FOREIGN KEY (`left_max_area_id`) REFERENCES `ophciexamination_bleb_assessment_max_area` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_left_height_id_fk` FOREIGN KEY (`left_height_id`) REFERENCES `ophciexamination_bleb_assessment_height` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_left_vasc_id_fk` FOREIGN KEY (`left_vasc_id`) REFERENCES `ophciexamination_bleb_assessment_vascularity` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_right_central_id_fk` FOREIGN KEY (`right_central_area_id`) REFERENCES `ophciexamination_bleb_assessment_central_area` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_right_max_id_fk` FOREIGN KEY (`right_max_area_id`) REFERENCES `ophciexamination_bleb_assessment_max_area` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_right_height_id_fk` FOREIGN KEY (`right_height_id`) REFERENCES `ophciexamination_bleb_assessment_height` (`id`)',
			'CONSTRAINT `et_ophciexamination_bleb_assessment_right_vasc_id_fk` FOREIGN KEY (`right_vasc_id`) REFERENCES `ophciexamination_bleb_assessment_vascularity` (`id`)',
		));

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_bleb_assessment');
		$this->dropTable('ophciexamination_bleb_assessment_vascularity');
		$this->dropTable('ophciexamination_bleb_assessment_height');
		$this->dropTable('ophciexamination_bleb_assessment_max_area');
		$this->dropTable('ophciexamination_bleb_assessment_central_area');

		$this->delete('element_type','name = :name', array(':name'=>'Bleb Assessment'));
	}
}
