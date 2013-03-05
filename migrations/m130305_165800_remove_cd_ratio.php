<?php

class m130305_165800_remove_cd_ratio extends OEMigration {
	
	public function up() {
		foreach(Element_OphCiExamination_PosteriorPole::model()->findAll() as $element) {
			$description = array(
					'left' => $element->left_description,
					'right' => $element->right_description,
			);
			foreach(array('left', 'right') as $side) {
				if($element->{$side.'_cd_ratio'}) {
					$description[$side] .= ' C/D Ratio = ' . $element->{$side.'_cd_ratio'}->name;
				}
			}
			$this->update('et_ophciexamination_posteriorpole', array(
					'left_description' => $description['left'],
					'right_description' => $description['right'],
			), 'id = :id', array(':id' => $element->id));
		}
		$this->dropForeignKey('et_ophciexamination_posteriorpole_lcri_fk', 'et_ophciexamination_posteriorpole');
		$this->dropColumn('et_ophciexamination_posteriorpole', 'left_cd_ratio_id');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_rcri_fk', 'et_ophciexamination_posteriorpole');
		$this->dropColumn('et_ophciexamination_posteriorpole', 'right_cd_ratio_id');
		$this->dropTable('ophciexamination_posteriorpole_cd_ratio');
	}

	public function down() {
		$this->createTable('ophciexamination_posteriorpole_cd_ratio',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(3) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_posteriorsegment_cd_ratio_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_posteriorsegment_cd_ratio_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_posteriorsegment_cd_ratio_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_posteriorsegment_cd_ratio_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		$this->addColumn('et_ophciexamination_posteriorpole', 'left_cd_ratio_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_posteriorpole_lcri_fk', 'et_ophciexamination_posteriorpole', 'left_cd_ratio_id', 'ophciexamination_posteriorpole_cd_ratio', 'id');
		$this->addColumn('et_ophciexamination_posteriorpole', 'right_cd_ratio_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_posteriorpole_rcri_fk', 'et_ophciexamination_posteriorpole', 'right_cd_ratio_id', 'ophciexamination_posteriorpole_cd_ratio', 'id');
	}
	
}
