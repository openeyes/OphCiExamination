<?php /* DEPRECATED */ ?>
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
?>

<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<div class="elementActions">
		<?php if (@$child) { ?>
		<button title="Remove <?php echo $element->elementType->name ?>" class="removeElement classy blue nano">
			<span class="button-span icon-only"><img
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="21" height="19"> </span>
		</button>
		<?php } else {
			$event_id = ($element->id) ? $element->event_id : null;
			if ($this->canCopy($element->elementType->class_name, $event_id)) { ?>
		<a href="#" title="View Previous" class="viewPrevious"><img src="<?php echo Yii::app()->createUrl('img/_elements/btns/load.png')?>" /></a>
		<?php } ?>
		<button title="Remove <?php echo $element->elementType->name ?>" class="removeElement classy blue mini">
			<span class="button-span icon-only"><img
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="24" height="22"> </span>
		</button>
		<?php } ?>
	</div>
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name; ?>
	</h4>

	<?php
	$this->renderPartial(
		'form_' . get_class($element),
		array('element' => $element, 'data' => $data, 'form' => $form, 'previous_parent_id' => @$previous_parent_id),
		false, false
	);
	?>

	<?php if (!@$child) { ?>
	<div class="active_child_elements clearfix">
		<?php 
		$this->renderChildDefaultElements($element, $this->action->id, $form, $data, @$previous_parent_id);
		?>
	</div>
	<div class="inactive_child_elements">
		<?php
		$this->renderChildOptionalElements($element, $this->action->id, $form, $data, @$previous_parent_id);
		?>
	</div>
	<?php } ?>

</div>
