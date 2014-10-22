<?php 
/*
trace( get_contact_data('facebook'), 'only field') ;
trace( get_contact_data('facebook', 'social'), 'field an group') ;
trace( get_contact_data('', 'social'), 'only group') ;
trace( get_contact_data(), 'none') ;
*/
?>


<form name="contact-data-form" method="post" action="" class="contact-data-form">

	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="X">
	



	<?php 
	
	$supercont = 0;


	$theme = get_contact_data('theme', 'config');

	$icons_folder = plugin_dir_path( __FILE__ ) . 'icons/';
	$theme_folder = $icons_folder . $theme . '/';
	$icon_path = plugins_url( 'icons/' . $theme, __FILE__);


	// obtenemos la lista de carpetas dentro del directorio 'icons', que cada una es un theme de iconos sociales.
	$themes = array();

		if ( $handle = opendir( $icons_folder ) ) {

			while (false !== ($entry = readdir($handle))) {
				if( $entry != '.' 
					&& $entry != '..' 
					&& file_exists( $icons_folder . '/' . $entry ) 
					&& is_dir( $icons_folder . '/' . $entry )
					){
						$themes[] = $entry;
				}
			}

			closedir($handle);

			if ( !empty ($themes) ) {
				sort( $themes ); // ordenamos las carpetas por orden alfabético
			}
		}




	// echo 'plugin_dir_path( __FILE__ ) -> ' . plugin_dir_path( __FILE__ ) . '<br>';  // devuelve esto: '/var/www/vhosts/cuadric.com/httpdocs/blog/wp-content/plugins/company-general-contact-data/'    ... perfect!!!
	// echo 'plugin_dir_path( __FILE__ ). "icons" -> ' . plugin_dir_path( __FILE__ ) . 'icons/plastic/' . '<br>';



	foreach ($data as $group_key => $grupo) : 

		$g_name = $group_key;
		$g_prefix = $prefix . $g_name . '_'; // $prefix viene de la página en la que está included este archivo: contact-data.php ( $prefix = 'contact_data_'; )

		?>
		
		
		<?php if ( strtolower($group_key) == 'general' ||  strtolower($group_key) == 'social' ) : ?>


			<p>&nbsp;</p>
			<h3><?php echo ucwords($group_key) ?></h3>
		
			<ul class="sortable form-table <?php echo strtolower($group_key) ?>" id="<?php echo strtolower($group_key) ?>">


				<?php 

				$cont = 0;

				$alternate = get_contact_data('alternate', 'config');

				if ( $alternate ) {
					$css_vertical = 'bottom';
				} else {
					$css_vertical = 'top';
				}

				foreach ($grupo as $field_key => $field) : 

					$f_prefix = $prefix . $g_name . '_' . $field_key;

					?>
					
						<li class="item">

							<ul>


								<li class="fila_datos" id="fila_datos_<?php echo $field['name'] ?>" valign="top">

									<div class="label">
										<label for="<?php echo $f_prefix ?>" title="field_name: '<?php echo $field['name'] ?>'"><?php echo $field['label'] ?></label>
									</div>
									<div class="datos">
								
										<?php if ( strtolower($group_key) == 'social' ) : 

											?>
											<div class="icon_preview" style="background:transparent url('<?php echo $icon_path . '/' . $field['icon'] ?>') no-repeat -416px <?php echo $css_vertical ?>"></div>
										<?php endif; ?>

										<?php if( $field['type'] == 'textarea' ) : ?>

											<textarea name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" class="textarea"><?php echo stripslashes( $field['value'] ) ?></textarea>

										<?php elseif( $field['type'] == 'text' || !$field['type'] ) : ?>

											<input type="text" name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" value="<?php echo stripslashes( $field['value'] ) ?>" class="regular-text">

										<?php endif; ?>
									</div>

									<div class="btn_edit">
											<span class="handle" title="<?php _e('Drag to rearrange fields', 'contact-data') ?>"></span>
											<a href="#" class="edit_this_btn" title="<?php _e('Edit this field', 'contact-data') ?>" onclick="cd_switch_edit_form(this);"></a>
									</div>
								</li>







								<li class="fila_edicion" id="fila_edicion_<?php echo $field['name'] ?>">

									<div class="edit_form">
										<div class="row row_1">
												<div class="un_dato label">
													<label for="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>"><?php _e('Title', 'contact-data') ?><span title="<?php _e('Title of the field viewed in this page', 'contact-data') ?>">i</span></label>
													<input type="text" name="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" value="<?php echo stripslashes( $field['label'] ) ?>" onkeyup="cd_update_title_label( this )" class="regular-text">
												</div>
												<div class="un_dato type">
													<label for="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>"><?php _e('Input type', 'contact-data') ?><span title="<?php _e('Type of the text box to store the data field content', 'contact-data') ?>">i</span></label>
													<select name="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">
														<?php $select_type = stripslashes( $field['type'] ) == 'text' ? 'selected="selected"' : '';  ?>
														<option value="text" <?php echo $select_type ?>>Single line</option>
														<?php $select_type = stripslashes( $field['type'] ) == 'textarea' ? 'selected="selected"' : '';  ?>
														<option value="textarea" <?php echo $select_type ?>>Multi line</option>
													</select>
												</div>
												<div class="un_dato name">
													<label for="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>"><?php _e('Field name', 'contact-data') ?><span title="<?php _e('The name of the field used in PHP code and shortcodes. Must be unique.', 'contact-data') ?>">i</span></label>
													<input type="text" name="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" value="<?php echo stripslashes( $field['name'] ) ?>" onkeyup="cd_update_input_names(this)" class="regular-text">
												</div>

											<?php if ( strtolower($group_key) == 'social' ) : ?>
												<div class="un_dato icon">
													<label for="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>"><?php _e('Icon', 'contact-data') ?><span title="<?php _e('Path to de icon file', 'contact-data') ?>">i</span></label>
													<select name="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>">
														<option value=""></option>
														<?php
															// mecanismo para buscar las imágenes de una carpeta en particular y comparar sus filenames con al value de $field['icon'], la que coincida será select

															if ($handle = opendir( $theme_folder )) {

																$files = array();

																while (false !== ($entry = readdir($handle))) {
																	if( $entry != '.' && $entry != '..'  ){
																		$files[] = $entry;
																	}
																}

																closedir($handle);

																if ( !empty ($files) ) {

																	sort( $files ); // ordenamos los archivos por orden alfabético

																	foreach ( $files as $filename ) {

																		$last_dot = strrpos( $filename , '.' ); // facebook.png			
																		$filename_no_ext = substr( $filename, 0, $last_dot); // nos queda 'facebook'

																		$selected = '';
																		if ( $field['icon'] == $filename ){
																			$selected = ' selected="selected"';
																		}

																		echo '<option style="background:transparent url(' . $icon_path . '/' . $field['icon'] . ') no-repeat -416px top" value="' . $filename . '"' . $selected . '>' . $filename_no_ext . '</option>';
																	}
																}
															}

														?>
													</select>
												</div>
											<?php endif; ?>

												<div class="un_dato delete">
													<a class="delete_field" href="#" onclick="cd_show_delete_confirm(this);"><?php _e('Delete...', 'contact-data') ?></a>	
													<div class="confirm_delete">
														<?php _e('Delete this data field?', 'contact-data') ?><br>
														<a class="confirm_delete_ok" href="#" onclick="cd_do_delete(this, 1);"><?php _e('Delete', 'contact-data') ?></a> | <a class="confirm_delete_ko" href="#" onclick="cd_do_delete(this, 0);"><?php _e('Cancel', 'contact-data') ?></a>
													</div>
												</div>

											<?php if ( strtolower($group_key) == 'social' ) : ?>
										</div>

										<div class="row row_2 separ">
												<div class="un_dato anchorid">
													<label for="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>"><?php _e('Anchor id', 'contact-data') ?><span title="<?php _e('The html id attribute for the anchor', 'contact-data') ?>">i</span></label>
													<input type="text" name="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchorid'] ) ?>" class="regular-text">
												</div>
												<div class="un_dato anchorclass">
													<label for="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>"><?php _e('Anchor class', 'contact-data') ?><span title="<?php _e('The html class attribute for the anchor tag. Space separated.', 'contact-data') ?>">i</span></label>
													<input type="text" name="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchorclass'] ) ?>" class="regular-text">
												</div>
												<div class="un_dato anchortarget">
													<label for="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>"><?php _e('Anchor target', 'contact-data') ?><span title="<?php _e('The html target attribute for the anchor tag', 'contact-data') ?>">i</span></label>
													<select name="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>">
														<option value=""></option>
																<?php
																	$selected = '';
																	if ( $field['anchortarget'] == '_blank' ){ $selected = ' selected="selected"'; }
																?>
														<option value="_blank"<?php echo $selected ?>>_blank</option>
																<?php
																	$selected = '';
																	if ( $field['anchortarget'] == '_parent' ){ $selected = ' selected="selected"'; }
																?>
														<option value="_parent"<?php echo $selected ?>>_parent</option>
																<?php
																	$selected = '';
																	if ( $field['anchortarget'] == '_self' ){ $selected = ' selected="selected"'; }
																?>
														<option value="_self"<?php echo $selected ?>>_self</option>
																<?php
																	$selected = '';
																	if ( $field['anchortarget'] == '_top' ){ $selected = ' selected="selected"'; }
																?>
														<option value="_top"<?php echo $selected ?>>_top</option>
													</select>											
												</div>
										</div>

										<div class="row row_3">
												<div class="un_dato anchortitle">
													<label for="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>"><?php _e('Anchor title', 'contact-data') ?><span title="<?php _e('The html title attribute (the tooltip) for the anchor tag', 'contact-data') ?>">i</span></label>
													<input type="text" name="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchortitle'] ) ?>" class="regular-text">
												</div>
											<?php endif; ?>
										</div>

									</div>

									<div class="btn_edit">
										<span class="handle" title="<?php _e('Drag to rearrange fields', 'contact-data') ?>"></span>
										<a href="#" class="edit_this_btn active" title="<?php _e('Edit this field', 'contact-data') ?>" onclick="cd_switch_edit_form(this);"></a>
									</div>
								</li>






							</ul>

						</li>





					<?php 

					$cont++;
					$supercont++;

				endforeach; ?>
						

						<?php if ( strtolower($group_key) == 'social' ){ ?>

						<li>
							<ul>
								<li class="fila_datos">

									<div class="label">
										<label><?php _e('Buttons preview', 'contact-data' ) ?></label>
									</div>
									<div class="datos">
										<div class="follow_me_preview">
											<?php 
											$args = array(
												'size' 	=> 36,
												'theme' => $data['config']['theme']['value'],
												);
											follow_me_icons( $args );
											?>
										</div>
									</div>

									<p>&nbsp;</p>
								</li>
							</ul>
						</li>

						<?php } ?>


						<li class="fila_addnew">
							<div class="label">
								<label>&nbsp;</label>
							</div>
							<div class="datos">
								<input type="button" name="create_new_field" id="create_new_field_below" class="button <?php echo strtolower($group_key) ?>" value="+ Create new field" onclick="cd_add_new_field( '<?php echo strtolower($group_key) ?>' );">
							</div>
						</li>

			</ul>

		<?php endif; ?>


		<?php if ( strtolower($group_key) == 'config' ) : ?>


			<p>&nbsp;</p>
			<h3><?php echo ucwords($group_key) ?></h3>
		
			<ul class="form-table <?php echo strtolower($group_key) ?>" id="<?php echo strtolower($group_key) ?>">

					<li>
						<ul>

							<li class="fila_datos">

								<?php $f_prefix = $prefix . $g_name . '_theme'; ?>

								<div class="label">
									<label><?php _e('Social buttons theme', 'contact-data' ) ?></label>
								</div>
								<div class="datos">
										<select name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>">

											<?php

												$val = $data['config']['theme']['value']; // el theme que hay elegido en la configuración

												foreach ( $themes as $theme ) :
													$selected = '';
													if ( $val == $theme ) { $selected = ' selected="selected"'; } 
													?>

														<option value="<?php echo $theme ?>" <?php echo $selected ?>><?php echo ucwords( strtolower( $theme ) ) ?></option>

												<?php
												endforeach; ?>

										</select>
										<span class="cd_hint"><?php _e('You can customize this in a per controls basis through the \'theme\' param in the [follow_me_icons] shortcode and in the follow_me_icons() function', 'contact-data') ?></span>
								</div>
								
							</li>


							<li class="fila_datos">

								<?php $f_prefix = $prefix . $g_name . '_alternate'; ?>

								<div class="label">
									<label><?php _e('Alternate icons state', 'contact-data' ) ?></label>
								</div>
								<div class="datos">
										<select name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>">

											<?php
												$val = $data['config']['alternate']['value'];

												$selected = '';
												if ( $val == '0' ) { $selected = ' selected="selected"'; } ?>
											<option value="0" <?php echo $selected ?>><?php _e('No', 'contact-data') ?></option>

											<?php
												$selected = '';
												if ( $val == '1' ) { $selected = ' selected="selected"'; } ?>
											<option value="1" <?php echo $selected ?>><?php _e('Yes', 'contact-data') ?></option>
										</select>
										<span class="cd_hint"><?php _e('Alternate the active and pasive images of the icons', 'contact-data') ?></span>
								</div>
								
							</li>



							<li class="fila_datos"></li>


							<li class="fila_datos">

								<?php $f_prefix = $prefix . $g_name . '_menu'; ?>

								<div class="label">
									<label><?php _e('Menu position', 'contact-data' ) ?></label>
								</div>
								<div class="datos">
										<select name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>">

											<?php
												$val = $data['config']['menu']['value'];

												$selected = '';
												if ( $val == '0' ) { $selected = ' selected="selected"'; } ?>
											<option value="0" <?php echo $selected ?>><?php _e('First level, right in the sidebar', 'contact-data') ?></option>

											<?php
												$selected = '';
												if ( $val == '1' ) { $selected = ' selected="selected"'; } ?>
											<option value="1" <?php echo $selected ?>><?php _e('Second level, inside Config menu', 'contact-data') ?></option>

										</select>
								</div>
								
							</li>


							<li class="fila_datos">

								<?php $f_prefix = $prefix . $g_name . '_clean'; ?>

								<div class="label">
									<label><?php _e('Delete data on deactivate', 'contact-data' ) ?></label>
								</div>
								<div class="datos">
										<select name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>">

											<?php
												$val = $data['config']['clean']['value'];

												$selected = '';
												if ( $val == '0' ) { $selected = ' selected="selected"'; } ?>
											<option value="0" <?php echo $selected ?>><?php _e('No', 'contact-data') ?></option>

											<?php
												$selected = '';
												if ( $val == '1' ) { $selected = ' selected="selected"'; } ?>
											<option value="1" <?php echo $selected ?>><?php _e('Yes', 'contact-data') ?></option>
										</select>
								</div>
								
							</li>


						</ul>
					</li>
				</ul>

		<?php endif; ?>



	<?php endforeach; ?>
	

	<p>&nbsp;</p>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
	</p>


	



