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
<div class="element-data">
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label"><?php echo $element->getAttributeLabel('blindness_id')?>:</div>
		</div>
		<div class="large-9 column end">
			<div class="data-value">
				<?php echo $element->blindness ? $element->blindness->name : 'Not recorded'?>
			</div>
		</div>
	</div>
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label"><?php echo $element->getAttributeLabel('age_id')?>:</div>
		</div>
		<div class="large-9 column end">
			<div class="data-value">
				<?php echo $element->age ? $element->age->name : 'Not recorded'?>
			</div>
		</div>
	</div>
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label"><?php echo $element->getAttributeLabel('vip')?>:</div>
		</div>
		<div class="large-9 column end">
			<div class="data-value">
				<?php echo $element->vip !== null ? ($element->vip ? 'Yes' : 'No') : 'Not recorded'?>
			</div>
		</div>
	</div>
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label"><?php echo $element->getAttributeLabel('prognosis_id')?>:</div>
		</div>
		<div class="large-9 column end">
			<div class="data-value">
				<?php echo $element->prognosis ? $element->prognosis->name : 'Not recorded'?>
			</div>
		</div>
	</div>
	<div class="row data-row">
		<div class="large-3 column">
			<div class="data-label"><?php echo $element->getAttributeLabel('suitable_teaching_case')?>:</div>
		</div>
		<div class="large-9 column end">
			<div class="data-value">
				<?php echo $element->suitable_teaching_case !== null ? ($element->suitable_teaching_case ? 'Yes' : 'No') : 'Not recorded'?>
			</div>
		</div>
	</div>
	<?php if ($element->blindness && $element->age && $element->vip !== null && $element->prognosis && $element->suitable_teaching_case !== null) {?>
		<div class="row data-row">
			<div class="large-3 column">
				<div class="data-label">Priority:</div>
			</div>
			<div class="large-9 column end">
				<div class="data-value">
					<div class="selection-priority field-highlight priority<?php echo $element->priority?>">
						<?php echo $element->priority?> priority
					</div>
				</div>
			</div>
		</div>
		<div class="row data-row">
			<div class="large-3 column">
				<div class="data-label"><?php echo $element->getAttributeLabel('request_special_consideration')?>:</div>
			</div>
			<div class="large-9 column end">
				<div class="data-value">
					<?php echo $element->request_special_consideration ? 'Yes' : 'No'?>
				</div>
			</div>
		</div>
		<div class="row data-row">
			<div class="large-3 column">
				<div class="data-label">Comments:</div>
			</div>
			<div class="large-9 column end">
				<div class="data-value">
					<?php echo $element->textWithLineBreaks('comments')?>
				</div>
			</div>
		</div>
	<?php }?>
</div>
