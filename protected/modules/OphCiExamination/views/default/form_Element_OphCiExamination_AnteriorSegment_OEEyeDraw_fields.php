<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="field-row">
    <?php echo CHtml::activeHiddenField($element, $side . '_ed_report'); ?>
    <div class="large-2 column">
        <label>
            <?php echo $element->getAttributeLabel($side . '_ed_report') ?>:
        </label>
    </div>
    <div class="large-10 column end" style="line-height: 1; margin-bottom:10px;">
        <span id="<?= CHtml::modelName($element) . '_' . $side . '_ed_report_display'?>" class="data-value"></span>
    </div>
    <div class="large-2 column">
        <label for="<?php echo CHtml::modelName($element) . '_' . $side . '_description'; ?>">
            <?php echo $element->getAttributeLabel($side . '_description') ?>:
        </label>
    </div>
    <?php
        $default = OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_Nuclear::getEyedrawDefault();
        echo $form->hiddenField($element, $side.'_nuclear_id', array(
            'data-eyedraw-map' => CJSON::encode(OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_Nuclear::getEyedrawMapping()),
            'data-eyedraw-default' => $default ? $default->id : ''));

    $default = OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_Cortical::getEyedrawDefault();
    echo $form->hiddenField($element, $side.'_cortical_id', array(
        'data-eyedraw-map' => CJSON::encode(OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_Cortical::getEyedrawMapping()),
        'data-eyedraw-default' => $default ? $default->id : ''));
    ?>
    <div class="large-10 column end">
        <?php echo CHtml::activeTextArea($element, $side . '_description',
            array('rows' => '2', 'class' => 'autosizejs')) ?>
    </div>
</div>