</form>


















<ul id="empty_block" class="item-general">

					<li class="item">
						
						<ul>



							<li class="fila_datos" id="fila_datos_<?php echo $field['name'] ?>" style="display:none;">

								<div class="label">
									<label for="<?php echo $f_prefix ?>" title="field_name: '<?php echo $field['name'] ?>'"><?php echo $field['label'] ?></label>
								</div>
								<div class="datos">
									<?php if( $field['type'] == 'textarea' ) : ?>

										<textarea name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" class="textarea"><?php echo stripslashes( $field['value'] ) ?></textarea>

									<?php elseif( $field['type'] == 'text' || !$field['type'] ) : ?>

										<input type="text" name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" value="<?php echo stripslashes( $field['value'] ) ?>" class="regular-text">

									<?php endif; ?>
								</div>

								<div class="btn_edit">
										<span class="handle" title="<?php _e('Drag to rearrange fields') ?>"></span>
										<a href="#" class="edit_this_btn" title="<?php _e('Edit this field') ?>" onclick="cd_switch_edit_form(this);"></a>
								</div>
							</li>







							<li class="fila_edicion" id="fila_edicion_<?php echo $field['name'] ?>" style="display:block;">

								<div class="edit_form">

									<div class="un_dato label">
										<label for="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>"><?php _e('Title') ?><span title="<?php _e('Title of the field viewed in this page') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" value="<?php echo stripslashes( $field['label'] ) ?>" onkeyup="cd_update_title_label( this )" class="regular-text">
									</div>
									<div class="un_dato type">
										<label for="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>"><?php _e('Input type') ?><span title="<?php _e('Type of the text box to store the data field content') ?>">i</span></label>
										<select name="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">
											<?php $select_type = stripslashes( $field['type'] ) == 'text' ? 'selected="selected"' : '';  ?>
											<option value="text" <?php echo $select_type ?>>Single line</option>
											<?php $select_type = stripslashes( $field['type'] ) == 'textarea' ? 'selected="selected"' : '';  ?>
											<option value="textarea" <?php echo $select_type ?>>Multi line</option>
										</select>
									</div>
									<div class="un_dato name">
										<label for="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>"><?php _e('Field name') ?><span title="<?php _e('The name of the field used in PHP code and shortcodes. Must be unique.') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" value="<?php echo stripslashes( $field['name'] ) ?>" onkeyup="cd_update_input_names(this)" class="regular-text">
									</div>
									<div class="un_dato delete">
										<a class="delete_field" href="#" onclick="cd_show_delete_confirm(this);"><?php _e('Delete...') ?></a>	
										<div class="confirm_delete">
											<?php _e('Delete this data field?') ?><br>
											<a class="confirm_delete_ok" href="#" onclick="cd_do_delete(this, 1);"><?php _e('Delete') ?></a> | <a class="confirm_delete_ko" href="#" onclick="cd_do_delete(this, 0);"><?php _e('Cancel') ?></a>
										</div>
									</div>

								</div>

								<div class="btn_edit">
									<span class="handle" title="<?php _e('Drag to rearrange fields') ?>"></span>
									<a href="#" class="edit_this_btn active" title="<?php _e('Edit this field') ?>" onclick="cd_switch_edit_form(this);"></a>
								</div>
							</li>


						</ul>

					</li>
