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

<section class="element">
	<header class="element-header">
		<h3 class="element-title"><?php echo $element->elementType->name?></h3>
	</header>

		<div class="element-data">
				<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('iop'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->iop?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('glaucoma_status_id'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->glaucoma_status ? $element->glaucoma_status->name : 'None'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('drop-related_prob_id'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->drop-related_prob ? $element->drop-related_prob->name : 'None'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('drops_id'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->drops ? $element->drops->name : 'None'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('surgery_id'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->surgery ? $element->surgery->name : 'None'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('other-service'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->other-service ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('refraction'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->refraction ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('lva'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->lva ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('orthoptics'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->orthoptics ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('cl_clinic'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->cl_clinic ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('vf'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->vf ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('us'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->us ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('biometry'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->biometry ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('oct'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->oct ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('hrt'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->hrt ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('disc_photos'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->disc_photos ? 'Yes' : 'No'?></div></div>
		</div>
		<div class="row data-row">
			<div class="large-2 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('edt'))?></div></div>
			<div class="large-10 column end"><div class="data-value"><?php echo $element->edt ? 'Yes' : 'No'?></div></div>
		</div>
			</div>
</section>
