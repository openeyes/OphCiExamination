<?php

class m130306_093800_posteriorpole_api_change extends OEMigration {
	
	public function up() {
		foreach(Element_OphCiExamination_PosteriorPole::model()->findAll() as $element) {
			foreach(array('right','left') as $side) {
				$drawing[$side] = json_decode($element->{$side.'_eyedraw'}, true);
				// Iterate object looking for PostPole doodles
				if($drawing[$side]) {
					foreach($drawing[$side] as $index => $doodle) {
						// Adjust parameters for PostPole doodles
						if($doodle["subclass"] == "PostPole") {
							$drawing[$side][$index]["originX"] = 0;
							$drawing[$side][$index]["apexX"] = 300;
						}
					}
				}
			}
			$this->update('et_ophciexamination_posteriorpole', array(
					'right_eyedraw' => json_encode($drawing['right']),
					'left_eyedraw' => json_encode($drawing['left']),
			), 'id = :id', array(':id' => $element->id));
		}
	}

	public function down() {
	}
	
}
