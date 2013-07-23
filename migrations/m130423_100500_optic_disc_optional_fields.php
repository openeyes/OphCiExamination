<?php

class m130423_100500_optic_disc_optional_fields extends OEMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_opticdisc', 'left_diameter', 'FLOAT(2,1)');
		$this->alterColumn('et_ophciexamination_opticdisc', 'right_diameter', 'FLOAT(2,1)');
	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_opticdisc', 'left_diameter', 'FLOAT(2,1) NOT NULL');
		$this->alterColumn('et_ophciexamination_opticdisc', 'right_diameter', 'FLOAT(2,1) NOT NULL');
	}

}
