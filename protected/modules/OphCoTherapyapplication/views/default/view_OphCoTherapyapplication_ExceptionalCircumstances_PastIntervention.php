<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>

<table>
  <tbody class="pastintervention-view panel previous-interventions">
  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('start_date'); ?>:
    </td>
    <td>
        <?php echo Helper::convertMySQL2NHS($pastintervention->start_date) ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('end_date'); ?>:
    </td>
    <td>
        <?php echo Helper::convertMySQL2NHS($pastintervention->end_date) ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('treatment_id'); ?>:
    </td>
    <td>
        <?php echo $pastintervention->getTreatmentName() ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('start_va'); ?>:
    </td>
    <td>
        <?php echo $pastintervention->start_va ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('end_va'); ?>:
    </td>
    <td>
        <?php echo $pastintervention->end_va ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('stopreason_id'); ?>:
    </td>
    <td>
        <?php if ($pastintervention->stopreason_other) {
            echo Yii::app()->format->Ntext($pastintervention->stopreason_other);
        } else {
            echo $pastintervention->stopreason->name;
        } ?>
    </td>
  </tr>

  <tr>
    <td>
        <?php echo $pastintervention->getAttributeLabel('comments'); ?>:
    </td>
    <td>
        <?php if ($pastintervention->comments) {
            echo Yii::app()->format->Ntext($pastintervention->comments);
        } else {
            echo 'None';
        } ?>
    </td>
  </tr>
  </tbody>
</table>