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
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}

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
	 * filters elements based on coded dependencies
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
			if (!in_array(get_class($el), $remove) ) {
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
	 * @param $id
	 */
	public function initActionUpdate()
	{
		parent::initActionUpdate();
		$this->initEdit();
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
	 * extends standard method to filter elements
	 *
	 * (non-PHPdoc)
	 * @see NestedElementsEventTypeController::getChildOptionalElements()
	 */
	public function getChildOptionalElements($parent_type)
	{
		$elements = parent::getChildOptionalElements($parent_type);
		return $this->filterElements($elements);
	}

	/**
	 * Get the first workflow step using rules
	 *
	 * @TODO: examine what this is being used for as opposed to getting elements by workflow ...
	 * @return OphCiExamination_ElementSet
	 */
	protected function getFirstStep()
	{
		$site_id = Yii::app()->session['selected_site_id'];
		$subspecialty_id = $this->firm->getSubspecialtyID();
		$status_id = $this->episode->episode_status_id;
		return OphCiExamination_ElementSetRule::findWorkflow($site_id, $firm_id, $status_id)->getFirstStep();
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
	 * @return ElementType[]
	 */
	protected function getElementsByWorkflow($set = null, $episode = null, $parent_id = null)
	{
		$elements = array();
		if (!$set) {
			$site_id = Yii::app()->session['selected_site_id'];
			$firm_id = $this->firm->id;
			$subspecialty_id = $this->firm->getSubspecialtyID();
			$status_id = ($episode) ? $episode->episode_status_id : 1;
			$set = OphCiExamination_ElementSetRule::findWorkflow($site_id, $firm_id, $status_id)->getFirstStep();
		}
		$element_types = $set->DefaultElementTypes;
		foreach ($element_types as $element_type) {
			if ((!$parent_id && !$element_type->parent_element_type_id) || ($parent_id && $element_type->parent_element_type_id == $parent_id)) {
				$elements[$element_type->id] = new $element_type->class_name;
			}
		}
		return $this->filterElements($elements);
	}

	/**
	 * Ajax function for quick disorder lookup
	 *
	 * Used when eyedraw elements have doodles that are associated with disorders
	 *
	 * @TODO: change this to integrate fully with the diagnosis element and use the same display functions
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
	 * associate the answers from the POST submission with the Element_OphCiExamination_InjectionManagementComplex element for
	 * validation
	 *
	 * @param Element_OphCiExamination_InjectionManagementComplex $element
	 * @param array $data
	 * @param string $side
	 */
	private function _set_InjectionAnswers($element, $data, $side)
	{
		$answers = array();
		$checker = 'has' . ucfirst($side);
		if ($element->$checker()) {
			if (isset($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_Answer']) ) {
				foreach ($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_Answer'] as $id => $p_ans) {
					$answer = new OphCiExamination_InjectionManagementComplex_Answer();
					$answer->question_id = $id;
					$answer->answer = $p_ans;
					if ($side == 'left') {
						$answer->eye_id = Eye::LEFT;
					} else {
						$answer->eye_id = Eye::RIGHT;
					}
					$answers[] = $answer;
				}
			}
		}
		$element->{$side . '_answers'} = $answers;
	}

	/**
	 * associate the risks in the structured data with the Element_OphCiExamination_InjectionManagementComplex element for
	 * validation
	 *
	 * @param Element_OphCiExamination_InjectionManagementComplex $element
	 * @param array $data
	 * @param string $side
	 */
	private function _set_InjectionRisks($element, $data, $side)
	{
		$risks = array();
		$checker = 'has' . ucfirst($side);
		if ($element->$checker()) {
			if (isset($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_risks']) ) {
				foreach ($data['Element_OphCiExamination_InjectionManagementComplex'][$side . '_risks'] as $risk_id) {
					if ($risk = OphCiExamination_InjectionManagementComplex_Risk::model()->findByPk($risk_id)) {
						$risks[] = $risk;
					}
				}
			}
		}
		$element->{$side . '_risks'} = $risks;
	}

	/**
	 * If the Patient does not currently have a diabetic diagnosis, specify that it's required
	 * so the validation rules can check for it being set in the given element (typically DR Grading)
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
	 * Set the OCT Fluid types for validation for the given side
	 *
	 * @param Element_OphCiExamination_OCT $element
	 * @param array $data
	 * @param string $side
	 */
	private function _set_OCTFluidTypes($element, $data, $side)
	{
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

	/**
	 * (non-PHPdoc)
	 * @see BaseEventTypeController::setElementComplexAttributesFromData($element, $data, $index)
	 */
	protected function setElementComplexAttributesFromData($element, $data, $index = null)
	{
		$cls = get_class($element);
		if ($cls == "Element_OphCiExamination_InjectionManagementComplex") {
			$this->_set_InjectionAnswers($element, $data, 'left');
			$this->_set_InjectionAnswers($element, $data, 'right');
			$this->_set_InjectionRisks($element, $data, 'left');
			$this->_set_InjectionRisks($element, $data, 'right');
		}

		if ($cls == "Element_OphCiExamination_DRGrading") {
			$this->_set_DiabeticDiagnosis($element, $data);
		}

		if ($cls == "Element_OphCiExamination_OCT") {
			$this->_set_OCTFluidTypes($element, $data, 'left');
			$this->_set_OCTFluidTypes($element, $data, 'right');
		}

	}

	/**
	 * Carrying out the required many to many relationship setting calls for examination elements
	 *
	 * (non-PHPdoc)
	 * @see BaseEventTypeController::saveEventComplexAttributesFromData($data)

	 */
	protected function saveEventComplexAttributesFromData($data)
	{
		foreach ($this->open_elements as $el) {
			if (get_class($el) == 'Element_OphCiExamination_InjectionManagementComplex') {
				$el->updateQuestionAnswers(Eye::LEFT,
						$el->hasLeft() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['left_Answer']) ?
								$data['Element_OphCiExamination_InjectionManagementComplex']['left_Answer'] :
								array());
				$el->updateQuestionAnswers(Eye::RIGHT,
						$el->hasRight() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['right_Answer']) ?
						$data['Element_OphCiExamination_InjectionManagementComplex']['right_Answer'] :
						array());
				$el->updateRisks(Eye::LEFT,
						$el->hasLeft() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['left_risks']) ?
						$data['Element_OphCiExamination_InjectionManagementComplex']['left_risks'] :
						array());
				$el->updateRisks(Eye::RIGHT,
						$el->hasRight() && isset($data['Element_OphCiExamination_InjectionManagementComplex']['right_risks']) ?
						$data['Element_OphCiExamination_InjectionManagementComplex']['right_risks'] :
						array());
			}
			if (get_class($el) == 'Element_OphCiExamination_OCT') {
				$el->updateFluidTypes(Eye::LEFT, $el->hasLeft() && isset($data['Element_OphCiExamination_OCT']['left_fluidtypes']) ?
						$data['Element_OphCiExamination_OCT']['left_fluidtypes'] :
						array());
				$el->updateFluidTypes(Eye::RIGHT, $el->hasRight() && isset($data['Element_OphCiExamination_OCT']['right_fluidtypes']) ?
						$data['Element_OphCiExamination_OCT']['right_fluidtypes'] :
						array());
			}
		}
	}
}
