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


<h1><?php echo $title ? $title : "Examination Admin" ?></h1>

<a href="<?php echo Yii::app()->createUrl('OphCiExamination/admin/create' . $model_class); ?>">Add New</a>

<div>
	<ul class="grid reduceheight">
		<li class="header">
			<span class="column_name">Name</span>
			<span class="column_actions">Enabled</span>
		</li>
		<div class="sortable">
			<?php
			foreach ($model_list as $i => $model) {?>
				<li class="<?php if ($i%2 == 0) {?>even<?php } else {?>odd<?php }?>" data-attr-id="<?php echo $model->id?>" data-attr-name="No Treatment Reason">
					<span class="column_name"><a href="<?php echo Yii::app()->createUrl($this->module->getName() . '/admin/update' . get_class($model), array('id'=> $model->id)) ?>"><?php echo $model->name?></a></span>
					<span class="column_actions">
						<input type="checkbox" class="model_enabled" <?php if ($model->enabled) { echo "checked"; }?> />
					</span>
				</li>
			<?php }?>
		</div>
	</ul>
</div>
