<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>
<div class="box admin">
	<h2>Edit institution</h2>
	<?php echo $this->renderPartial('_form_errors', array('errors' => $errors))?>
	<?php
    $form = $this->beginWidget('BaseEventTypeCActiveForm', array(
        'id' => 'adminform',
        'enableAjaxValidation' => false,
        'focus' => '#username',
        'layoutColumns' => array(
            'label' => 2,
            'field' => 5,
        ),
    ))?>
    <div class="cols-5">
        <table class="standard cols-full">
            <colgroup>
                <col class="cols-3">
                <col class="cols-5">
            </colgroup>
            <tbody>
            <tr>
                <td>Name</td>
                <td> <?php echo CHtml::activeTextField($institution, 'name', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>Remote ID</td>
                <td> <?php echo CHtml::activeTextField($institution, 'remote_id', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>Address 1</td>
                <td> <?php echo CHtml::activeTextField($address, 'address1', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>Address 2</td>
                <td> <?php echo CHtml::activeTextField($address, 'address2', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>City</td>
                <td> <?php echo CHtml::activeTextField($address, 'city', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>County</td>
                <td> <?php echo CHtml::activeTextField($address, 'county', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td> <?php echo CHtml::activeTextField($address, 'postcode', ['class' => 'cols-full']); ?> </td>
            </tr>
            <tr class="col-gap">
                <td>Country</td>
                <td >
                    <?php echo CHtml::activeDropDownList($address, 'country_id',
                        CHtml::listData( Country::model()->findAll() , 'id', 'name'), ['class' => 'cols-full']); ?>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <?php echo CHtml::button('Save', ['class' => 'button large primary event-action',
                        'name' => 'save', 'type' => 'submit', 'id' => 'et_save']); ?>
                    <?php echo CHtml::button('Cancel', ['class' => 'warning button large primary event-action',
                        'data-uri' => '/admin/sites', 'type' => 'submit', 'name' => 'cancel', 'id' => 'et_cancel']); ?>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
	<?php $this->endWidget()?>
</div>

<div class="box admin">
	<h2>Sites</h2>
	<form id="admin_institution_sites">
		<table class="standard">
			<thead>
				<tr>
					<th>ID</th>
					<th>Remote ID</th>
					<th>Name</th>
					<th>Address</th>
				</tr>
			</thead>
			<tbody>
				<?php
                foreach ($institution->sites as $site) { ?>
					<tr class="clickable" data-id="<?php echo $site->id?>" data-uri="admin/editsite?site_id=<?php echo $site->id?>">
						<td><?php echo $site->id?></td>
						<td><?php echo $site->remote_id?>&nbsp;</td>
						<td><?php echo $site->name?>&nbsp;</td>
						<td><?php echo $site->getLetterAddress(array('delimiter' => ', '))?>&nbsp;</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
</div>

<script type="text/javascript">
	handleButton($('#et_cancel'),function(e) {
		e.preventDefault();
		window.location.href = baseUrl+'/admin/institutions';
	});
</script>
