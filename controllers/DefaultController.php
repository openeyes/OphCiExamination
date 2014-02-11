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

/*
 * This is the controller class for the OphCiExamination event. It provides the required methods for the ajax loading of elements, and rendering the required and optional elements (including the children relationship)
 */

class DefaultController extends BaseEventTypeController
{
	static protected $action_types = array(
		'step' => self::ACTION_TYPE_EDIT,
		'getDisorderTableRow' => self::ACTION_TYPE_FORM,
		'loadInjectionQuestions' => self::ACTION_TYPE_FORM
	);

	// if set to true, we are advancing the current event step
	private $step = false;

	/**
	 * Need split event files
	 * @TODO: determine if this should be defined by controller property
	 *
	 * @param CAction $action
	 * @return bool
	 */
	protected function beforeAction($action)
	{
		Yii::app()->assetManager->registerScriptFile('js/spliteventtype.js', null, null, AssetManager::OUTPUT_SCREEN);
		return parent::beforeAction($action);
	}

	/**
	 * Applies workflow and filtering to the element retrieval
	 *
	 * @return BaseEventTypeElement[]
	 */
	protected function getEventElements()
	{
		if ($this->event) {
			$elements = $this->event->getElements();
			if ($this->step) {
				$elements = $this->mergeNextStep($elements);
			}
		}
		else {
			$elements = $this->getElementsByWorkflow(null, $this->episode);
		}

		return $this->filterElements($elements);
	}

	/**
	 * Filters elements based on coded dependencies
	 *
	 * @TODO: need to ensure that we don't filter out elements that do exist when configuration changes
	 * @param BaseEventTypeElement[] $elements
	 * @return BaseEventTypeElement[]
	 */
	protected function filterElements($elements)
	{
		if (Yii::app()->hasModule('OphCoTherapyapplication')) {
			$remove = array('Element_OphCiExamination_InjectionManagement');
		} else {
			$remove = array('Element_OphCiExamination_InjectionManagementComplex');
		}

		$final = array();
		foreach ($elements as $el) {
			if (!in_array(get_class($el), $remove)) {
				$final[] = $el;
			}
		}

		return $final;
	}

	/**
	 * Sets up jsvars for editing
	 */
	protected function initEdit()
	{
		$this->jsVars['Element_OphCiExamination_IntraocularPressure_link_instruments'] = Element_OphCiExamination_IntraocularPressure::model()->getSetting('link_instruments') ? 'true' : 'false';

		if (Yii::app()->hasModule('OphCoTherapyapplication')) {
			$this->jsVars['OphCiExamination_loadQuestions_url'] = $this->createURL('loadInjectionQuestions');
		}
	}

	/**
	 * Call editInit to set up jsVars
	 */
	public function initActionCreate()
	{
		parent::initActionCreate();
		$this->initEdit();
	}

	/**
	 * Call editInit to setup jsVars
	 */
	public function initActionUpdate()
	{
		parent::initActionUpdate();
		$this->initEdit();
	}

	public function initActionStep()
	{
		$this->initActionUpdate();
	}

	/**
	 * Pulls in the diagnosis from the episode and ophthalmic diagnoses from the patient, and sets an appropriate list
	 * of unique diagnoses
	 *
	 * @param $element
	 * @param $action
	 */
	protected function setElementDefaultOptions_Element_OphCiExamination_Diagnoses($element, $action)
	{
		if ($action == 'create') {
			// set the diagnoses to match the current patient diagnoses for the episode
			// and any other ophthalmic secondary diagnoses the patient has
			$diagnoses = array();
			if ($principal = $this->episode->diagnosis) {
				$d = new OphCiExamination_Diagnosis();
				$d->disorder_id = $principal->id;
				$d->principal = true;
				$d->eye_id = $this->episode->eye_id;
				$diagnoses[] = $d;
			}
			foreach ($this->patient->getOphthalmicDiagnoses() as $sd) {
				$d = new OphCiExamination_Diagnosis();
				$d->disorder_id = $sd->disorder_id;
				$d->eye_id = $sd->eye_id;
				$diagnoses[] = $d;
			}

			// ensure unique
			$_diagnoses = array();
			foreach ($diagnoses as $d) {
				$already_in = false;
				foreach ($_diagnoses as $ad) {
					if ($d->disorder_id == $ad->disorder_id) {
						$already_in = true;
						// set the eye correctly (The principal diagnosis for the episode is the first diagnosis, so
						// no need to check that.
						if ($d->eye_id != $ad->eye_id) {
							$ad->eye_id = Eye::BOTH;
						}
						break;
					}
				}
				if (!$already_in) {
					$_diagnoses[] = $d;
				}
			}
			$element->diagnoses = $_diagnoses;
		}
	}

