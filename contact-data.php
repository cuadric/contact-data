<?php

/*
Plugin Name: Contact Data
Plugin URI: http://www.cuadric.com/plugins/contact-data
Description: Manage all your contact information from a single admin page and recover it with one single function.
Tags: Contact information, Contact data, Contact admin page, Social networks
Author URI: http://www.cuadric.com/
Author: Gonzalo Sanchez
Donate link: http://www.cuadric.com/plugins/contact-data
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 0.9
Version: 0.9
License: GPLv2 or later
*/

// ==============================================================================================================================================================

// Creamos una página de configuración DATOS DE LA EMRESA en el menú Ajustes !!!!! :)

// ==============================================================================================================================================================



// agregamos un link "Ajustes" a la descripción del plugin en la página "Plugins"

function plugin_add_settings_link( $links ) {

	$where = get_contact_data('menu', 'config');

	if ( $where ) : // 1 = Segundo nivel, dentro del menú "Ajustes"
		$settings_link = '<a href="options-general.php?page=cd-contact-data">' . __( 'Settings' ) . '</a>';
	else : // 0 = Primer nivel, Directamente en la Sidebar
		$settings_link = '<a href="admin.php?page=cd-contact-data">' . __( 'Settings' ) . '</a>';
	endif;

	array_push( $links, $settings_link );

	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );




// ==============================================================================================================================================================


// Al activar el plugin creamos la option en la la tabla wp_options si aún no existe

function contact_data_on_activate() {

    $options_existentes = maybe_unserialize( get_option( 'cd_contact_data' ) );


    // si options no existe es que es la primera vez que se activa el plugin, entonces creamos las opciones por defecto.
	$cd_default_option_values = array(
		'general' => array(
				'name' 		=> array(
						'value' 	=> '',
						'label' 	=> 'Name',
						'type' 		=> 'text',
						'name' 		=> 'name',
				),
				'slogan' 	=> array(
						'value' 	=> '',
						'label' 	=> 'Slogan',
						'type' 		=> 'text',
						'name' 		=> 'slogan',
				),
				'url' 		=> array(
						'value' 	=> '',
						'label' 	=> 'Website',
						'type' 		=> 'text',
						'name' 		=> 'url',
				),
				'email' 	=> array(
						'value' 	=> '',
						'label' 	=> 'eMail',
						'type' 		=> 'text',
						'name' 		=> 'email',
				),
				'tel' 		=> array(
						'value' 	=> '',
						'label' 	=> 'Telephone number',
						'type' 		=> 'text',
						'name' 		=> 'tel',
				),
				'dir' 		=> array(
						'value' 	=> '',
						'label' 	=> 'Address',
						'type' 		=> 'text',
						'name' 		=> 'dir',
				),
				'dir_2' 	=> array(
						'value' 	=> '',
						'label' 	=> 'Address (cont.)',
						'type' 		=> 'text',
						'name' 		=> 'dir_2',
				)
		),
		'social' => array(
				'facebook' 	=> array(
						'value' 	=> '',
						'label' 	=> 'Facebook',
						'type' 		=> 'text',
						'name' 		=> 'facebook',
						'icon' 		=> 'facebook.png',
				),
				'twitter' 	=> array(
						'value' 	=> '',
						'label' 	=> 'Twitter',
						'type' 		=> 'text',
						'name' 		=> 'twitter',
						'icon' 		=> 'twitter.png',
				),
				'googleplus'=> array(
						'value' 	=> '',
						'label' 	=> 'Google+',
						'type' 		=> 'text',
						'name' 		=> 'googleplus',
						'icon' 		=> 'googleplus.png',
				)
		),
		'config' => array(
				'theme'		=> array(
						'value' 	=> 'plastic',
				),
				'alternate'	=> array(
						'value' 	=> '0',
				),
				'menu'		=> array(
						'value' 	=> '0',
				),
				'clean'		=> array(
						'value' 	=> '0',
				),
	    )
	);


	// para agregar a las optiona existentes si se está actualizando el plugin. Antes este elemento no existía.
	$cd_default_option_config = array( 
				'theme'=> array(
						'value' 	=> 'plastic',
				),
				'alternate'	=> array(
						'value' 	=> '0',
				),
				'menu'=> array(
						'value' 	=> '0',
				),
				'clean'=> array(
						'value' 	=> '0',
				)
			);



	$deprecated = NULL;
	$autoload = 'no';


	if ( !$options_existentes )  {

		add_option( 'cd_contact_data', $cd_default_option_values, $deprecated, $autoload );

	} else {

		if ( !array_key_exists( 'config', $options_existentes ) ) {  // si no existe el elemento config
			$options_existentes['config'] = $cd_default_option_config;

			// agregamos la clave 'icon' a las entradas antiguas de redes sociales, las de la versión 0.2
			if ( !array_key_exists( 'icon', $options_existentes['social']['facebook'] ) ) 	{ $options_existentes['social']['facebook']['icon'] = 'facebook.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['twitter'] ) ) 	{ $options_existentes['social']['twitter']['icon'] = 'twitter.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['linkedin'] ) ) 	{ $options_existentes['social']['linkedin']['icon'] = 'linkedin.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['googleplus'] ) ) { $options_existentes['social']['googleplus']['icon'] = 'googleplus.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['youtube'] ) ) 	{ $options_existentes['social']['youtube']['icon'] = 'youtube.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['vimeo'] ) ) 		{ $options_existentes['social']['vimeo']['icon'] = 'vimeo.png'; }
			if ( !array_key_exists( 'icon', $options_existentes['social']['rss'] ) ) 		{ $options_existentes['social']['rss']['icon'] = 'rss.png'; }


			update_option( 'cd_contact_data', $options_existentes );

		}

	}

}