</ul>


<ul id="empty_block" class="item-social">

					<li class="item">
						
						<ul>



							<li class="fila_datos" id="fila_datos_<?php echo $field['name'] ?>" style="display:none;">

								<div class="label">
									<label for="<?php echo $f_prefix ?>" title="field_name: '<?php echo $field['name'] ?>'"><?php echo $field['label'] ?></label>
								</div>
								<div class="datos">
							
										<div class="icon_preview"></div>

									<?php if( $field['type'] == 'textarea' ) : ?>

										<textarea name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" class="textarea"><?php echo stripslashes( $field['value'] ) ?></textarea>

									<?php elseif( $field['type'] == 'text' || !$field['type'] ) : ?>

										<input type="text" name="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xvalue_<?php echo $cont ?>" value="<?php echo stripslashes( $field['value'] ) ?>" class="regular-text">

									<?php endif; ?>
								</div>

								<div class="btn_edit">
										<span class="handle" title="<?php _e('Drag to rearrange fields', 'contact-data') ?>"></span>
										<a href="#" class="edit_this_btn" title="<?php _e('Edit this field', 'contact-data') ?>" onclick="cd_switch_edit_form(this);"></a>
								</div>
							</li>







							<li class="fila_edicion" id="fila_edicion_<?php echo $field['name'] ?>" style="display:block;">

								<div class="edit_form">

									<div class="un_dato label">
										<label for="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>"><?php _e('Title', 'contact-data') ?><span title="<?php _e('Title of the field viewed in this page', 'contact-data') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xlabel_<?php echo $cont ?>" value="<?php echo stripslashes( $field['label'] ) ?>" onkeyup="cd_update_title_label( this )" class="regular-text">
									</div>
									<div class="un_dato type">
										<label for="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>"><?php _e('Input type', 'contact-data') ?><span title="<?php _e('Type of the text box to store the data field content', 'contact-data') ?>">i</span></label>
										<select name="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xtype_<?php echo $cont ?>">
											<?php $select_type = stripslashes( $field['type'] ) == 'text' ? 'selected="selected"' : '';  ?>
											<option value="text" <?php echo $select_type ?>>Single line</option>
											<?php $select_type = stripslashes( $field['type'] ) == 'textarea' ? 'selected="selected"' : '';  ?>
											<option value="textarea" <?php echo $select_type ?>>Multi line</option>
										</select>
									</div>
									<div class="un_dato name">
										<label for="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>"><?php _e('Field name', 'contact-data') ?><span title="<?php _e('The name of the field used in PHP code and shortcodes. Must be unique.', 'contact-data') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xname_<?php echo $cont ?>" value="<?php echo stripslashes( $field['name'] ) ?>" onkeyup="cd_update_input_names(this)" class="regular-text">
									</div>
									<div class="un_dato icon">
										<label for="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>"><?php _e('Icon', 'contact-data') ?><span title="<?php _e('Path to de icon file', 'contact-data') ?>">i</span></label>
										<select name="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xicon_<?php echo $cont ?>">
											<option value=""></option>
											<?php
												// mecanismo para buscar las imágenes de una carpeta en particular y comparar sus filenames con al value de $field['icon'], la que coincida será select

												if ($handle = opendir( $theme_folder )) {

													$files = array();

													while (false !== ($entry = readdir($handle))) {
														if( $entry != '.' && $entry != '..'  ){
															$files[] = $entry;
														}
													}

													closedir($handle);

													if ( !empty ($files) ) {

														sort( $files ); // ordenamos los archivos por orden alfabético

														foreach ( $files as $filename ) {

															$last_dot = strrpos( $filename , '.' ); // facebook.png			
															$filename_no_ext = substr( $filename, 0, $last_dot); // nos queda 'facebook'

															$selected = '';
															if ( $field['icon'] == $filename ){
																$selected = ' selected="selected"';
															}

															echo '<option style="background:transparent url(' . $icon_path . '/' . $field['icon'] . ') no-repeat -416px top" value="' . $filename . '"' . $selected . '>' . $filename_no_ext . '</option>';
														}
													}
												}

											?>
										</select>
									</div>
									<div class="un_dato delete">
										<a class="delete_field" href="#" onclick="cd_show_delete_confirm(this);"><?php _e('Delete...', 'contact-data') ?></a>	
										<div class="confirm_delete">
											<?php _e('Delete this data field?', 'contact-data') ?><br>
											<a class="confirm_delete_ok" href="#" onclick="cd_do_delete(this, 1);"><?php _e('Delete', 'contact-data') ?></a> | <a class="confirm_delete_ko" href="#" onclick="cd_do_delete(this, 0);"><?php _e('Cancel', 'contact-data') ?></a>
										</div>
									</div>
									<div class="clear separ"></div>
									<div class="un_dato anchorid">
										<label for="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>"><?php _e('Anchor id', 'contact-data') ?><span title="<?php _e('The html id attribute for the anchor', 'contact-data') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchorid_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchorid'] ) ?>" class="regular-text">
									</div>
									<div class="un_dato anchorclass">
										<label for="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>"><?php _e('Anchor class', 'contact-data') ?><span title="<?php _e('The html class attribute for the anchor tag. Space separated.', 'contact-data') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchorclass_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchorclass'] ) ?>" class="regular-text">
									</div>
									<div class="un_dato anchortarget">
										<label for="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>"><?php _e('Anchor target', 'contact-data') ?><span title="<?php _e('The html target attribute for the anchor tag', 'contact-data') ?>">i</span></label>
										<select name="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchortarget_<?php echo $cont ?>">
											<option value=""></option>
													<?php
														$selected = '';
														if ( $field['anchortarget'] == '_blank' ){ $selected = ' selected="selected"'; }
													?>
											<option value="_blank"<?php echo $selected ?>>_blank</option>
													<?php
														$selected = '';
														if ( $field['anchortarget'] == '_parent' ){ $selected = ' selected="selected"'; }
													?>
											<option value="_parent"<?php echo $selected ?>>_parent</option>
													<?php
														$selected = '';
														if ( $field['anchortarget'] == '_self' ){ $selected = ' selected="selected"'; }
													?>
											<option value="_self"<?php echo $selected ?>>_self</option>
													<?php
														$selected = '';
														if ( $field['anchortarget'] == '_top' ){ $selected = ' selected="selected"'; }
													?>
											<option value="_top"<?php echo $selected ?>>_top</option>
										</select>											
									</div>
									<div class="clear separ"></div>
									<div class="un_dato anchortitle">
										<label for="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>"><?php _e('Anchor title', 'contact-data') ?><span title="<?php _e('The html title attribute (the tooltip) for the anchor tag', 'contact-data') ?>">i</span></label>
										<input type="text" name="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>" id="<?php echo $f_prefix ?>_xanchortitle_<?php echo $cont ?>" value="<?php echo stripslashes( $field['anchortitle'] ) ?>" class="regular-text">
									</div>

								</div>

								<div class="btn_edit">
									<span class="handle" title="<?php _e('Drag to rearrange fields', 'contact-data') ?>"></span>
									<a href="#" class="edit_this_btn active" title="<?php _e('Edit this field', 'contact-data') ?>" onclick="cd_switch_edit_form(this);"></a>
								</div>
								
							</li>


						</ul>

					</li>
