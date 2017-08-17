<?php
/**
 * OpenEyes.
 *
 * (C) OpenEyes Foundation, 2017
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * Class AllergyMigrateCommand
 */
class AllergyMigrateCommand extends PatientLevelMigration
{
    protected $event_type_cls = 'OphCiExamination';
    // Original table is renamed to this during the module database migration
    protected static $archived_entry_table = 'archive_patient_allergy_assignment';
    // column on patient record indicating no entries have been explicitly recorded
    protected static $archived_no_values_col = 'archive_no_allergies_date';
    protected static $no_values_col = 'no_allergies_date';
    protected static $element_class = 'OEModule\OphCiExamination\models\Allergies';
    protected static $entry_class = 'OEModule\OphCiExamination\models\AllergyEntry';
    protected static $entry_attributes = array(
        'allergy_id',
        'other',
        'comments'
    );

    public function getHelp()
    {
        return "Migrates the original Allergy records to an examination event in change tracker episode\n";
    }

}