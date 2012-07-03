<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<a href="#" class="removeElement">Remove</a>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<?php
	$values = $element->getUnitValues();
	$method_values = $element->getMethodValues();

	// Adjust currently element readings to match unit steps
	$element->loadClosest();

	?>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="label">Right</div>
			<div class="data">
				<table>
					<thead>
						<tr>
							<th><?php echo $element->getAttributeLabel('right_initial'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('right_wearing'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('right_corrected'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('right_method'); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo CHtml::activeDropDownList($element, 'right_initial', $values) ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'right_wearing', $values) ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'right_corrected', $values); ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'right_method', $method_values) ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="data">
				<?php echo CHtml::activeTextArea($element, 'right_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62)) ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="label">Left</div>
			<div class="data">
				<table>
					<thead>
						<tr>
							<th><?php echo $element->getAttributeLabel('left_initial'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('left_wearing'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('left_corrected'); ?>
							</th>
							<th><?php echo $element->getAttributeLabel('left_method'); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo CHtml::activeDropDownList($element, 'left_initial', $values) ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'left_wearing', $values) ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'left_corrected', $values); ?>
							</td>
							<td><?php echo CHtml::activeDropDownList($element, 'left_method', $method_values) ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="data">
				<?php echo CHtml::activeTextArea($element, 'left_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62)) ?>
			</div>
		</div>
	</div>
</div>