/**
*	Al desactivar el plugin ¿eliminamos los datos?
*/
function contact_data_on_deactivate() {

	$all_contact_data = maybe_unserialize( get_option( 'cd_contact_data' ) );

	$val = $all_contact_data['config']['clean']['value'];

	if ( $val ){
		delete_option( 'cd_contact_data' );
	}

}

register_activation_hook ( __FILE__, 'contact_data_on_activate' );
register_deactivation_hook ( __FILE__, 'contact_data_on_deactivate' );




// ==============================================================================================================================================================

/**
*	Creamos la página de administración dentro del menú lateral "Settings" (Ajustes).
*	'Settings' -> 'Contact Data'
*/
function cd_contact_data_create_settings_page() {

	$all_contact_data = maybe_unserialize( get_option( 'cd_contact_data' ) );

	$val = $all_contact_data['config']['menu']['value'];

	if ( !$val ){
		$show_as_first_level = true;
	} else {
		$show_as_first_level = false;
	}

		$page_title = 'Contact Data';
		$menu_title = 'Contact Data';
		$capability = 'manage_options';
		$menu_slug 	= 'cd-contact-data';
		$function 	= 'create_cd_contact_data_settings_page';
		$icon_url 	= NULL;
		$position 	= NULL;


	if ( $show_as_first_level ) { 
		// creamos el menú "Contact Data" como un menú item de primer nivel en la sidebar		
		$cd_options_page = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

	} else { 
		// creamos el menú "Contact Data" como un sub-menú del menú Ajustes en la sidebar
		$cd_options_page = add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function ); 
	}



	// add_action('admin_print_styles-' . $cd_options_page, 'cd_contact_data_enqueque');

	add_action( 'admin_enqueue_scripts', 'cd_contact_data_enqueque', 0 );

	//load_plugin_textdomain('contact-data', false, basename( dirname( __FILE__ ) ) . '/languages' );
	load_plugin_textdomain('contact-data', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	//echo basename( dirname( __FILE__ ) ) . '/languages';         --> "company-general-contact-data/languages"
	//echo dirname( plugin_basename( __FILE__ ) ) . '/languages';  --> "company-general-contact-data/languages"

}
add_action('admin_menu', 'cd_contact_data_create_settings_page'); // --> http://codex.wordpress.org/Administration_Menus

// ==============================================================================================================================================================

/**
*	Cargamos los CSS y Javascript necesarios para la página de administración. No la web
*/
function cd_contact_data_enqueque (){

	// wp_enqueue_script( 'jquery-ui-core' );
	// wp_enqueue_script( 'jquery-ui-tabs' );

	wp_register_script('cd_admin_page_scripts', plugins_url('js/cd_admin_page.js', __FILE__), array('jquery','jquery-ui-core','jquery-ui-tabs','jquery-ui-sortable'), '0.3', true);
	wp_enqueue_script('cd_admin_page_scripts');

	wp_register_style('cd_admin_page_styles', plugins_url('css/cd_admin_page.css', __FILE__), array(), '0.2', 'all');
	wp_enqueue_style('cd_admin_page_styles');


	// wp_register_style( 'cd_front_end_styles_icons', plugins_url('css/cd_contact_data_icons.php', __FILE__), array(), '0.4', 'all' );
	// wp_enqueue_style( 'cd_front_end_styles_icons' );

	include 'css/cd_contact_data_icons.php';

}


