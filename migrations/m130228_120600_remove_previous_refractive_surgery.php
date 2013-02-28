<?php

class m130228_120600_remove_previous_refractive_surgery extends CDbMigration {
	
	public function up() {
		$this->insert('ophciexamination_comorbidities_item', array('name' => 'Refractive Surgery', 'display_order' => '115'));
		$previous_rs_id = OphCiExamination_Comorbidities_Item::model()->find('name = ?', array('Refractive Surgery'))->id;
		foreach(Element_OphCiExamination_History::model()->findAll('previous_refractive_surgery = 1') as $history) {
			$comorbidities = Element_OphCiExamination_Comorbidities::model()->find('event_id = ?', array($history->event_id));
			if(!$comorbidities) {
				$comorbidities = new Element_OphCiExamination_Comorbidities;
				$comorbidities->event_id = $history->event_id;
				if(!$comorbidities->save()) {
					throw new CException('Cannot save Element_OphCiExamination_Comorbidities' . print_r($comorbidities->getErrors(), true));
				}
			}
			$assignment = new OphCiExamination_Comorbidities_Assignment;
			$assignment->element_id = $comorbidities->id;
			$assignment->item_id = $previous_rs_id;
			if(!$assignment->save()) {
				throw new CException('Cannot save OphCiExamination_Comorbidities_Assignment' . print_r($assignment->getErrors(), true));
			}
		}
		$this->dropColumn('et_ophciexamination_history', 'previous_refractive_surgery');
		
	}

	public function down() {
		$this->addColumn('et_ophciexamination_history', 'previous_refractive_surgery', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$previous_rs_id = OphCiExamination_Comorbidities_Item::model()->find('name = ?', array('Refractive Surgery'))->id;
		foreach(OphCiExamination_Comorbidities_Assignment::model()->findAll('item_id = ?', array($previous_rs_id)) as $assignment) {
			$this->update('et_ophciexamination_history', array('previous_refractive_surgery' => 1), 'event_id = :event_id', array(':event_id' => $assignment->element->event_id));
		}
		$this->delete('ophciexamination_comorbidities_assignment', 'item_id = ?', array($previous_rs_id));
		$this->delete('ophciexamination_comorbidities_item', 'name = ?', array('Refractive Surgery'));
	}

}