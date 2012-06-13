<?php

class m120612_17090_initial_migration_for_ophxxexamination extends CDbMigration {

	public function up() {

		/* Currently done in core migration
		// Get the event group for ‘Drug events’
		$group = $this->dbConnection->createCommand()
		->select('id')
		->from('event_group')
		->where('name=:name',array(':name'=>'Drug events'))
		->queryRow();

		// Create the new Prescription event_type
		$this->insert('event_type', array(
				'name' => 'Prescription',
				'event_group_id' => $group['id'],
				'class_name' => 'OphDrPrescription'
		));
		 */

		// Get the newly created event type
		$event_type = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('name=:name', array(':name'=>'Prescription'))
		->queryRow();

		// Create an element for the new event type called Element_OphDrPrescription_Details
		$this->insert('element_type', array(
				'name' => 'Details',
				'class_name' => 'Element_OphDrPrescription_Details',
				'event_type_id' => $event_type['id'],
				'display_order' => 1,
				'default' => 1,
		));

		// Create a table to store the Element_OphDrPrescription_Details
		$this->createTable('et_ophdrprescription_details', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'comments' => 'varchar(255)',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophdrprescription_details_event_id_fk` (`event_id`)',
				'KEY `et_ophdrprescription_details_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophdrprescription_details_last_modified_user_id_fk` (`last_modified_user_id`)',
				'CONSTRAINT `et_ophdrprescription_details_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophdrprescription_details_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophdrprescription_details_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

			// Create a table to store the prescription items
		$this->createTable('ophdrprescription_item', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'prescription_id' => 'int(10) unsigned NOT NULL',
				'drug_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophdrprescription_details_prescription_id_fk` (`prescription_id`)',
				'KEY `ophdrprescription_details_drug_id_fk` (`drug_id`)',
				'KEY `ophdrprescription_details_created_user_id_fk` (`created_user_id`)',
				'KEY `ophdrprescription_details_last_modified_user_id_fk` (`last_modified_user_id`)',
				'CONSTRAINT `ophdrprescription_details_prescription_id_fk` FOREIGN KEY (`prescription_id`) REFERENCES `et_ophdrprescription_details` (`id`)',
				'CONSTRAINT `ophdrprescription_details_drug_id_fk` FOREIGN KEY (`drug_id`) REFERENCES `drug` (`id`)',
				'CONSTRAINT `ophdrprescription_details_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophdrprescription_details_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

	}

	public function down() {
		
		// Drop the tables created
		$this->dropTable('ophdrprescription_item');
		$this->dropTable('et_ophdrprescription_details');
		
		// Find the event type
		$event_type = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('name=:name', array(':name'=>'Prescription'))
		->queryRow();

		// Find the ElementDetails element type
		$element_type = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('name=:name and event_type_id=:event_type_id',array(
				':name'=>'Details',
				':event_type_id'=>$event_type['id']
		))->queryRow();

		// Delete the ElementDetails element type
		$this->delete('element_type','id='.$element_type['id']);

		/* Currently done in core migration
		// Delete the event type
		$this->delete('event_type','id='.$event_type['id']);
		 */

	}

}