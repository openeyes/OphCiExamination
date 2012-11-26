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
<?php
if($element->getSetting('expert')) {
	$doodleToolBarArray = array('AngleNV', 'AntSynech', 'AngleRecession');
} else {
	$doodleToolBarArray = array('AngleNV');
}
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => $doodleToolBarArray,
		'onReadyCommandArray' => array(
				array('addDoodle', array('Gonioscopy')),
				array('addDoodle', array('AngleGrade', 0)),
				array('addDoodle', array('AngleGrade', 1.575)),
				array('addDoodle', array('AngleGrade', -1.575)),
				array('addDoodle', array('AngleGrade', 3.1415926535898)),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
		),
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'edit',
		'model' => $element,
		'attribute' => $side.'_eyedraw',
));
?>
<div class="eyedrawFields">
	<div <?php if(!$element->getSetting('expert')) { ?>
		style="display: none;" <?php } ?>>
		<div class="label">Scheie grade:</div>
		<div class="data gonioCross">
			<div class="gonioSup">
				<?php echo CHtml::activeDropDownList($element, $side.'_gonio_sup_id', $element->getGonioscopyOptions(), array('class' => 'gonioGrade gonioExpert', 'data-position' => 'sup'))?>
			</div>
			<div class="gonioTem">
				<?php echo CHtml::activeDropDownList($element, $side.'_gonio_tem_id', $element->getGonioscopyOptions(), array('class' => 'gonioGrade gonioExpert', 'data-position' => 'tem'))?>
			</div>
			<div class="gonioNas">
				<?php echo CHtml::activeDropDownList($element, $side.'_gonio_nas_id', $element->getGonioscopyOptions(), array('class' => 'gonioGrade gonioExpert', 'data-position' => 'nas'))?>
			</div>
			<div class="gonioInf">
				<?php echo CHtml::activeDropDownList($element, $side.'_gonio_inf_id', $element->getGonioscopyOptions(), array('class' => 'gonioGrade gonioExpert', 'data-position' => 'inf'))?>
			</div>
		</div>
	</div>
	<?php if($element->getSetting('expert')) { ?>
	<div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_van_herick_id'); ?>
			(
			<?php echo CHtml::link('images', '#', array('class' => 'foster_images_link')); ?>
			):
		</div>
		<div class="data">
			<?php echo CHtml::activeDropDownList($element, $side.'_van_herick_id', $element->getVanHerickOptions()); ?>
			<div data-side="<?php echo $side?>" class="foster_images_dialog"
				title="Foster Images">
				<img usemap="#<?php echo $side ?>_foster_images_map"
					src="<?php echo $imgPath ?>gonioscopy.png">
				<map name="<?php echo $side ?>_foster_images_map">
					<area data-vh="5" shape="rect" coords="0,0,225,225" />
					<area data-vh="15" shape="rect" coords="0,225,225,450" />
					<area data-vh="25" shape="rect" coords="0,450,225,675" />
					<area data-vh="30" shape="rect" coords="225,0,450,225" />
					<area data-vh="75" shape="rect" coords="225,225,450,450" />
					<area data-vh="100" shape="rect" coords="225,450,450,675" />
				</map>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div>
		<div class="label">Pigmented meshwork seen:</div>
		<?php $basic_options = array('0' => 'No', '1' => 'Yes'); ?>
		<div class="data gonioCross">
			<div class="gonioSup">
				<?php echo CHtml::dropDownList($side.'_gonio_sup_basic', null, $basic_options, array('class' => 'gonioGrade gonioBasic', 'data-position' => 'sup'))?>
			</div>
			<div class="gonioTem">
				<?php echo CHtml::dropDownList($side.'_gonio_tem_basic', null, $basic_options, array('class' => 'gonioGrade gonioBasic', 'data-position' => 'tem'))?>
			</div>
			<div class="gonioNas">
				<?php echo CHtml::dropDownList($side.'_gonio_nas_basic', null, $basic_options, array('class' => 'gonioGrade gonioBasic', 'data-position' => 'nas'))?>
			</div>
			<div class="gonioInf">
				<?php echo CHtml::dropDownList($side.'_gonio_inf_basic', null, $basic_options, array('class' => 'gonioGrade gonioBasic', 'data-position' => 'inf'))?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_description'); ?>
			:
		</div>
		<div class="data">
			<?php echo CHtml::activeTextArea($element, $side.'_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
		</div>
	</div>
	<button class="ed_report">Report</button>
	<button class="ed_clear">Clear</button>
</div>
