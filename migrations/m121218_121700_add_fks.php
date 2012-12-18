<?php

class m121218_121700_add_fks extends OEMigration {

	public function up() {
		foreach(array('gonio_sup' => 'description','gonio_tem' => 'description','gonio_nas' => 'description','gonio_inf' => 'description','van_herick' => 'van_herick') as $field => $table) {
			foreach(array('left','right') as $side) {
				$this->alterColumn('et_ophciexamination_gonioscopy', $side.'_'.$field.'_id', 'int(1) unsigned');
				foreach(Element_OphCiExamination_Gonioscopy::model()->findAll() as $model) {
					if(!$model->{$side.'_'.$field}) {
						$model->{$side.'_'.$field.'_id'} = null;
						$model->save();
					}
				}
				$this->addForeignKey(
						'et_ophciexamination_gonioscopy_'.$side.'_'.$field.'_id_fk',
						'et_ophciexamination_gonioscopy', $side.'_'.$field.'_id',
						'ophciexamination_gonioscopy_'.$table, 'id'
				);
			}
		}
	}

	public function down() {
		foreach(array('gonio_sup' => 'description','gonio_tem' => 'description','gonio_nas' => 'description','gonio_inf' => 'description','van_herick' => 'van_herick') as $field => $table) {
			foreach(array('left','right') as $side) {
				$this->dropForeignKey('et_ophciexamination_gonioscopy_'.$side.'_'.$field.'_id_fk', 'et_ophciexamination_gonioscopy');
			}
		}
	}

}
