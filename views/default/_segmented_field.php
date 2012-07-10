<?php
$field_prefix = get_class($element).'_';
$integers = array_combine(range(0,20), range(0,20));
$integer = abs((int) $element->$field);
$fractions = array(
		'0' => '.00',
		'0.25' => '.25',
		'0.50' => '.50',
		'0.75' => '.75',
);
$fraction = abs($element->$field) - $integer;
$signs = array('1' => '+', '-1' => '-');
$sign = ($element->$field >= 0) ? 1 : -1;
?>
<?php echo CHtml::dropDownList($field_prefix.$field.'_sign', $sign, $signs); ?> 
<?php echo CHtml::dropDownList($field_prefix.$field.'_integer', $integer, $integers); ?> 
<?php echo CHtml::dropDownList($field_prefix.$field.'_fraction', $fraction, $fractions); ?>
<?php echo CHtml::activeHiddenField($element, $field); ?>
