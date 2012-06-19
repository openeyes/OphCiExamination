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

	/**
	 * Get all the elements for an event, the current module or an event_type
	 *
	 * @return array
	 */
	public function getDefaultElements($action, $event_type_id = false, $event = false) {
		if (!$event && isset($this->event)) {
			$event = $this->event;
		}
		if($event) {
			$episode = $event->episode;
		} else {
			$episode = $this->getEpisode($this->firm, $this->patient->id);
		}
		$elements = array();
		if (empty($_POST)) {
			if (isset($event->event_type_id)) {
				foreach (ElementType::model()->findAll($criteria) as $element_type) {
					$element_class = $element_type->class_name;
					if ($element = $element_class::model()->find('event_id = ?',array($event->id))) {
						$elements[] = $element;
					}
				}
			} else {
				$site_id = Yii::app()->request->cookies['site_id']->value;
				$subspecialty_id = $this->firm->serviceSubspecialtyAssignment->subspecialty_id;
				$status_id = ($episode) ? $episode->episode_status_id : 0;
				$set = OphCiExamination_ElementSetRule::findSet($site_id, $subspecialty_id, $status_id);
				foreach($set->items as $set_item) {
					$element_class = $set_item->element_type->class_name;
					$elements[] = new $element_class;
				}
			}
		} else {
			foreach($_POST as $key => $value) {
				if (preg_match('/^Element|^OEElement/', $key)) {
					if ($element_type = ElementType::model()->find('class_name = ?',array($key))) {
						$element_class = $element_type->class_name;
						if (isset($event->event_type_id) && ($element = $element_class::model()->find('event_id = ?',array($event->id)))) {
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

	public function getOptionalElements($action) {
		return parent::getOptionalElements($action);
	}

}

