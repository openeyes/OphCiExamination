<?php
/**
 * (C) OpenEyes Foundation, 2014
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2014, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="sub-elements">
<div clas="row data-row">
	<div class="data-label large-3 column">Clinic internal</div>
	<div class="data-value large-9 column"><?= $plan->clinic_internal->name ?></div>
</div>
<div clas="row data-row">
	<div class="data-label large-3 column">Photo</div>
	<div class="data-value large-9 column"><?= $plan->photo->name ?></div>
</div>
<div clas="row data-row">
	<div class="data-label large-3 column">OCT</div>
	<div class="data-value large-9 column"><?= $plan->oct->name ?></div>
</div>
<div clas="row data-row">
	<div class="data-label large-3 column">HFA</div>
	<div class="data-value large-9 column"><?= $plan->hfa->name ?></div>
</div>
<div clas="row data-row">
	<div class="data-label large-3 column">Comments</div>
	<div class="data-value large-9 column"><?= Yii::app()->format->nText($plan->comments) ?></div>
</div>
</div>
<div class="sub-elements">
<div class="row data-row">
	<div class="large-6 column">
		<?php if ($plan->hasRight()) $this->render('OphCiExamination_Episode_GlaucomaManagementPlan_side', array('plan' => $plan, 'side' => 'right')); ?>
	</div>
	<div class="large-6 column">
		<?php if ($plan->hasLeft()) $this->render('OphCiExamination_Episode_GlaucomaManagementPlan_side', array('plan' => $plan, 'side' => 'left')); ?>
	</div>
</div>
</div>