// ==============================================================================================================================================================

/**
*	Función principal para obtener todos los datos de contacto.
*	- Si se llama sin parámetros devuelve un array con toooodos los campos separados en Grupos, tal y como se guarda en la DB.
*	- Si se le pasa solo el nombre de un Campo devuelve solo ese valor, de cualquier grupo, buscando desde el primer grupo en adelante.
*	- Si se le pasa el nombre de un Campo y el nombre de un Grupo devuelve solo ese valor si existe en ese grupo.
*	- Si se le pasa solo el nombre de un Grupo devuelve ese grupo como un array.
*/
function get_contact_data( $field = NULL, $group = NULL ) {

	$all_contact_data = maybe_unserialize( get_option( 'cd_contact_data' ) );

	if ( !$field && !$group ) :

		return $all_contact_data;

	elseif ( !$field && $group ) :

		return $all_contact_data[$group];

	elseif ( $field && !$group ) :

		foreach ($all_contact_data as $key => $grupo) {

			if ( array_key_exists( $field, $grupo) )
				return  stripslashes( html_entity_decode( $grupo[$field]['value']) );
		}

	elseif ( $field && $group ) :

		return stripslashes( html_entity_decode( $all_contact_data[$group][$field]['value'] ) );

	endif;

}

function the_contact_data( $field = NULL, $group = NULL ) {
	echo get_contact_data( $field, $group );
}


// ==============================================================================================================================================================


/**
*	Ahora creamos la página de administración con el formulario.
*/
function create_cd_contact_data_settings_page() {

	//primero chequeamos que el user tenga la capability necesaria
	if (!current_user_can('manage_options')):
		wp_die( __('You do not have sufficient permissions to access this page.') );
	endif;

	$prefix = 'contact_data_';   // se usa en el nombre de los inputs del form y para localizar los campos dentro de $_POST
	$data_groups_names = array(
		'general',
		'social',
		'config',
		);

	$hidden_field_name = 'submit_hidden';
		
		// --------------------------------------------------------------------------------------------------------

		// Si el usuario le ha dado a 'Guardar cambios' entonces el hidden field traerá este valor. Entonces guardamos los datos en la DB.

		if( isset($_POST[ $hidden_field_name ]) && ( $_POST[ $hidden_field_name ] == 'Y' || $_POST[ $hidden_field_name ] == 'X' ) ) : 

							/*
							$data['name'] =  	htmlspecialchars( $_POST['contact_data_name'] );
							$data['url'] = 		htmlspecialchars( $_POST['contact_data_url'] );
							$data['dir'] = 		htmlspecialchars( $_POST['contact_data_dir'] );
							$data['dir_2'] = 	htmlspecialchars( $_POST['contact_data_dir_2'] );
							$data['email'] = 	htmlspecialchars( $_POST['contact_data_email'] );
							$data['tel'] = 		htmlspecialchars( $_POST['contact_data_tel'] );
							$data['fax'] = 		htmlspecialchars( $_POST['contact_data_fax'] );
							$data['map'] = 		htmlspecialchars( $_POST['contact_data_map']) ;

							$data['facebook'] = htmlspecialchars( $_POST['contact_data_facebook'] );
							$data['twitter'] = 	htmlspecialchars( $_POST['contact_data_twitter'] );
							$data['linkedin'] = htmlspecialchars( $_POST['contact_data_linkedin'] );
							$data['googleplus'] = htmlspecialchars( $_POST['contact_data_googleplus'] );
							$data['youtube'] = 	htmlspecialchars( $_POST['contact_data_youtube'] );
							$data['vimeo'] = 	htmlspecialchars( $_POST['contact_data_vimeo'] );
							$data['rss'] = 		htmlspecialchars( $_POST['contact_data_rss'] );
							*/


							$groups_array = array();


							foreach ($data_groups_names as $data_group_name) {

								$groups_array[$data_group_name] = array();

								$group_prefix = $prefix . $data_group_name . '_';



								if ( $_POST[ $hidden_field_name ] == 'X' ) :  // solo se ejecuta cuando guardamos los datos

										foreach ($_POST as $key => $value) {

											if( strpos( $key, $group_prefix ) !== false ){

												// $key es por ejemplo --> 'contact_data_general_name_xhint_0'
												// $group_prefix es por ejemplo --> 'contact_data_general_'


												$field = str_replace( $group_prefix, '', $key );  // $group_prefix = 'contact_data_social_'
												// eliminamos el texto $group_prefix ('contact_data_general_') del nombre de la variable para usarlo como nombre del campo al guardar este valor
												// obtenemos 'url_xlabel_0'


												$last_underscore = strrpos( $field , '_' );
												
												$field = substr( $field, 0, $last_underscore); // nos queda 'url_xlabel'

												$last_underscore = strrpos( $field , '_' );
												$sub_field = substr( $field, $last_underscore+2); // todo lo que viene después del útimo guión bajo mas una posición
												// nos queda de 'url_xlabel' --->  'label'

												$field = substr( $field, 0, $last_underscore); // comenzando por el caracter 0 tomamos $last_underscore caracteres
												 // nos queda 'url'
												

												//trace ( '$field : ' . $field );
												//trace ( '$sub_field : ' . $sub_field );
												//trace ( '$value : ' . $value );
												//echo '-------------';


												if( !array_key_exists ( $field, $groups_array[$data_group_name] ) ) {
													$groups_array[$data_group_name][$field] = array();
												}

												$groups_array[$data_group_name][$field][$sub_field] = htmlspecialchars ( $value );

											}

										}

								endif;
							}

							//trace ( $groups_array , '$groups_array' );

							update_option( 'cd_contact_data', $groups_array );


			?>

			<div class="updated">
				<p><strong><?php _e('Contact data saved.', 'contact-data') ?></strong></p>
			</div>

			<?php
			
		endif;

		// --------------------------------------------------------------------------------------------------------

		$data = get_contact_data(); // obtenemos todos los campos de contacto en un array.

		// trace( $data, 'get_contact_data()' );
		
		?>


		<div class="wrap">

			<div id="icon-index" class="icon32"><br></div>
			
			<h2>Contact Data</h2>

			<div id="tabs">

				<h2 class="nav-tab-wrapper">
					<ul class="tabNavigation">
						<li><a href="#tab1" class="nav-tab"><?php _e('The contact data', 'contact-data') ?></a></li>
						<?php /* <li><a href="#tab2" class="nav-tab"><?php _e('Fields manager', 'contact-data') ?></a></li> */ ?>
						<li><a href="#tab3" class="nav-tab"><?php _e('Usage', 'contact-data') ?></a></li>
						<li><a href="#tab4" class="nav-tab"><?php _e('Structure', 'contact-data') ?></a></li>
					</ul>
				</h2>


				<div id="tab1">

					<?php include ('data-form.php'); ?>

				</div><!-- #tab1 -->

<?php /* 
				<div id="tab2">

					<?php include ('data-manage.php'); ?>

				</div><!-- #tab2 -->
*/ ?>


				<div id="tab3">

					<?php include ('data-usage.php'); ?>

				</div><!-- #tab3 -->


				<div id="tab4">

					<?php include ('data-structure.php'); ?>

				</div><!-- #tab3 -->


			</div>

		</div>
						
<?php
}

