<?php echo CHtml::dropDownList(get_class($element).'_'.$field.'_sign', ($element->$field > 0) ? 1 : -1, CHtml::listData(OphCiExamination_Refraction_Sign::model()->findAll(array('order'=>'display_order')), 'name', 'value'))?> 
<?php echo CHtml::dropDownList(get_class($element).'_'.$field.'_integer', abs((int) $element->$field), CHtml::listData(OphCiExamination_Refraction_Integer::model()->findAll(array('order'=>'display_order')),'value','value'))?> 
<?php echo CHtml::dropDownList(get_class($element).'_'.$field.'_fraction', abs($element->$field) - (abs((int) $element->$field)), CHtml::listData(OphCiExamination_Refraction_Fraction::model()->findAll(array('order'=>'display_order')),'name','value'))?>
<?php echo CHtml::activeHiddenField($element, $field)?>
