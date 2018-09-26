<?php
/**
 * (C) OpenEyes Foundation, 2018
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>

    <form id="admin_CommissioningBodies">
        <table class="standard">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox"
                               id="checkall"
                               class="commissioning_body" />
                    </th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (CommissioningBody::model()->findAll(array('order' => 'name asc')) as $i => $cb) {?>
                    <tr class="clickable" data-id="<?php echo $cb->id?>" data-uri="admin/editCommissioningBody?commissioning_body_id=<?php echo $cb->id?>">
                        <td><input type="checkbox" name="commissioning_body[]" value="<?php echo $cb->id?>" class="wards" /></td>
                        <td><?php echo $cb->code?></td>
                        <td><?php echo $cb->name?></td>
                        <td><?php echo $cb->type->name?></td>
                        <td><?php echo $cb->address ? $cb->address->address1 : 'None'?></td>
                    </tr>
                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <?php echo CHtml::button(
                            'Add',
                            [
                                'class' => 'button large',
                                'name' => 'add_commissioning_body',
                                'id' => 'et_add'
                            ]
                        ); ?>
                        <?php echo CHtml::button(
                            'Delete',
                            [
                                'class' => 'button large',
                                'name' => 'delete_commissioning_body',
                                'data-object' => 'CommissioningBodies',
                                'id' => 'et_delete'
                            ]
                        ); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>

<div id="confirm_delete_commissioning_bodies"
     title="Confirm delete commissioning_body" style="display: none;">
    <div>
        <div id="delete_commissioning_bodies">
            <div class="alertBox" style="margin-top: 10px; margin-bottom: 15px;">
                <strong>WARNING: This will remove the commissioning bodies from the system.<br/>This action cannot be undone.</strong>
            </div>
            <p>
                <strong>Are you sure you want to proceed?</strong>
            </p>
            <div class="buttonwrapper" style="margin-top: 15px; margin-bottom: 5px;">
                <input type="hidden" id="medication_id" value="" />
                <button type="submit" class="classy red venti btn_remove_commissioning_bodies"><span class="button-span button-span-red">Remove commissioning bodies(s)</span></button>
                <button type="submit" class="classy green venti btn_cancel_remove_commissioning_bodies"><span class="button-span button-span-green">Cancel</span></button>
                <img class="loader" src="<?php echo Yii::app()->assetManager->createUrl('img/ajax-loader.gif')?>" alt="loading..." style="display: none;" />
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#et_add_commissioning_body').click(function(e) {
        e.preventDefault();
        window.location.href = baseUrl+'/admin/addCommissioning_body';
    });

    $('#checkall').click(function(e) {
        $('input[name="commissioning_body[]"]').attr('checked',$(this).is(':checked') ? 'checked' : false);
    });

    $('#et_delete_commissioning_body').click(function(e) {
        e.preventDefault();

        if ($('input[type="checkbox"][name="commissioning_body[]"]:checked').length <1) {
            alert("Please select the commissioning bodies you wish to delete.");
            enableButtons();
            return;
        }

        $.ajax({
            'type': 'POST',
            'url': baseUrl+'/admin/verifyDeleteCommissioningBodies',
            'data': $('#admin_commissioning_bodies').serialize()+"&YII_CSRF_TOKEN="+YII_CSRF_TOKEN,
            'success': function(resp) {
                var mention = ($('input[type="checkbox"][name="commissioning_body[]"]:checked').length == 1) ? 'commissioning body' : 'commissioning bodies';

                if (resp == "1") {
                    enableButtons();

                    $('#confirm_delete_commissioning_bodies').attr('title','Confirm delete '+mention);
                    $('#delete_commissioning_bodies').children('div').children('strong').html("WARNING: This will remove the "+mention+" from the system.<br/><br/>This action cannot be undone.");
                    $('button.btn_remove_commissioning_bodies').children('span').text('Remove '+mention);

                    $('#confirm_delete_commissioning_bodies').dialog({
                        resizable: false,
                        modal: true,
                        width: 560
                    });
                } else {
                    alert("One or more of the selected commissioning bodies are in use and so cannot be deleted.");
                    enableButtons();
                }
            }
        });
    });

    $('button.btn_cancel_remove_commissioning_bodies').click(function(e) {
        e.preventDefault();
        $('#confirm_delete_commissioning_bodies').dialog('close');
    });

    handleButton($('button.btn_remove_commissioning_bodies'),function(e) {
        e.preventDefault();

        $.ajax({
            'type': 'POST',
            'url': baseUrl+'/admin/deleteCommissioningBodies',
            'data': $('#admin_commissioning_bodies').serialize()+"&YII_CSRF_TOKEN="+YII_CSRF_TOKEN,
            'success': function(resp) {
                if (resp == "1") {
                    window.location.reload();
                } else {
                    alert("There was an unexpected error deleting the commissioning bodies, please try again or contact support for assistance");
                    enableButtons();
                    $('#confirm_delete_commissioning_bodies').dialog('close');
                }
            }
        });
    });
</script>