	/**
	 * Action to move the workflow forward a step on the given event
	 *
	 * @param $id
	 */
	public function actionStep($id)
	{
		$this->step = true;
		// This is the same as update, but with a few extras, so we call the update code and then pick up on the action later
		$this->actionUpdate($id);
	}

	/**
	 * Advance the workflow step for the event if requested
	 *
	 * @param Event $event
	 * @throws CException
	 */
	protected function afterUpdateElements($event)
	{
		if ($this->step) {
			// Advance the workflow
			if (!$assignment = OphCiExamination_Event_ElementSet_Assignment::model()->find('event_id = ?', array($event->id))) {
				// Create initial workflow assignment if event hasn't already got one
				$assignment = new OphCiExamination_Event_ElementSet_Assignment();
				$assignment->event_id = $event->id;
			}
			if (!$next_step = $this->getNextStep($event)) {
				throw new CException('No next step available');
			}
			$assignment->step_id = $next_step->id;
			if (!$assignment->save()) {
				throw new CException('Cannot save assignment');
			}
		}
	}

	/**
	 * Get the open child elements for the given ElementType
	 *
	 * @param ElementType $parent_type
	 * @return BaseEventTypeElement[] $open_elements
	 */
	public function getChildElements($parent_type)
	{
		$open_child_elements = parent::getChildElements($parent_type);

		if ($this->step) {
			$current_child_types = array();
			foreach ($open_child_elements as $open) {
				$current_child_types[] = $open->getElementType();
			}
			foreach ($this->getElementsByWorkflow(null, $this->episode, $parent_type->id) as $new_child_element) {
				if (!in_array($new_child_element->getElementType(), $current_child_types)) {
					$open_child_elements[] = $new_child_element;
				}
			}
		}

		return $open_child_elements;
	}

	/**
	 * extends standard method to filter elements
	 *
	 * (non-PHPdoc)
	 * @see NestedElementsEventTypeController::getChildOptionalElements()
	 */
	public function getChildOptionalElements($parent_type)
	{
		$elements = parent::getChildOptionalElements($parent_type);
		$open_elements = $this->getChildElements($parent_type);

		return $this->filterElements($elements, $open_elements);
	}

	/**
	 * Get the first workflow step using rules
	 *
	 * @TODO: examine what this is being used for as opposed to getting elements by workflow ...
	 * @return OphCiExamination_ElementSet
	 */
	protected function getFirstStep()
	{
		$firm_id = $this->firm->id;
		$status_id = $this->episode->episode_status_id;

		return OphCiExamination_Workflow_Rule::findWorkflow($firm_id, $status_id)->getFirstStep();
	}

	/**
	 * Get the next workflow step
	 * @param Event $event
	 * @return OphCiExamination_ElementSet
	 */
	protected function getNextStep($event = null)
	{
		if (!$event) {
			$event = $this->event;
		}
		if ($assignment = OphCiExamination_Event_ElementSet_Assignment::model()->find('event_id = ?', array($event->id))) {
			$step = $assignment->step;
		} else {
			$step = $this->getFirstStep();
		}
		return $step->getNextStep();
	}

