<?php

class DefaultController extends BaseEventTypeController {

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

	public function actionElementForm($id, $patient_id) {
		$element_type = ElementType::model()->findByPk($id);
		if(!$element_type) {
			throw new CHttpException(404, 'Unknown ElementType');
		}
		$patient = Patient::model()->findByPk($patient_id);
		if(!$patient) {
			throw new CHttpException(404, 'Unknown Patient');
		}
		$this->patient = $patient;
		$session = Yii::app()->session;
		$firm = Firm::model()->findByPk($session['selected_firm_id']);
		$this->episode = $this->getEpisode($firm, $this->patient->id);
		$element = new $element_type->class_name;
		$element->setDefaultOptions();
		$form = Yii::app()->getWidgetFactory()->createWidget($this,'BaseEventTypeCActiveForm',array(
				'id' => 'clinical-create',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'sliding'),
		));
		// Render called with processOutput
		// TODO: Check that scripts aren't being double loaded
		try {
			// look for element specific view file
			$this->renderPartial('create_' . $element->create_view, array(
					'element' => $element,
					'data' => null,
					'form' => $form,
			), false, true);
		}
		catch (Exception $e) {
			if (strpos($e->getMessage(), "cannot find the requested view") === false) {
				throw $e;
			}
			// use the default view file
			$this->renderPartial('_form', array(
					'element' => $element,
					'data' => null,
					'form' => $form,
			), false, true);
		}
	}

	/**
	 * returns the default elements to be displayed - ignoring elements which have parents (child elements)
	 * 
	 * @see BaseEventTypeController::getDefaultElements()
	 */
	public function getDefaultElements($action, $event_type_id = false, $event = false) {
		if(!$event && isset($this->event)) {
			$event = $this->event;
		}
		if($event) {
			$episode = $event->episode;
		} else {
			$episode = $this->getEpisode($this->firm, $this->patient->id);
		}
		$elements = array();
		if(empty($_POST)) {
			if(isset($event->event_type_id)) {
				$element_types = ElementType::model()->findAll(array(
						'condition' => 'event_type_id = :id AND parent_element_type_id is NULL',
						'order' => 'display_order',
						'params' => array(':id' => $event->eventType->id),
				));
				foreach($element_types as $element_type) {
					$element_class = $element_type->class_name;
					if($element = $element_class::model()->find('event_id = ?', array($event->id))) {
						$elements[] = $element;
					}
				}
			} else {
				$elements = $this->getElementsBySet($episode);
			}
		} else {
			foreach($_POST as $key => $value) {
				if(preg_match('/^Element|^OEElement/', $key)) {
					if($element_type = ElementType::model()->find('class_name = ? AND parent_element_type_id is NULL',array($key))) {
						$element_class = $element_type->class_name;
						if(!isset($event->event_type_id) || !($element = $element_class::model()->find('event_id = ?',array($event->id)))) {
							$element= new $element_class;
							$element->attributes = $_POST[$key];
						}
						$elements[] = $element;
					}
				}
			}
		}
		return $elements;
	}
	
	/*
	 * gets the child elements to be displayed in full for the provided parent element class
	 * 
	 */
	public function getChildDefaultElements($parent_class, $action, $event_type_id = false, $event = false) {
	
		if (!$event && isset($this->event)) {
			$event = $this->event;
		}
		if ($event) {
			$episode = $event->episode;
		}
		else {
			$episode = $this->getEpisode($this->firm, $this->patient->id);
		}
	
		if ($event) {
			$parent = ElementType::model()->find( array('condition' => 'class_name = :name and event_type_id = :eid', 'params' => array(':name'=>$parent_class, ':eid' => $event->event_type_id)) );
		} else {
			$parent = ElementType::model()->find( array('condition' => 'class_name = :name', 'params' => array(':name'=>$parent_class)) );
		}
	
		$elements = array();
		if (empty($_POST)) {
			if (isset($event->event_type_id)) {
				$element_types = ElementType::model()->findAll(array(
						'condition' => 'parent_element_type_id = :id',
						'order'     => 'display_order',
						'params'    => array(':id' => $parent->id),
				));
				foreach($element_types as $element_type) {
					$element_class = $element_type->class_name;
					if ($element = $element_class::model()->find('event_id = ?', array($event->id))) {
						$elements[] = $element;
					}
				}
			} else {
				$elements = $this->getChildElementsBySet($parent, $episode);
			}
		} else {
			foreach($_POST as $key => $value) {
				if(preg_match('/^Element|^OEElement/', $key)) {
					if($element_type = ElementType::model()->find('class_name = ? AND parent_element_type_id = ? ',array($key, $parent->id))) {
						$element_class = $element_type->class_name;
						if(!isset($event->event_type_id) || !($element = $element_class::model()->find('event_id = ?',array($event->id)))) {
							$element= new $element_class;
							$element->attributes = $_POST[$key];
						}
						$elements[] = $element;
					}
				}
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

	/**
	 * returns the elements that are optional that are not child elements
	 * 
	 * @see BaseEventTypeController::getOptionalElements()
	 */
	public function getOptionalElements($action) {
		$elements = array();
		$default_element_types = array();
		foreach($this->getDefaultElements($action) as $default_element) {
			$default_element_types[] = get_class($default_element);
		}
		$element_types = ElementType::model()->findAll(array(
				'condition' => 'event_type_id = :id AND parent_element_type_id is NULL',
				'order' => 'display_order',
				'params' => array(':id' => $this->event_type->id),
		));
		foreach($element_types as $element_type) {
			$element_class = $element_type->class_name;
			if(!in_array($element_class, $default_element_types)) {
				$elements[] = new $element_class;
			}
		}
		return $elements;
	}
	
	/*
	 * returns the optional child elements
	 * 
	 */
	public function getChildOptionalElements($parent_class, $action) {
		$elements = array();
		$default_element_types = array();
		foreach($this->getChildDefaultElements($parent_class, $action) as $default_element) {
			$default_element_types[] = get_class($default_element);
		}
		if ($event = $this->event) {
			$parent = ElementType::model()->find( array('condition' => 'class_name = :name and event_type_id = :eid', 'params' => array(':name'=>$parent_class, ':eid' => $event->event_type_id)) );
		} else {
			$parent = ElementType::model()->find( array('condition' => 'class_name = :name', 'params' => array(':name'=>$parent_class)) );
		}
	
		$element_types = ElementType::model()->findAll(array(
				'condition' => 'parent_element_type_id = :id',
				'order' => 'display_order',
				'params' => array(':id' => $parent->id),
		));
		foreach($element_types as $element_type) {
			$element_class = $element_type->class_name;
			if(!in_array($element_class, $default_element_types)) {
				$elements[] = new $element_class;
			}
		}
		return $elements;
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

	/**
	 * @see BaseEventTypeController::renderDefaultElements()
	 */
	public function renderDefaultElements($action, $form = false, $data = false) {
		foreach ($this->getDefaultElements($action) as $element) {
			if ($action == 'create' && empty($_POST)) {
				$element->setDefaultOptions();
			}
			try {
				// look for an action/element specific view file 
				$this->renderPartial(
						$action . '_' . $element->{$action.'_view'},
						array('element' => $element, 'data' => $data, 'form' => $form)
				);
			}
			catch (Exception $e) {
				if (strpos($e->getMessage(), "cannot find the requested view") === false) {
					throw $e;
				}
				// otherwise use the default layout
				$this->renderPartial(
						'_form',
						array('element' => $element, 'data' => $data, 'form' => $form)
				);
			}
			
		}
	}
	
	/*
	 * render the default child elements for the given parent element
	 */
	public function renderChildDefaultElements($parent, $action, $form = false, $data = false ) {
		foreach ($this->getChildDefaultElements(get_class($parent), $action) as $child ) {
			if ($action == 'create' && empty($_POST)) {
				$child->setDefaultOptions();
			}
			else if ($action == 'ElementForm') {
				// ensure we use a property that the child element can recognise
				$action = 'create';
			}
			try {
				$this->renderPartial(
						// look for elemenet specific view file
						$action . '_' . $child->{$action.'_view'},
						array('element' => $child, 'data' => $data, 'form' => $form, 'child' => true)
				);
			}
			catch (Exception $e) {
				if (strpos($e->getMessage(), "cannot find the requested view") === false) {
					throw $e;
				}
				// otherwise use the default view
				$this->renderPartial(
						'_form',
						array('element' => $child, 'data' => $data, 'form' => $form, 'child' => true)
				);
			}
		}
	}

	/**
	 * @see BaseEventTypeController::renderOptionalElements()
	 */
	public function renderOptionalElements($action, $form = false, $data = false) {
		foreach ($this->getOptionalElements($action) as $element) {
			$this->renderPartial(
					'_optional_element',
					array('element' => $element, 'data' => $data, 'form' => $form)
			);
		}
	}
	
	/**
	 * render the optional child elements for the given parent
	 * 
	 */
	public function renderChildOptionalElements($parent, $action, $form = false, $data = false) {
		foreach ($this->getChildOptionalElements(get_class($parent), $action) as $element) {
			$this->renderPartial(
				'_optional_element',
				array('element' => $element, 'data' => $data, 'form' => $form)
			);
					
		}
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
}

