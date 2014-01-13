<?php
/**
 * (C) OpenEyes Foundation, 2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class OphCiExamination_Episode_MedicalRetinalHistory extends EpisodeSummaryWidget
{
	protected $injections = array();

	public function run()
	{
		$va_unit_id = @$_GET['mr_history_va_unit_id'] ?: Element_OphCiExamination_VisualAcuity::model()->getSetting('unit_id');
		$va_unit = OphCiExamination_VisualAcuityUnit::model()->findByPk($va_unit_id);

		$va_ticks = array();
		foreach ($va_unit->selectableValues as $value) {
			if ($value->base_value < 10 || ($va_unit->name == 'ETDRS Letters' && $value->value % 10)) {
				continue;
			}
			$va_ticks[] =  array($value->base_value, $value->value);
		}

		$va_axis = "Visual Acuity ({$va_unit->name})";
		$crt_axis = "Maximum CRT (µm)";

		$chart = $this->createWidget('FlotChart', array('chart_id' => 'mr-history-chart', 'legend_id' => 'mr-history-legend'))
			->configureYAxis($crt_axis, array('position' => 'right', 'min' => 250, 'max' => 600))
			->configureYAxis($va_axis, array('position' => 'left', 'min' => 1, 'max' => 150, 'ticks' => $va_ticks))
			->configureSeries('Visual Acuity (right)', array('yaxis' => $va_axis, 'lines' => array('show' => true), 'points' => array('show' => true)))
			->configureSeries('Visual Acuity (left)', array('yaxis' => $va_axis, 'lines' => array('show' => true), 'points' => array('show' => true)))
			->configureSeries('Maximum CRT (right)', array('yaxis' => $crt_axis, 'lines' => array('show' => true), 'points' => array('show' => true)))
			->configureSeries('Maximum CRT (left)', array('yaxis' => $crt_axis, 'lines' => array('show' => true), 'points' => array('show' => true)));

		$events = $this->event_type->api->getEventsInEpisode($this->episode->patient, $this->episode);

		foreach ($events as $event) {
			if (($va = $event->getElementByClass('Element_OphCiExamination_VisualAcuity'))) {
				if (($reading = $va->getBestReading('right'))) $this->addVaReading($chart, $reading, 'right');
				if (($reading = $va->getBestReading('left'))) $this->addVaReading($chart, $reading, 'left');
			}
		}

		foreach ($events as $event) {
			if (($oct = $event->getElementByClass('Element_OphCiExamination_OCT'))) {
				if ($oct->hasRight()) $this->addCrtReading($chart, $oct, 'right');
				if ($oct->hasLeft()) $this->addCrtReading($chart, $oct, 'left');
			}
		}

		$injMin = null;
		$injMax = null;

		if (($injectionApi = Yii::app()->moduleAPI->get('OphTrIntravitrealinjection'))) {
			foreach ($injectionApi->previousInjections($this->episode->patient, $this->episode, 'right') as $injection) {
				$this->addInjection($chart, $va_axis, $injection, 'right', $injMin, $injMax);
			}
			foreach ($injectionApi->previousInjections($this->episode->patient, $this->episode, 'left') as $injection) {
				$this->addInjection($chart, $va_axis, $injection, 'left', $injMin, $injMax);
			}
		}
		ksort($this->injections);

		if ($chart->hasData()) {
			// If there are injections at the extremes, expand the chart to make room to display them
			$extra = min($chart->getXMax() - $chart->getXMin(), 31536000000) / 4;
			$min = $injMin ? min($chart->getXMin(), $injMin - $extra) : $chart->getXMin();
			$max = $injMax ? max($chart->getXMax(), $injMax + $extra) : $chart->getXMax();

			$chart->configureXAxis(
				array(
					'mode' => 'time',
					'min' => max($min, $max - 31536000000),  // limit default display to the last year
					'max' => $max,
					'panRange' => array($min, $max),
				)
			);
		}

		$this->render(
			'OphCiExamination_Episode_MedicalRetinalHistory',
			array('va_unit' => $va_unit, 'chart' => $chart)
		);
	}

	/**
	 * @param FlotChart $chart
	 * @param Ophciexamination_VisualAcuity_Reading $reading
	 * @param string $side
	 */
	protected function addVaReading(FlotChart $chart, Ophciexamination_VisualAcuity_Reading $reading, $side)
	{
		$series_name = "Visual Acuity ({$side})";
		$label = "{$series_name}\n{$reading->element->unit->name}: {$reading->convertTo($reading->value)} {$reading->method->name}";
		$chart->addPoint($series_name, Helper::mysqlDate2JsTimestamp($reading->last_modified_date), $reading->value, $label);
	}

	/**
	 * @param FlotChart $chart
	 * @param Element_OphCiExamination_OCT $oct
	 * @param string $side
	 */
	protected function addCrtReading(FlotChart $chart, Element_OphCiExamination_OCT $oct, $side)
	{
		$series_name = "Maximum CRT ({$side})";
		$crt = $oct->{"{$side}_crt"};
		$chart->addPoint($series_name, Helper::mysqlDate2JsTimestamp($oct->last_modified_date), $crt, "{$series_name}\n{$crt} µm");
	}

	/**
	 * @param FlotChart $chart
	 * @param string $va_axis
	 * @param array $injection
	 * @param string $side
	 * @param float|null &$injMin
	 * @param float|null &$injMax
	 */
	protected function addInjection(FlotChart $chart, $va_axis, array $injection, $side, &$injMin, &$injMax)
	{
		$drug = $injection["{$side}_drug"];
		$timestamp = Helper::mysqlDate2JsTimestamp($injection['date']);

		$chart->configureSeries($drug, array('yaxis' => $va_axis, 'bars' => array('show' => true)));
		$chart->addPoint($drug, $timestamp, 149);

		$this->injections[$timestamp][$side] = $drug;

		if ($side == 'right' && (!$injMin || $timestamp < $injMin)) $injMin = $timestamp;
		if ($side == 'left' && (!$injMax || $timestamp > $injMax)) $injMax = $timestamp;
	}
}