// ==============================================================================================================================================================


/**
 * Social Icons widget class
 */
class WP_Widget_Follow_Me_Icons extends WP_Widget {

        function __construct() {
                $widget_ops = array('classname' => 'widget_follow_me_icons', 'description' => __( "Displays the 'Follow Me' buttons of those social networks you defined") );
                parent::__construct('follow_me_icons', __('Follow Me Icons'), $widget_ops);
        }

        function widget( $args, $instance ) {

                extract($args);

                $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	
				$data = get_contact_data();

                echo $before_widget;
                if ( $title )
                        echo $before_title . $title . $after_title;
                // ------------------------------------------------------------
				
				follow_me_icons();

                // ------------------------------------------------------------
                echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
                $instance['title'] = strip_tags($new_instance['title']);
                return $instance;
        }

        function form( $instance ) {
                $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
                $title = $instance['title'];
		?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'contact-data'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
        }
}

add_action( 'widgets_init', create_function('', 'return register_widget("WP_Widget_Follow_Me_Icons");') );



// ==============================================================================================================================================================


function follow_me_icons( $los_args = NULL ){



	extract( shortcode_atts(array(
		'align'     => 'center',
		'size'      => '32',
		'theme'     => get_contact_data('theme', 'config'),
		'alternate' => get_contact_data('alternate', 'config'),
		'echo'      => true,
		), $los_args) );
	



	$salida = '';
	$data = get_contact_data();

	
	wp_register_style( 'cd_front_end_styles', plugins_url('css/cd_contact_data.css', __FILE__), array(), '1.0', 'all' );
	wp_enqueue_style( 'cd_front_end_styles' );
	
	$icons_theme_css  = 'cd_front_end_styles_' . $theme;
	$icons_theme_path = 'icons/' . $theme . '/style.css';

	wp_register_style( $icons_theme_css, plugins_url($icons_theme_path, __FILE__), array(), $theme, 'all' );
	wp_enqueue_style( $icons_theme_css );

	//wp_register_style( 'cd_front_end_styles_icons', plugins_url('css/cd_contact_data_icons.php', __FILE__), array(), '0.4', 'all' );
	//wp_enqueue_style( 'cd_front_end_styles_icons' );

	include 'css/cd_contact_data_icons.php';


	if( !empty( $data['social'] ) ) :

			$salida .= '<div class="follow_me_icons_container ' . $align . ' size' . $size . ' ' . $theme . '">';

				$salida .= '<ul>';

					foreach ($data['social'] as $key => $value) :
						if ( $value['value'] ) :

								$anchor_class  = 'class="' . $value['anchorclass'] . '"';
								$anchor_id     = 'id="' . $value['anchorid'] . '"';
								$anchor_target = 'target="' . $value['anchortarget'] . '"';
								
								if ( $value['anchortitle'] ) {
									$anchor_title =  'title="' . $value['anchortitle'] . '"';
								}else{
									$anchor_title =  'title="' . $value['label'] . '"';
								}
								$anchor_rel =  'rel="author"';
								$anchor_href =  'href="' . $value['value'] . '"';


								$salida .= '<li class="social ' . $value['name'] . '"><a ' . $anchor_id . ' ' . $anchor_class . ' ' . $anchor_href . ' ' . $anchor_target . ' ' . $anchor_title . ' ' . $anchor_rel . '></a></li>';
						endif;
					endforeach;

				$salida .= '</ul>';

			$salida .= '</div>';

			if ( $echo ) :
				echo $salida; // para usar con el shortcode [follow-me-icons]
				// trace ($data['social']);
			else:
				return $salida; // para usar mediante la función follow_me_icons();
			endif;

	endif;
}


