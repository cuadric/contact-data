
						<p>&nbsp;</p>

						<h3><?php _e('How to use this values in your templates:', 'contact_data') ?></h3>

						<p><?php _e('This function, without parameters, return an array with all the contact field data:', 'contact_data') ?> <code style="padding:5px 10px;">&lt;?php $all_field_values = <strong>get_contact_data()</strong>; ?></code></p>

						<p><?php _e('From this you can fetch the individual contact data values. Note de array syntax.', 'contact_data') ?> <code style="padding:5px 10px;">&lt;?php echo $all_field_values['email']; ?></code></p>

						<p>&nbsp;</p>
						
						<p><?php _e('To get any individual data, instead of get all of them, use this function:', 'contact_data') ?> <code style="padding:5px 10px;">&lt;?php $field_Value =  <strong>get_contact_data( 'field_name' )</strong>; ?></code></p>

						<p>&nbsp;</p>

						<p>Shortcode <code>[contact-data field="field_name"]</code></p>

						<p>&nbsp;</p>

						<p>Posible values for 'field_name':</p>
						<div class="params">
							<div class="params_float">
								<h4 class="title">Basic information</h4>
								<ul>
									<li>'name'</li>
									<li>'url'</li>
									<li>'dir'</li>
									<li>'dir_2'</li>
									<li>'email'</li>
									<li>'tel'</li>
									<li>'fax'</li>
									<li>'map'</li>
								</ul>
							</div>
							<div class="params_float">
								<h4 class="title">Social networks</h4>
								<ul>
									<li>'facebook'</li>
									<li>'twitter'</li>
									<li>'linkedin'</li>
									<li>'googleplus'</li>
									<li>'youtube'</li>
									<li>'vimeo'</li>
									<li>'rss'</li>
								</ul>
							</div>
						</div>

						<p>And many more to come!</p>

						<p>&nbsp;</p>

						<p><?php _e( 'There\'s also a widget you can use on the sidebars. <code>[follow-me-icons]</code>. It\'s really very simple. Only show those social networking buttons which have not left empty field.', 'contact_data'  ) ?></p>

						<p><?php _e('You can show the same widget through your PHP code using the <code style="padding:5px 10px;">"follow_me_icons()"</code> function', 'contact_data') ?></p>

						<p><img src="<?php echo plugins_url('images/', __FILE__) ?>/screenshot-2.png" height="123" width="439" alt=""></p>
						<p><img src="<?php echo plugins_url('images/', __FILE__) ?>/screenshot-3.png" height="123" width="439" alt=""></p>

