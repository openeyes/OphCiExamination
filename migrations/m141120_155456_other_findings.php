<?php

class m141120_155456_other_findings extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_further_findings','requires_description','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_further_findings_version','requires_description','tinyint(1) unsigned not null');

		$this->addColumn('ophciexamination_further_findings_assignment','description','varchar(4096) not null');
		$this->addColumn('ophciexamination_further_findings_assignment_version','description','varchar(4096) not null');
	}

	public function down()
	{
		$this->dropColumn('ophciexamination_further_findings_assignment','description');
		$this->dropColumn('ophciexamination_further_findings_assignment_version','description');

		$this->dropColumn('ophciexamination_further_findings','requires_description');
		$this->dropColumn('ophciexamination_further_findings_version','requires_description');
	}
}
