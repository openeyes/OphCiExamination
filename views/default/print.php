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
<div class="page" id="OphCiExamination_print">
	<div class="header">
		<div class="title middle">
			<img src="<?php echo Yii::app()->createUrl('img/_print/letterhead_seal.jpg')?>" alt="letterhead_seal" class="seal" width="100" height="83"/>
			<h1>Examination</h1>
		</div>
		<div class="headerInfo">
			<div class="patientDetails">
				<strong><?php echo $this->patient->addressname?></strong>
				<br />
				<?php echo $this->patient->address ? $this->patient->address->getLetterHtml() : ''?>
				<br>
				<br>
				Hospital No: <strong><?php echo $this->patient->hos_num ?></strong>
				<br>
				NHS No: <strong><?php echo $this->patient->nhsnum ?></strong>
				<br>
				DOB: <strong><?php echo Helper::convertDate2NHS($this->patient->dob) ?> (<?php echo $this->patient->getAge()?>)</strong>
			</div>
			<div class="headerDetails">
				<strong><?php echo $this->event->episode->firm->getConsultant()->contact->getFullName() ?></strong>
				<br>
				Service: <strong><?php echo $this->event->episode->firm->getSubspecialtyText() ?></strong>
			</div>
			<div class="noteDates">
				Examination Created: <strong><?php echo Helper::convertDate2NHS($this->event->created_date) ?></strong>
				<br>
				Examination Printed: <strong><?php echo Helper::convertDate2NHS(date('Y-m-d')) ?></strong>
			</div>
		</div>
	</div>
	
	<div class="body">
		<div class="operationMeta">
			<?php if ($diagnoses = Element_OphCiExamination_Diagnoses::model()->find('event_id=?',array($this->event->id))) {?>
				<div class="detailRow leftAlign">
					<div class="label">
						Diagnoses:
					</div>
					<div class="value pronounced">
						<?php
						if ($principal_diagnosis = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and principal=1',array($diagnoses->id))) {?>
							<strong><?php echo $principal_diagnosis->disorder->term?> (<?php echo $principal_diagnosis->eye->adjective?>)</strong><?php }

						foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=? and principal=0',array($diagnoses->id)) as $i => $diagnosis) {
							if ($i || $principal_diagnosis) echo ', '?>
							<?php echo $diagnosis->disorder->term?> (<?php echo $diagnosis->eye->adjective?>)
						<?php }
						?>
					</div>
				</div>
			<?php }?>
		</div>

		<h2>History</h2>
		<div class="details">
			<?php
			if ($history = Element_OphCiExamination_History::model()->find('event_id=?',array($this->event->id))) {?>
				<?php echo $history->description?>
			<?php }?>
		</div>
		
		<?php if ($refraction = Element_OphCiExamination_Refraction::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Refraction</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<?php if($refraction->hasRight()) { ?>
						<?php
						$this->widget('application.modules.eyedraw.OEEyeDrawWidgetRefraction', array(
								'identifier' => 'right_'.$refraction->elementType->id,
								'side' => 'R',
								'mode' => 'view',
								'size' => 100,
								'model' => $refraction,
								'attribute' => 'right_axis_eyedraw',
						))?>
						<?php } else { ?>
						Not recorded
						<?php } ?>
					</div>
					<div class="right">
						<?php if($refraction->hasLeft()) { ?>
						<?php
						$this->widget('application.modules.eyedraw.OEEyeDrawWidgetRefraction', array(
								'identifier' => 'left_'.$refraction->elementType->id,
								'side' => 'L',
								'mode' => 'view',
								'size' => 100,
								'model' => $refraction,
								'attribute' => 'left_axis_eyedraw',
						))?>
						<?php } else { ?>
						Not recorded
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($visualacuity = Element_OphCiExamination_VisualAcuity::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Visual Acuity</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<div class="data">
							<?php if($visualacuity->hasRight()) { ?>
							<?php echo $visualacuity->getCombined('right') ?>
							<?php if($visualacuity->right_comments) { ?>
							(
							<?php echo $visualacuity->right_comments ?>
							)
							<?php } ?>
							<?php } else { ?>
							Not recorded
							<?php } ?>
						</div>
					</div>
					<div class="right eventDetail">
						<div class="data">
							<?php if($visualacuity->hasLeft()) { ?>
							<?php echo $visualacuity->getCombined('left') ?>
							<?php if($visualacuity->left_comments) { ?>
							(
							<?php echo $visualacuity->left_comments ?>
							)
							<?php } ?>
							<?php } else { ?>
							Not recorded
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($adnexal = Element_OphCiExamination_AdnexalComorbidity::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Adnexal Comorbidity</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<div class="data">
							<?php if($adnexal->hasRight()) {
								echo $adnexal->right_description;
							} else { ?>
							Not recorded
							<?php } ?>
						</div>
					</div>
					<div class="right eventDetail">
						<div class="data">
							<?php if($adnexal->hasLeft()) {
								echo $adnexal->left_description;
							} else { ?>
							Not recorded
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($anterior = Element_OphCiExamination_AnteriorSegment::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Anterior Segment</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<?php if($anterior->hasRight()) {
							$this->widget('application.modules.eyedraw.OEEyeDrawWidgetAnteriorSegment', array(
									'identifier' => 'right_'.$anterior->elementType->id,
									'side' => 'R',
									'mode' => 'view',
									'size' => 200,
									'model' => $anterior,
									'attribute' => 'right_eyedraw',
							));
						} else { ?>
						Not recorded
						<?php } ?>
					</div>
					<div class="right eventDetail">
						<?php if($anterior->hasLeft()) {
							$this->widget('application.modules.eyedraw.OEEyeDrawWidgetAnteriorSegment', array(
								'identifier' => 'left_'.$anterior->elementType->id,
								'side' => 'L',
								'mode' => 'view',
								'size' => 200,
								'model' => $anterior,
								'attribute' => 'left_eyedraw',
						));
						} else { ?>
						Not recorded
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($iop = Element_OphCiExamination_IntraocularPressure::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Intraocular Pressure</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<div class="data">
							<?php if($iop->right_reading->name != 'NR') { ?>
							<?php echo $iop->right_reading->name ?>
							<?php if($iop->right_instrument) {
								echo '('.$iop->right_instrument->name.')';
			} ?>
							<?php } else { ?>
							Not Recorded
							<?php }?>
						</div>
					</div>
					<div class="right eventDetail">
						<div class="data">
							<?php if($iop->left_reading->name != 'NR') { ?>
							<?php echo $iop->left_reading->name ?>
							<?php if($iop->left_instrument) {
								echo '('.$iop->left_instrument->name.')';
			} ?>
							<?php } else { ?>
							Not Recorded
							<?php }?>
						</div>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($posterior = Element_OphCiExamination_PosteriorSegment::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Posterior Segment</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<?php if($posterior->hasRight()) {
							$this->widget('application.modules.eyedraw.OEEyeDrawWidgetPosteriorSegment', array(
									'identifier' => 'right_'.$posterior->elementType->id,
									'side' => 'R',
									'mode' => 'view',
									'size' => 200,
									'model' => $posterior,
									'attribute' => 'right_eyedraw',
							));
						} else { ?>
						Not recorded
						<?php } ?>
					</div>
					<div class="right eventDetail">
						<?php if($posterior->hasLeft()) {
							$this->widget('application.modules.eyedraw.OEEyeDrawWidgetPosteriorSegment', array(
								'identifier' => 'left_'.$posterior->elementType->id,
								'side' => 'L',
								'mode' => 'view',
								'size' => 200,
								'model' => $posterior,
								'attribute' => 'left_eyedraw',
						));
						} else { ?>
						Not recorded
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($diagnoses = Element_OphCiExamination_Diagnoses::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Diagnoses</h2>
			<div class="details">
				<div class="cols2 clearfix">
					<div class="left">
						<?php if ($principal = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and principal=1 and eye_id in (2,3)',array($diagnoses->id))) {?>
							<div>
								<strong>
									<?php echo $principal->eye->adjective?>
									<?php echo $principal->disorder->term?>
								</strong>
							</div>
						<?php }?>
						<?php foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=? and principal=0 and eye_id in (2,3)',array($diagnoses->id)) as $diagnosis) {?>
							<div>
								<?php echo $diagnosis->eye->adjective?>
								<?php echo $diagnosis->disorder->term?>
							</div>
						<?php }?>
					</div>
					<div class="right">
						<?php if ($principal = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and principal=1 and eye_id in (1,3)',array($diagnoses->id))) {?>
							<div>
								<strong>
									<?php echo $principal->eye->adjective?>
									<?php echo $principal->disorder->term?>
								</strong>
							</div>
						<?php }?>
						<?php foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=? and principal=0 and eye_id in (1,3)',array($diagnoses->id)) as $diagnosis) {?>
							<div>
								<?php echo $diagnosis->eye->adjective?>
								<?php echo $diagnosis->disorder->term?>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		<?php }?>

		<?php if ($investigation = Element_OphCiExamination_Investigation::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Investigation</h2>
			<div class="details">
				<?php echo $investigation->description?>
			</div>
		<?php }?>

		<?php if ($management = Element_OphCiExamination_Management::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Management</h2>
			<div class="details">
				<?php if ($management->city_road) {?>
					<div>At City Road</div>
				<?php }?>
				<?php if ($management->satellite) {?>
					<div>At satellite</div>
				<?php }?>
				<?php if ($management->fast_track) {?>
					<div>Suitable for fast-track</div>
				<?php }?>
				<div>
					Target post-op refractive correction is <?php echo $management->target_postop_refraction?> Dioptres
				</div>
				<?php if ($management->correction_discussed) {?>
					<div>Post-op refractive correction has been discussed with the patient</div>
				<?php }else{?>
					<div>Post-op refractive correction has not been discussed with the patient</div>
				<?php }?>
				<div>
					Suitable for <?php echo $management->suitable_for_surgeon->name?> surgeon (<?php echo $management->supervised ? 'supervised' : 'unsupervised'?>)
				</div>
				<div>
					<?php echo $management->comments?>
				</div>
			</div>
		<?php }?>

		<?php if ($conclusion = Element_OphCiExamination_Conclusion::model()->find('event_id=?',array($this->event->id))) {?>
			<h2>Conclusion</h2>
			<div class="details">
				<?php echo $conclusion->description?>
			</div>
		<?php }?>
	</div>
</div>
