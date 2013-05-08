<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class DefaultController extends NestedElementsEventTypeController {
	
	protected function beforeAction($action) {
		
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			$this->registerCssFile('spliteventtype.css', Yii::app()->createUrl('css/spliteventtype.css'));
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}
		
		return parent::beforeAction($action);
	}
	
	public function actionCreate() {
		$this->jsVars['Element_OphCiExamination_IntraocularPressure_link_instruments'] = Element_OphCiExamination_IntraocularPressure::model()->getSetting('link_instruments') ? 'true' : 'false';

		parent::actionCreate();
	}

	public function actionUpdate($id) {
		$this->jsVars['Element_OphCiExamination_IntraocularPressure_link_instruments'] = Element_OphCiExamination_IntraocularPressure::model()->getSetting('link_instruments') ? 'true' : 'false';

		parent::actionUpdate($id);
	}

	public function actionView($id) {
		parent::actionView($id);
	}

	public function actionPrint($id) {
		parent::actionPrint($id);
	}

	public function actionStep($id) {
		// This is the same as update, but with a few extras, so we call the update code and then pick up on the action later
		parent::actionUpdate($id);
	}
	
	protected function afterUpdateElements($event) {
		if($this->action->id == 'step') {
			// Advance the workflow
			if(!$assignment = OphCiExamination_Event_ElementSet_Assignment::model()->find('event_id = ?', array($event->id))) {
				// Create initial workflow assignment if event hasn't already got one
				$assignment = new OphCiExamination_Event_ElementSet_Assignment();
				$assignment->event_id = $event->id;
			}
			if(!$next_step = $this->getNextStep($event)) {
				throw new CException('No next step available');
			}
			$assignment->step_id = $next_step->id;
			if(!$assignment->save()) {
				throw new CException('Cannot save assignment');
			}
		}
	}
	
	protected function afterCreateElements($event) {
	}
	
	protected function getCleanDefaultElements($event_type_id) {
		return $this->getElementsByWorkflow(null, $this->episode);
	}

	protected function getCleanChildDefaultElements($parent, $event_type_id) {
		return $this->getElementsByWorkflow(null, $this->episode, $parent->id);
	}
	
	/**
	 * Get the first workflow step using rules
	 * @return OphCiExamination_ElementSet
	 */
	protected function getFirstStep() {
		$site_id = Yii::app()->session['selected_site_id'];
		$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
		$status_id = $this->episode->episode_status_id;
		return OphCiExamination_ElementSetRule::findWorkflow($site_id, $subspecialty_id, $status_id)->getFirstStep();
	}
	
	/**
	 * Get the next workflow step
	 * @return OphCiExamination_ElementSet
	 */
	protected function getNextStep($event = null) {
		if(!$event) {
			$event = $this->event;
		}
		if($assignment = OphCiExamination_Event_ElementSet_Assignment::model()->find('event_id = ?', array($event->id))) {
			$step = $assignment->step;
		} else {
			$step = $this->getFirstStep();
		}
		return $step->getNextStep();
	}
	
	protected function getSavedElements($action, $event, $parent = null) {
		$elements = parent::getSavedElements($action, $event, $parent);
		if($action == 'step') {
			$elements = $this->mergeNextStep($elements, $event, $parent);
		}
		return $elements;
	}
	
	/**
	 * Merge workflow next step elements into existing elements
	 * @param array $elements
	 * @param Event $event
	 * @param ElementType $parent
	 * @throws CException
	 * @return array
	 */
	protected function mergeNextStep($elements, $event, $parent = null) {
		if(!$next_step = $this->getNextStep($event)) {
			throw new CException('No next step available');
		}
		$parent_id = ($parent) ? $parent->id : null;
		$extra_elements = $this->getElementsByWorkflow($next_step, $this->episode, $parent_id);
		$merged_elements = array();
		foreach($elements as $element) {
			$element_type = $element->getElementType();
			$merged_elements[] = $element;
			if(isset($extra_elements[$element_type->id])) {
				unset($extra_elements[$element_type->id]);
			}
		}
		foreach($extra_elements as $extra_element) {
			$extra_element->setDefaultOptions();

			// Precache Element Type to avoid bug in usort
			$extra_element->getElementType();

			$merged_elements[] = $extra_element;
		}
		usort($merged_elements, function ($a, $b) {
			if($a->getElementType()->display_order == $b->getElementType()->display_order) {
				return 0;
			}
			return ($a->getElementType()->display_order > $b->getElementType()->display_order) ? 1 : -1;
		});
		return $merged_elements;
	}
	
	
	/**
	 * Get the array of elements for the current site, subspecialty, episode status and workflow position
	 * @param OphCiExamination_ElementSet $set
	 * @param Episode $episode
	 * @param integer $parent_id
	 */
	protected function getElementsByWorkflow($set = null, $episode = null, $parent_id = null) {
		$elements = array();
		if(!$set) {
			$site_id = Yii::app()->session['selected_site_id'];
			$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
			$status_id = ($episode) ? $episode->episode_status_id : 1;
			$set = OphCiExamination_ElementSetRule::findWorkflow($site_id, $subspecialty_id, $status_id)->getFirstStep();
		}
		$element_types = $set->DefaultElementTypes;
		foreach($element_types as $element_type) {
			if ((!$parent_id && !$element_type->parent_element_type_id) || ($parent_id && $element_type->parent_element_type_id == $parent_id)) {
				$elements[$element_type->id] = new $element_type->class_name;
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
	
	/**
	 * Get all the attributes for an element
	 * @param BaseEventTypeElement $element
	 * @return OphCiExamination_Attribute[]
	 */
	public function getAttributes($element, $subspecialty_id = null) {
		$attributes = OphCiExamination_Attribute::model()->findAllByElementAndSubspecialty($element->ElementType->id, $subspecialty_id);
		return $attributes;
	}
	
}

