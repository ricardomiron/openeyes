<?php
/**
 * (C) Copyright Apperta Foundation, 2020
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2020, Apperta Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */

/**
 * @var OphCiTheatreadmission_Dilation $element
 */
?>
<td colspan="3">
    <div class="element-data">
        <table class="label-value">
            <colgroup>
                <col class="cols-4">
            </colgroup>
            <tbody>
            <?php if (isset($element->{'treatments'})) {
                foreach ($element->{'treatments'} as $treatment) {?>
                    <tr>
                        <td><?php echo $treatment->drug->name ?></td>
                        <td>
                            <i class="oe-i time small no-click pad"></i>
                            <?php echo date('H:i', strtotime($treatment->treatment_time)) ?>
                        </td>
                        <td><?php echo $treatment->drops ?> drop<?php if ($treatment->drops != 1) {
                            ?>s<?php
                            } ?>
                        </td>
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
    </div>
</td>