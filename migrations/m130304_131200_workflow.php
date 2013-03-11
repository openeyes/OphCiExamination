<?php

class m130304_131200_workflow extends OEMigration {
	
	public function up() {
		
		 $this->createTable('ophciexamination_workflow', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_workflow_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_workflow_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_workflow_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_workflow_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->createTable('ophciexamination_event_elementset_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'step_id' => 'int(10) unsigned NOT NULL',
				'event_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_event_ea_step_id_fk` (`step_id`)',
				'KEY `ophciexamination_event_ea_event_id_fk` (`event_id`)',
				'KEY `ophciexamination_event_ea_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_event_ea_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_event_ea_step_id_fk` FOREIGN KEY (`step_id`) REFERENCES `ophciexamination_element_set` (`id`)',
				'CONSTRAINT `ophciexamination_event_ea_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `ophciexamination_event_ea_event_id_unique` UNIQUE (`event_id`)',
				'CONSTRAINT `ophciexamination_event_ea_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_event_ea_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
				
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->addColumn('ophciexamination_element_set', 'position', 'int(10) unsigned NOT NULL DEFAULT 1');
		$this->addColumn('ophciexamination_element_set', 'workflow_id', 'int(10) unsigned');
		$this->addForeignKey('ophciexamination_element_set_workflow_id_fk', 'ophciexamination_element_set', 'workflow_id', 'ophciexamination_workflow', 'id');
		
		// reset the schema to ensure it's picked up latest table changes.
		Yii::app()->cache->flush();
		
		foreach(OphCiExamination_ElementSet::model()->findAll() as $set) {
			$workflow = new OphCiExamination_Workflow();
			$workflow->name = $set->name;
			if(!$workflow->save()) {
				throw new CException('Error saving workflow');
			}
			$set->workflow_id = $workflow->id;
			if(!$set->save()) {
				throw new CException('Error saving set');
			}
		}
		$this->alterColumn('ophciexamination_element_set', 'workflow_id', 'int(10) unsigned NOT NULL');
		$this->addColumn('ophciexamination_element_set_rule', 'workflow_id', 'int(10) unsigned');
		$this->dropForeignKey('ophciexamination_element_set_rule_set_id_fk', 'ophciexamination_element_set_rule');
		foreach(OphCiExamination_ElementSetRule::model()->findAll() as $rule) {
			$rule->workflow_id = OphCiExamination_ElementSet::model()->findByPk($rule->set_id)->workflow_id;
			if(!$rule->save()) {
				throw new CException('Error saving rule');
			}
		}
		$this->dropColumn('ophciexamination_element_set_rule', 'set_id');
		$this->addForeignKey('ophciexamination_element_set_rule_workflow_id_fk', 'ophciexamination_element_set_rule', 'workflow_id', 'ophciexamination_workflow', 'id');
	}

	public function down() {
		$this->dropForeignKey('ophciexamination_element_set_rule_workflow_id_fk', 'ophciexamination_element_set_rule');
		$this->addColumn('ophciexamination_element_set_rule', 'set_id', 'int(10) unsigned');
		foreach(OphCiExamination_ElementSetRule::model()->findAll() as $rule) {
			$rule->set_id = OphCiExamination_ElementSet::model()->find('workflow_id = ?', array($rule->workflow_id))->id;
			if(!$rule->save()) {
				throw new CException('Error saving rule');
			}
		}
		$this->dropColumn('ophciexamination_element_set_rule', 'workflow_id');
		$this->addForeignKey('ophciexamination_element_set_rule_set_id_fk', 'ophciexamination_element_set_rule', 'set_id', 'ophciexamination_element_set', 'id');
		$this->dropForeignKey('ophciexamination_element_set_workflow_id_fk', 'ophciexamination_element_set');
		$this->dropColumn('ophciexamination_element_set', 'workflow_id');
		$this->dropColumn('ophciexamination_element_set', 'position');
		$this->dropTable('ophciexamination_workflow');
		$this->dropTable('ophciexamination_event_elementset_assignment');
	}
	
}
