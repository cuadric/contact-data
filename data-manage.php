
<?php 
/*
trace( get_contact_data('facebook'), 'only field') ;
trace( get_contact_data('facebook', 'social'), 'field an group') ;
trace( get_contact_data('', 'social'), 'only group') ;
trace( get_contact_data(), 'none') ;
*/
?>


<form name="contact-data-manage" id="contact-data-manage" method="post" action="" class="contact-data-manage">

	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="X">
	


	<p>&nbsp;</p>


	<ul class="data_groups">


	<?php

		$cont = 0; 
		
		foreach ($data as $group_key => $grupo) : 

		$g_name = $group_key;
		$g_prefix = $prefix . $g_name . '_'; // $prefix viene de la página en la que está included este archivo: contact-data.php ( $prefix = 'contact_data_'; )

	?>
		
		<li class="data_group">
		<h3><?php echo ucwords($group_key) ?></h3>

		<ul class="sortable metabox-holder group_<?php echo strtolower($group_key) ?>">


		<?php foreach ($grupo as $field_key => $field) : 

				$f_prefix = $prefix . $g_name . '_' . $field_key;

		?>	

				<li class="postbox">

					<a  href="#" class="delete_btn" title="<?php _e('Delete this field') ?>" onclick="cd_delete_field(this);">
						<?php _e('Delete') ?>
					</a>


					<h3 class="hndle">
						<?php $lbl = stripslashes( $field['label'] ) ? stripslashes( $field['label'] ) : '&nbsp;' ?>
						<span><?php echo $lbl ?></span>						
					</h3>

					<div class="inside">
						<input type="hidden" name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" value="<?php echo stripslashes( $field['value'] ) ?>">
						<div class="un_dato label">
							<label for="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>">Label</label>
							<input type="text" name="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" value="<?php echo stripslashes( $field['label'] ) ?>" class="regular-text">
						</div>
						<div class="un_dato type">
							<label for="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">Input type</label>
							<select name="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">
								<?php $select_type = stripslashes( $field['type'] ) == 'text' ? 'selected="selected"' : '';  ?>
								<option value="text" <?php echo $select_type ?>>Text</option>
								<?php $select_type = stripslashes( $field['type'] ) == 'textarea' ? 'selected="selected"' : '';  ?>
								<option value="textarea" <?php echo $select_type ?>>Textarea</option>
							</select>
						</div>
						<div class="un_dato hint">
							<label for="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>">Hint</label>
							<input type="text" name="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>" value="<?php echo stripslashes( $field['input_hint'] ) ?>" class="regular-text">
						</div>
						<div class="un_dato name">
							<label for="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>">Var name</label>
							<input type="text" name="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" value="<?php echo stripslashes( $field['name'] ) ?>" class="regular-text">
						</div>
					</div>
				</li>

		<?php 

			$cont++;

			endforeach; ?>


			<li class="create_new_field_cont below">
				<input type="button" name="create_new_field" id="create_new_field_below" class="button <?php echo strtolower($group_key) ?>" value="<?php esc_attr_e('+ Create new field') ?>"
				onclick="cd_add_new_field( '<?php echo strtolower($group_key) ?>', 'below' );" />
			</li>

		</ul>

	</li>

	<?php 

		endforeach; ?>

	</ul>
	

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
	</p>







</form>


			<ul id="empty_block"><!-- no debe estar dentro del form... que si no se envía con el formulario!!!!! -->
				<li class="postbox">

					<a  href="#" class="delete_btn" title="<?php _e('Delete this field') ?>" onclick="cd_delete_field(this);">
						<?php _e('Delete') ?>
					</a>


					<h3 class="hndle">
						<span><?php _e('[New field]') ?></span>
						
					</h3>

					<div class="inside">
						<input type="hidden" name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" value="" class="hidden_value">
						<div class="un_dato label">
							<label for="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>">Label</label>
							<input type="text" name="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" value="" class="regular-text">
						</div>
						<div class="un_dato type">
							<label for="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">Input type</label>
							<select name="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">
								<option value="text" selected="selected">Single line</option>
								<option value="textarea">Multi line</option>
							</select>
						</div>
						<div class="un_dato hint">
							<label for="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>">Hint</label>
							<input type="text" name="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xhint_<?php echo $cont ?>" value="" class="regular-text">
						</div>
						<div class="un_dato name">
							<label for="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>">Var name</label>
							<input type="text" name="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" value="" class="regular-text">
						</div>
					</div>
				</li>
			</ul>

<script>

	$j = jQuery.noConflict();
	
	var field_idx 		= <?php echo $cont ?>;
	var prefix 			= '<?php echo $prefix ?>';

	var dummy_field 	= $j('#empty_block .postbox');


	function cd_add_new_field( data_group, position ){

			var new_field = dummy_field
									.css({
										opacity : 0,
										height 	: 0
									})
									.clone()
									.insertBefore( $j('.group_' + data_group + ' .create_new_field_cont.' + position) )
									.animate({ height:78 }, 300, function(){
										$j(this).animate( {
											opacity: 1
										}, 500);
									});




			$j(new_field).find('.hidden_value')
							.attr( {
										name: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
										id: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
										value: 	''
								});

			// -----------------

			$j(new_field).find('.label label')
							.attr( {
										for: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx
								});

			$j(new_field).find('.label input')
							.attr( {
										name: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx,
										id: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx
								});
			// -----------------

			$j(new_field).find('.type label')
							.attr( {
										for: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx
								});
			$j(new_field).find('.type select')
							.attr( {
										name: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx,
										id: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx
								});
			// -----------------

			$j(new_field).find('.hint label')
							.attr( {
										for: 	prefix + data_group + '_' + 'field' + field_idx + '_xhint_' + field_idx
								});
			$j(new_field).find('.hint input')
							.attr( {
										name: 	prefix + data_group + '_' + 'field' + field_idx + '_xhint_' + field_idx,
										id: 	prefix + data_group + '_' + 'field' + field_idx + '_xhint_' + field_idx
								});
			// -----------------

			$j(new_field).find('.name label')
							.attr( {
										for: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx
								});
			$j(new_field).find('.name input')
							.attr( {
										name: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx,
										id: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx
								});
			// -----------------



			field_idx++;

			event.preventDefault();
	}





	function cd_delete_field( delete_btn ){

		var p = $j(delete_btn).parent();

		p.animate( {
			opacity: 0
		}, 500, function(){
			$j(this).animate({height:0},300, function(){
				$j(this).remove();
			});
		});
		
		event.preventDefault();
		
	}

</script>