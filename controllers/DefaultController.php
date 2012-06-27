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

	public function actionElementForm($id) {
		$element_type = ElementType::model()->findByPk($id);
		if(!$element_type) {
			throw new CHttpException(404, 'Unknown ElementType');
		}
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
				$elements = $this->getElementsBySet($episode, 1);
			}
		} else {
			foreach($_POST as $key => $value) {
				if(preg_match('/^Element|^OEElement/', $key)) {
					if($element_type = ElementType::model()->find('class_name = ?',array($key))) {
						$element_class = $element_type->class_name;
						if(isset($event->event_type_id) && ($element = $element_class::model()->find('event_id = ?',array($event->id)))) {
							$elements[] = $element;
						} else {
							$elements[] = new $element_class;
						}
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
		switch ($action) {
			case 'create':
				$episode = $this->getEpisode($this->firm, $this->patient->id);
				return $this->getElementsBySet($episode);
			case 'update':
				$event_type = EventType::model()->findByPk($this->event->event_type_id);
				$criteria = new CDbCriteria;
				$criteria->compare('event_type_id',$event_type->id);
				$criteria->compare('`default`',1);
				$criteria->order = 'display_order asc';
				$elements = array();
				$element_classes = array();
				foreach (ElementType::model()->findAll($criteria) as $element_type) {
					$element_class = $element_type->class_name;
					if(!$element_class::model()->find('event_id = ?',array($this->event->id))) {
						$elements[] = new $element_class;
					}
				}
				return $elements;
			default:
				return array();
		}
	}

	/**
	 * Get the array of elements for the current site, subspecialty and episode status
	 * @param Episode $episode
	 * @param integer $default
	 */
	protected function getElementsBySet($episode = null, $default = 0) {
		$elements = array();
		$site_id = Yii::app()->request->cookies['site_id']->value;
		$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
		$status_id = ($episode) ? $episode->episode_status_id : 0;
		$set = OphCiExamination_ElementSetRule::findSet($site_id, $subspecialty_id, $status_id);
		$element_types = ($default) ? $set->DefaultElementTypes : $set->OptionalElementTypes;
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

}

