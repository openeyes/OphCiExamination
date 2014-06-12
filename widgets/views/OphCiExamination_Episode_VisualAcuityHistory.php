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
<?php if ($chart->hasData()): ?>
	<div class="row">
		<div class="column large-9">
			<div id="va-history-chart" style="width: 740px; height: 500px"></div>
		</div>
		<div class="column large-3">
			<div class="field-row">
				<form action="#OphCiExamination_Episode_VisualAcuityHistory">
					<label for="va_history_unit_id">Visual Acuity unit</label>
					<?= CHtml::dropDownList('va_history_unit_id', $va_unit->id, CHtml::listData(OEModule\OphCiExamination\models\OphCiExamination_VisualAcuityUnit::model()->active()->findAll(),'id','name'))?>
				</form>
			</div>
			<div id="va-history-chart-legend"></div>
		</div>
	</div>
	<?= $chart->run(); ?>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#va_history_unit_id').change(function () { this.form.submit(); });
		});
	</script>
<?php else: ?>
	<div class="row">
		<div class="large-12 column">
			<div class="data-row">
				<div class="data-value">(no data)</div>
			</div>
		</div>
	</div>
<?php endif; ?>