function follow_us_icons( $args = NULL ){
	follow_me_icons( $args );
}


// ==============================================================================================================================================================


function do_contact_data($atts) {
	extract(shortcode_atts(array(
		'field' => NULL,
		'group' => NULL,
	), $atts));

	if (! $field ) return;

	return get_contact_data( $field, $group );
}
add_shortcode('contact-data', 'do_contact_data');



function do_follow_me_icons($atts) {
	extract(shortcode_atts(array(
		'field'     => NULL,
		'size'      => '32',
		'theme'     => 'plastic',
		'alternate' => false,
		'align'     => 'center',
		'class'     => '',
	), $atts));

	$args = array(
		'echo'      => false,
		'size'      => $size,
		'theme'     => $theme,
		'align'     => $align,
		'alternate' => $alternate,
		'class'     => $class,
		);

	return follow_me_icons( $args );
}


add_shortcode('follow-me-icons', 'do_follow_me_icons');
add_shortcode('follow-us-icons', 'do_follow_me_icons');


// ==============================================================================================================================================================





// ==============================================================================================================================================================

// self hosting setings

// ==============================================================================================================================================================

//Comment out these two lines during testing.
set_site_transient('update_plugins', null);

//
// "ccd" = prefix de "cuadric contact data".
//


$cuadric_plugins_api_url = 'http://www.cuadric.com/plugins/api/';

$ccd_plugin_slug = basename(dirname(__FILE__));


// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'ccd_check_for_plugin_update');

function ccd_check_for_plugin_update($checked_data) {
	global $cuadric_plugins_api_url, $ccd_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked)) {
		return $checked_data;
	}
	
	$args = array(
		'slug' => $ccd_plugin_slug,
		'version' => $checked_data->checked[$ccd_plugin_slug .'/'. $ccd_plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$raw_response = wp_remote_post($cuadric_plugins_api_url, $request_string);
	
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$ccd_plugin_slug .'/'. $ccd_plugin_slug .'.php'] = $response;
	

	return $checked_data;
}


// Take over the Plugin info screen
add_filter('plugins_api', 'ccd_plugin_api_call', 10, 3);

function ccd_plugin_api_call($def, $action, $args) {
	global $cuadric_plugins_api_url, $ccd_plugin_slug, $wp_version;
	
	if ( $args->slug != $ccd_plugin_slug ) {
		return false;
	}
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$ccd_plugin_slug .'/'. $ccd_plugin_slug .'.php'];
	$args->version = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($cuadric_plugins_api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}

// ==============================================================================================================================================================