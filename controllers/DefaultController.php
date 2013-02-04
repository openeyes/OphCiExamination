<?php

class DefaultController extends NestedElementsEventTypeController {
	
	public function actionCreate() {
		parent::actionCreate();
	}

	public function actionUpdate($id) {
		parent::actionUpdate($id);
	}

	public function actionView($id) {
		parent::actionView($id);
	}

	public function actionPrint($id) {
		parent::actionPrint($id);
	}

	protected function getCleanDefaultElements($event_type_id) {
		return $this->getElementsBySet($this->episode);
	}

	protected function getCleanChildDefaultElements($parent, $event_type_id) {
		return $this->getChildElementsBySet($parent, $this->episode);
	}
	
	/**
	 * Get the array of elements for the current site, subspecialty and episode status
	 * @param Episode $episode
	 * @param integer $default
	 */
	protected function getElementsBySet($episode = null) {
		$elements = array();
		$site_id = Yii::app()->request->cookies['site_id']->value;
		$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
		$status_id = ($episode) ? $episode->episode_status_id : 1;
		$set = OphCiExamination_ElementSetRule::findSet($site_id, $subspecialty_id, $status_id);
		$element_types = $set->DefaultElementTypes;
		foreach($element_types as $element_type) {
			if (!$element_type->parent_element_type_id) {
				$elements[] = new $element_type->class_name;
			}
		}
		return $elements;
	}
	
	/*
	 * returns the child elements of the provided parent element that are in the set for the current subspecialty etc
	 * 
	 */
	protected function getChildElementsBySet($parent, $episode = null) {
		$elements = array();
		$site_id = Yii::app()->request->cookies['site_id']->value;
		$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
		$status_id = ($episode) ? $episode->episode_status_id : 1;
		$set = OphCiExamination_ElementSetRule::findSet($site_id, $subspecialty_id, $status_id);
		$element_types = $set->DefaultElementTypes;
		foreach($element_types as $element_type) {
			if ($element_type->parent_element_type_id == $parent->id) {
				$elements[] = new $element_type->class_name;
			}
		}
		return $elements;
	}

	public function actionGetDisorderTableRow() {
		if (@$_GET['disorder_id'] == '0') return;

		if (!$disorder = Disorder::model()->findByPk(@$_GET['disorder_id'])) {
			throw new Exception('Unable to find disorder: '.@$_GET['disorder_id']);
		}

		if (!$the_eye = Eye::model()->find('name=?',array(ucfirst(@$_GET['side'])))) {
			throw new Exception('Unable to find eye: '.@$_GET['side']);
		}

		$id = $_GET['id'];

		echo '<tr><td>'.$disorder->term.'</td><td>';

		foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {
			echo '<span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'.$id.']" value="'.$eye->id.'"';
			if ($eye->id == $the_eye->id) {
				echo 'checked="checked" ';
			}
			echo '/> '.$eye->name.'</span> ';
		}

		echo '</td><td><input type="radio" name="principal_diagnosis" value="'.$disorder->id.'"';
		if ($id == 0) {
			echo 'checked="checked" ';
		}
		echo '/></td><td><a href="#" class="small removeDiagnosis" rel="'.$disorder->id.'"><strong>Remove</strong></a></td></tr>';
	}

	public function actionDilationDrops() {
		if (!$drug = OphCiExamination_Dilation_Drugs::model()->findByPk(@$_GET['drug_id'])) {
			throw new Exception('Dilation drug not found: '.@$_GET['drug_id']);
		}
		if (!in_array(@$_GET['side'],array('left','right'))) {
			throw new Exception('Unknown side: '.@$_GET['side']);
		}
		$drug = new OphCiExamination_Dilation_Drug;
		$drug->side_id = $_GET['side'] == 'left' ? 1 : 2;
		$drug->drug_id = $_GET['drug_id'];
		$drug->drops = 1;

		$this->renderPartial('_dilation_drug_item',array('drug'=>$drug));
	}
}

