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
		$this->renderPartial('create_' . $element->create_view, array(
				'element' => $element,
				'data' => null,
				'form' => $form,
		), false, true);
	}

	/**
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
						'condition' => 'event_type_id = :id',
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
					if($element_type = ElementType::model()->find('class_name = ?',array($key))) {
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

	/**
	 * @see BaseEventTypeController::getOptionalElements()
	 */
	public function getOptionalElements($action) {
		$elements = array();
		$default_element_types = array();
		foreach($this->getDefaultElements($action) as $default_element) {
			$default_element_types[] = get_class($default_element);
		}
		$element_types = ElementType::model()->findAll(array(
				'condition' => 'event_type_id = :id',
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

	/**
	 * Get the array of elements for the current site, subspecialty and episode status
	 * @param Episode $episode
	 * @param integer $default
	 */
	protected function getElementsBySet($episode = null) {
		$elements = array();
		$site_id = Yii::app()->request->cookies['site_id']->value;
		$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
		$status_id = ($episode) ? $episode->episode_status_id : 0;
		$set = OphCiExamination_ElementSetRule::findSet($site_id, $subspecialty_id, $status_id);
		$element_types = $set->DefaultElementTypes;
		foreach($element_types as $element_type) {
			$elements[] = new $element_type->class_name;
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
			$this->renderPartial(
					$action . '_' . $element->{$action.'_view'},
					array('element' => $element, 'data' => $data, 'form' => $form),
					false, false
					);
		}
	}

	/**
	 * @see BaseEventTypeController::renderOptionalElements()
	 */
	public function renderOptionalElements($action, $form = false, $data = false) {
		foreach ($this->getOptionalElements($action) as $element) {
			$this->renderPartial(
					'_optional_element',
					array('element' => $element, 'data' => $data, 'form' => $form),
					false, false
			);
		}
	}

	public function actionGetDisorderTableRow() {
		if (!$disorder = Disorder::model()->findByPk(@$_GET['disorder_id'])) {
			throw new Exception('Unable to find disorder: '.@$_GET['disorder_id']);
		}

		if (!$the_eye = Eye::model()->find('name=?',array(ucfirst(@$_GET['side'])))) {
			throw new Exception('Unable to find eye: '.@$_GET['side']);
		}

		$id = $_GET['id'];

		echo '<tr><td>'.$disorder->term.'</td><td>';

		foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {
			echo '<span class="OphCiExamination_eye_radio"><input type="radio" name="eye_id_'.$id.'" value="'.$eye->id.'"';
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