	/**
	 * Merge workflow next step elements into existing elements
	 * @param array $elements
	 * @param ElementType $parent
	 * @throws CException
	 * @return array
	 */
	protected function mergeNextStep($elements, $parent = null)
	{
		if (!$event = $this->event) {
			throw new CException('No event set for step merging');
		}
		if (!$next_step = $this->getNextStep($event)) {
			throw new CException('No next step available');
		}

		$parent_id = ($parent) ? $parent->id : null;
		//TODO: should we be passing episode here?
		$extra_elements = $this->getElementsByWorkflow($next_step, $this->episode, $parent_id);
		$extra_by_etid = array();

		foreach ($extra_elements as $extra) {
			$extra_by_etid[$extra->getElementType()->id] = $extra;
		}

		$merged_elements = array();
		foreach ($elements as $element) {
			$element_type = $element->getElementType();
			$merged_elements[] = $element;
			if (isset($extra_by_etid[$element_type->id])) {
				unset($extra_by_etid[$element_type->id]);
			}
		}

		foreach ($extra_by_etid as $extra_element) {
			$extra_element->setDefaultOptions();

			// Precache Element Type to avoid bug in usort
			$extra_element->getElementType();

			$merged_elements[] = $extra_element;
		}
		usort($merged_elements, function ($a, $b) {
			if ($a->getElementType()->display_order == $b->getElementType()->display_order) {
				return 0;
			}
			return ($a->getElementType()->display_order > $b->getElementType()->display_order) ? 1 : -1;
		});
		return $merged_elements;
	}


	/**
	 * Get the array of elements for the current site, subspecialty, episode status and workflow position
	 *
	 * @param OphCiExamination_ElementSet $set
	 * @param Episode $episode
	 * @param integer $parent_id
	 * @return BaseEventTypeElement[]
	 */
	protected function getElementsByWorkflow($set = null, $episode = null, $parent_id = null)
	{
		$elements = array();
		if (!$set) {
			$site_id = Yii::app()->session['selected_site_id'];
			$firm_id = $this->firm->id;
			$subspecialty_id = $this->firm->getSubspecialtyID();
			$status_id = ($episode) ? $episode->episode_status_id : 1;
			$set = OphCiExamination_Workflow_Rule::findWorkflow($firm_id, $status_id)->getFirstStep();
		}

		$element_types = $set->DefaultElementTypes;
		foreach ($element_types as $element_type) {
			if ((!$parent_id && !$element_type->parent_element_type_id) || ($parent_id && $element_type->parent_element_type_id == $parent_id)) {
				$elements[$element_type->id] = $element_type->getInstance();
			}
		}

		return $this->filterElements($elements);
	}

	/**
	 * Ajax function for quick disorder lookup
	 *
	 * Used when eyedraw elements have doodles that are associated with disorders
	 *
	 * @throws Exception
	 */
	public function actionGetDisorder()
	{
		if (!@$_GET['disorder_id']) return;
		if (!$disorder = Disorder::model()->findByPk(@$_GET['disorder_id'])) {
			throw new Exception('Unable to find disorder: '.@$_GET['disorder_id']);
		}

		header('Content-type: application/json');
		echo json_encode(array('id' => $disorder->id, 'name' => $disorder->term));
		Yii::app()->end();
	}

	/**
	 * Ajax action to load the questions for a side and disorder_id
	 */
	public function actionLoadInjectionQuestions()
	{
		// need a side specification for the form element names
		$side = @$_GET['side'];
		if (!in_array($side, array('left', 'right'))) {
			throw Exception('Invalid side argument');
		}

		// disorder id verification
		$questions = array();
		foreach (@$_GET['disorders'] as $did) {
			if ((int) $did) {
				foreach (Element_OphCiExamination_InjectionManagementComplex::model()->getInjectionQuestionsForDisorderId($did) as $q) {
					$questions[] = $q;
				}
			}
		}

		// need a form object
		$form = Yii::app()->getWidgetFactory()->createWidget($this,'BaseEventTypeCActiveForm',array(
				'id' => 'clinical-create',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'sliding'),
		));

