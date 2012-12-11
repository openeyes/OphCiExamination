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
	
	$element_class = get_class($element);

?>
<div class="eventDetail aligned">
	<div class="label">
		<?php echo $element->getAttributeLabel($side.'_nscretinopathy_id'); ?>:
	</div>
	<div class="data">
		<?php 
			$nscretinopathy_html_options = array('options' => array()); 
			foreach (OphCiExamination_DRGrading_NSCRetinopathy::model()->findAll(array('order'=>'display_order')) as $retin) {
				$nscretinopathy_html_options['options'][(string)$retin->id] = array('data-val' => $retin->name);
			}
			echo CHtml::activeDropDownList($element, $side . '_nscretinopathy_id', CHtml::listData(OphCiExamination_DRGrading_NSCRetinopathy::model()->findAll(array('order'=>'display_order')),'id','name'), $nscretinopathy_html_options);
		?>
		<span class="grade-info-icon"><img src="<?php echo $this->assetPath ?>/img/icon_info.png" height="20" /></span>
		<div class="quicklook grade-info" style="display: none;">
			<?php foreach (OphCiExamination_DRGrading_NSCRetinopathy::model()->findAll(array('order'=>'display_order')) as $retin) {
				echo '<div style="display: none;" class="' . $element_class . '_'. $side.'_nscretinopathy_desc" id="' . $element_class . '_' . $side . '_nscretinopathy_desc_' . $retin->name . '">' . $retin->description . '</div>';
			}	
			?>
		</div>
	</div>

	
</div>
<div class="eventDetail aligned">	
	<div class="label">
		<?php echo $element->getAttributeLabel($side.'_nscmaculopathy_id'); ?>:
	</div>
	<div class="data">
		<?php 
			$nscmacuopathy_html_options = array('options' => array()); 
			foreach (OphCiExamination_DRGrading_NSCMaculopathy::model()->findAll(array('order'=>'display_order')) as $macu) {
				$nscmaculopathy_html_options['options'][(string)$macu->id] = array('data-val' => $macu->name);
			}
			echo CHtml::activeDropDownList($element, $side . '_nscmaculopathy_id', CHtml::listData(OphCiExamination_DRGrading_NSCMaculopathy::model()->findAll(array('order'=>'display_order')),'id','name'), $nscmaculopathy_html_options);
		?>
		<span class="grade-info-icon"><img src="<?php echo $this->assetPath ?>/img/icon_info.png" height="20" /></span>
		<div class="quicklook grade-info" style="display: none;">
			<?php foreach (OphCiExamination_DRGrading_NSCMaculopathy::model()->findAll(array('order'=>'display_order')) as $macu) {
				echo '<div style="display: none;" class="' . $element_class . '_' . $side . '_nscmaculopathy_desc desc" id="' . $element_class . '_' . $side . '_nscmaculopathy_desc_' . $macu->name . '">' . $macu->description . '</div>';
			}	
			?>
		</div>
		
	</div>
	
	
</div>