</ul>


















	
	<script>

		$j = jQuery.noConflict();

		
		var field_idx 		= <?php echo $supercont ?>;
		var prefix 			= '<?php echo $prefix ?>';

		var dummy_field = '';



		function  cd_switch_edit_form( btn ){

			var fila_datos = $j(btn).parents('.item').find('.fila_datos');
			var fila_edicion = $j(btn).parents('.item').find('.fila_edicion');

			if( fila_datos.css( 'display') == 'none' ){
				fila_edicion.css( 'display', 'none' );
				fila_datos.css( 'display', 'block' );
			}else{
				fila_datos.css( 'display', 'none' );
				fila_edicion.css( 'display', 'block' );
			}
			event.preventDefault();
		}





		function cd_add_new_field( data_group ){

				var $alto_new_element = 71;

				if ( data_group == 'social' ){
					dummy_field	= $j('#empty_block.item-social .item');
					$alto_new_element = 196;
				} else {
					dummy_field	= $j('#empty_block.item-general .item');
				}

				var new_field = dummy_field
										.css({
											opacity : 0,
											height 	: 0
										})
										.clone()
										.insertAfter( $j('.form-table.' + data_group).find('.item').last() )
										.animate({ height:$alto_new_element }, 300, function(){
											$j(this).animate( {
												opacity: 1
											}, 500, function(){
												$j(this).css('height','auto');
											});
										});


				$j(new_field).find('.fila_datos .datos textarea')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
											value: 	''
									});
				$j(new_field).find('.fila_datos .datos input')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xvalue_' + field_idx,
											value: 	''
									});

				// -----------------

				$j(new_field).find('.fila_datos .label label')
								.attr( {
											for: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx
									})
								.text('field' + field_idx);




				// -----------------

				$j(new_field).find('.fila_edicion .label label')
								.attr( {
											for: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx
									});

				$j(new_field).find('.fila_edicion .label input')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xlabel_' + field_idx
									})
								.val('field' + field_idx);
				// -----------------

				$j(new_field).find('.fila_edicion .type label')
								.attr( {
											for: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx
									});
				$j(new_field).find('.fila_edicion .type select')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xtype_' + field_idx
									});
				// -----------------

				$j(new_field).find('.fila_edicion .name label')
								.attr( {
											for: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx
									});
				$j(new_field).find('.fila_edicion .name input')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xname_' + field_idx
									})
								.val('field' + field_idx);
				// -----------------

				$j(new_field).find('.fila_edicion .icon label')
								.attr( {
											for: 	prefix + data_group + '_' + 'field' + field_idx + '_xicon_' + field_idx
									});
				$j(new_field).find('.fila_edicion .icon select')
								.attr( {
											name: 	prefix + data_group + '_' + 'field' + field_idx + '_xicon_' + field_idx,
											id: 	prefix + data_group + '_' + 'field' + field_idx + '_xicon_' + field_idx
									});
				// -----------------



				field_idx++;

				event.preventDefault();
		}




		function cd_show_delete_confirm( btn ){

			$j(btn).css('display', 'none');//parents('.un_dato.delete').find('.delete_field').hide();
			$j(btn).parents('.un_dato.delete').find('.confirm_delete').css('display', 'block');

			event.preventDefault();
		}





		function cd_do_delete( btn, result ){

			if ( result ) {

						$j(btn).parents('.item').animate( {
							opacity: 0
						}, 500, function(){
							$j(this).animate({height:0},300, function(){
								$j(this).remove();
							});
						});

			} else {

				$j(btn).parents('.un_dato.delete').find('.delete_field').css('display', 'block');
				$j(btn).parent().css('display', 'none');

			}

			event.preventDefault();
		}




		function cd_update_title_label( control ){
			$j(control).parents('.item').find('.fila_datos .label label').text( $j(control).val() );
		}




		function cd_update_input_names( control ){

			var value = $j(control).val();
			var bloque = $j(control).parents('.item');
			var data_group = $j(control).parents('.form-table').attr('id');

			// alert('cd_update_input_names: ' + 'name:' +	prefix + data_group + '_' + value + '_xvalue_' + field_idx);


				bloque.find('.fila_datos .datos textarea')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xvalue_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xvalue_' + field_idx
									});
				bloque.find('.fila_datos .datos input')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xvalue_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xvalue_' + field_idx
									});

				// -----------------

				bloque.find('.fila_datos .label label')
								.attr( {
											for: 	prefix + data_group + '_' + value + '_xlabel_' + field_idx
									});


				// -----------------

				bloque.find('.fila_edicion .label label')
								.attr( {
											for: 	prefix + data_group + '_' + value + '_xlabel_' + field_idx
									});

				bloque.find('.fila_edicion .label input')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xlabel_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xlabel_' + field_idx
									});
				// -----------------

				bloque.find('.fila_edicion .type label')
								.attr( {
											for: 	prefix + data_group + '_' + value + '_xtype_' + field_idx
									});
				bloque.find('.fila_edicion .type select')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xtype_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xtype_' + field_idx
									});
				// -----------------

				bloque.find('.fila_edicion .name label')
								.attr( {
											for: 	prefix + data_group + '_' + value + '_xname_' + field_idx
									});
				bloque.find('.fila_edicion .name input')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xname_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xname_' + field_idx
									});
				// -----------------

				bloque.find('.fila_edicion .icon label')
								.attr( {
											for: 	prefix + data_group + '_' + value + '_xicon_' + field_idx
									});
				bloque.find('.fila_edicion .icon select')
								.attr( {
											name: 	prefix + data_group + '_' + value + '_xicon_' + field_idx,
											id: 	prefix + data_group + '_' + value + '_xicon_' + field_idx
									});
				// -----------------


		}



	</script>