		$element = new Element_OphCiExamination_InjectionManagementComplex();

		// and now render
		$this->renderPartial(
				'form_Element_OphCiExamination_InjectionManagementComplex_questions',
				array('element' => $element, 'form' => $form, 'side' => $side, 'questions' => $questions),
				false, false
		);


	}

	/**
	 * Get all the attributes for an element
	 *
	 * @param BaseEventTypeElement $element
	 * @param integer $subspecialty_id
	 * @return OphCiExamination_Attribute[]
	 */
	public function getAttributes($element, $subspecialty_id = null)
	{
		$attributes = OphCiExamination_Attribute::model()->findAllByElementAndSubspecialty($element->ElementType->id, $subspecialty_id);
		return $attributes;
	}

	/**
	 * associate the answers and risks from the data with the Element_OphCiExamination_InjectionManagementComplex element for
	 * validation
	 *
	 * @param Element_OphCiExamination_InjectionManagementComplex $element
	 * @param array $data
	 * @param $index
	 */
	protected function setComplexAttributes_Element_OphCiExamination_InjectionManagementComplex($element, $data, $index)
	{
		foreach (array('left' => Eye::LEFT, 'right' => Eye::RIGHT) as $side => $eye_id) {
			$answers = array();
			$risks = array();
			$checker = 'has' . ucfirst($side);
			if ($element->$checker()) {
				if (isset($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_Answer']) ) {
					foreach ($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_Answer'] as $id => $p_ans) {
						$answer = new OphCiExamination_InjectionManagementComplex_Answer();
						$answer->question_id = $id;
						$answer->answer = $p_ans;
						$answer->eye_id = $eye_id;
						$answers[] = $answer;
					}
				}
				if (isset($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_risks']) ) {
					foreach ($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_risks'] as $risk_id) {
						if ($risk = OphCiExamination_InjectionManagementComplex_Risk::model()->findByPk($risk_id)) {
							$risks[] = $risk;
						}
					}
				}
			}
			$element->{$side . '_answers'} = $answers;
			$element->{$side . '_risks'} = $risks;
		}
	}

	/**
	 * If the Patient does not currently have a diabetic diagnosis, specify that it's required
	 * so the validation rules can check for it being set in the given element (currently only DR Grading)
	 *
	 * @param BaseEventTypeElement $element
	 * @param array $data
	 */
	private function _set_DiabeticDiagnosis($element, $data)
	{
		if (isset(Yii::app()->params['ophciexamination_drgrading_type_required'])
			&& Yii::app()->params['ophciexamination_drgrading_type_required']
			&& !$this->patient->getDiabetesType()) {
			if (!$element->secondarydiagnosis_disorder_id) {
				$element->secondarydiagnosis_disorder_required = true;
			}
		}
	}

	/**
	 * Wrapper to set validation rules on DR Grading element
	 *
	 */
	protected function setComplexAttributes_Element_OphCiExamination_DRGrading($element, $data, $index)
	{
		$this->_set_DiabeticDiagnosis($element, $data);
	}

	/**
	 * Set the OCT Fluid types for validation for the given side
	 *
	 * @param Element_OphCiExamination_OCT $element
	 * @param array $data
	 * @param integer $index
	 */
	protected function setComplexAttributes_Element_OphCiExamination_OCT($element, $data, $index)
	{
		foreach (array('left', 'right') as $side) {
			$fts = array();
			$checker = 'has' . ucfirst($side);
			if ($element->$checker()) {
				if (isset($data['Element_OphCiExamination_OCT'][$side . '_fluidtypes'])) {
					foreach ($data['Element_OphCiExamination_OCT'][$side . '_fluidtypes'] as $ft_id) {
						if ($ft = OphCiExamination_OCT_FluidType::model()->findByPk($ft_id)) {
							$fts[] = $ft;
						}
					}
				}
			}
			$element->{$side . '_fluidtypes'} = $fts;
		}
	}

	/**
	 * Set the diagnoses against the Element_OphCiExamination_Diagnoses element
	 *
	 * @param Element_OphCiExamination_Diagnoses $element
	 * @param $data
	 * @param $index
	 */
	protected function setComplexAttributes_Element_OphCiExamination_Diagnoses($element, $data, $index)
	{
		$diagnoses = array();
		$diagnosis_eyes = array();

		if (isset($data['Element_OphCiExamination_Diagnoses'])) {
			foreach ($data['Element_OphCiExamination_Diagnoses'] as $key => $value) {
				if (preg_match('/^eye_id_[0-9]+$/',$key)) {
					$diagnosis_eyes[] = $value;
				}
			}
		}

		if (is_array(@$data['selected_diagnoses'])) {
			foreach ($data['selected_diagnoses'] as $i => $disorder_id) {
				$diagnosis = new OphCiExamination_Diagnosis();
				$diagnosis->eye_id = $diagnosis_eyes[$i];
				$diagnosis->disorder_id = $disorder_id;
				$diagnosis->principal = (@$data['principal_diagnosis'] == $disorder_id);
				$diagnoses[] = $diagnosis;
			}
		}
		$element->diagnoses = $diagnoses;
	}

	/**
	 * Save question answers and risks
	 *
	 * @param $element
	 * @param $data
	 * @param $index
	 */
	protected function saveComplexAttributes_Element_OphCiExamination_InjectionManagementComplex($element, $data, $index)
	{
		$element->updateQuestionAnswers(Eye::LEFT,
			$element->hasLeft() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['left_Answer']) ?
			$data['Element_OphCiExamination_InjectionManagementComplex']['left_Answer'] :
			array());
		$element->updateQuestionAnswers(Eye::RIGHT,
			$element->hasRight() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['right_Answer']) ?
			$data['Element_OphCiExamination_InjectionManagementComplex']['right_Answer'] :
			array());
		$element->updateRisks(Eye::LEFT,
			$element->hasLeft() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['left_risks']) ?
			$data['Element_OphCiExamination_InjectionManagementComplex']['left_risks'] :
			array());
		$element->updateRisks(Eye::RIGHT,
			$element->hasRight() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['right_risks']) ?
			$data['Element_OphCiExamination_InjectionManagementComplex']['right_risks'] :
			array());
	}

	/**
	 * Save fluid types
	 *
	 * @param $element
	 * @param $data
	 * @param $index
	 */
	protected function saveComplexAttributes_Element_OphCiExamination_OCT($element, $data, $index)
	{
		$element->updateFluidTypes(Eye::LEFT, $element->hasLeft() && isset($data['Element_OphCiExamination_OCT']['left_fluidtypes']) ?
				$data['Element_OphCiExamination_OCT']['left_fluidtypes'] :
				array());
		$element->updateFluidTypes(Eye::RIGHT, $element->hasRight() && isset($data['Element_OphCiExamination_OCT']['right_fluidtypes']) ?
				$data['Element_OphCiExamination_OCT']['right_fluidtypes'] :
				array());
	}

	/**
	 * Save diagnoses
	 *
	 * @param $element
	 * @param $data
	 * @param $index
	 */
	protected function saveComplexAttributes_Element_OphCiExamination_Diagnoses($element, $data, $index)
	{
		// FIXME: the form elements for this are a bit weird, and not consistent in terms of using a standard template
		$diagnoses = array();
		$eyes = isset($data['Element_OphCiExamination_Diagnoses']) ? array_values($data['Element_OphCiExamination_Diagnoses']) : array();

		foreach (@$data['selected_diagnoses'] as $i => $disorder_id) {
			$diagnoses[] = array(
				'eye_id' => $eyes[$i],
				'disorder_id' => $disorder_id,
				'principal' => (@$data['principal_diagnosis'] == $disorder_id)
			);
		}
		$element->updateDiagnoses($diagnoses);
	}

}
