<?php

// $data = get_contact_data();
// $data = maybe_unserialize( get_option( 'cd_contact_data' ) );  // viene desde la función follow_me_icons();
// $data = get_option();



$chus = '';
// $data = get_contact_data();  	viene desde la función follow_me_icons();
// $size 		 					viene desde la función follow_me_icons();
// $theme 							viene desde la función follow_me_icons();
// $alternate 						viene desde la función follow_me_icons();


if( !$size) { 
	$size = 32;
}
$multiplicador = 4;

switch( $size ){
	case 16: $multiplicador = 8; break;
	case 20: $multiplicador = 7; break;
	case 24: $multiplicador = 6; break;
	case 28: $multiplicador = 5; break;
	case 32: $multiplicador = 4; break;
	case 36: $multiplicador = 3; break;
	case 40: $multiplicador = 2; break;
	case 44: $multiplicador = 1; break;
	case 48: $multiplicador = 0; break;
}
$desplazamiento = -(52 * $multiplicador);

/*
if ( !$theme ) {
	$theme = get_contact_data('theme', 'config');
}
*/

//$relative_path = '../icons/'. $theme;
$relative_path = plugins_url('icons/'.$theme, dirname(__FILE__));


if( $alternate ){
	$out_position = 'bottom';
	$hover_position = 'top';
} else {
	$out_position = 'top';
	$hover_position = 'bottom';
}


$chus .= '
.follow_me_icons_container.size' . $size . ' a {
	width:' . $size . 'px !important;
	height:' . $size . 'px !important;
	padding: 0 !important;
}';
$chus .= '
	.follow_me_icons_container a,
	.follow_me_icons_container a:hover {
		background-color: transparent !important;
		-webkit-transition:none !important;
		-moz-transition:none !important;
		-ms-transition:none !important;
		-o-transition:none !important;
		transition:none !important;
	}';
$chus .= '
	.follow_me_icons_container.size' . $size . ' a:hover {
		background-position: '. $desplazamiento . 'px ' . $hover_position . ' !important;
		-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		filter: alpha(opacity=100);
		opacity:1;
	}';


if( !empty( $data['social'] ) ) :




					foreach ( $data['social'] as $key => $value ) :
						if ( $value['value'] ) :
								$chus .= '
									.follow_me_icons_container.size' . $size . ' .' . $value['name'] . ' a {
										background-color:transparent !important;
										background-image: url(' . $relative_path . '/' . $value['icon'] . ') !important;
										background-repeat: no-repeat !important;
										background-position: ' .  $desplazamiento . 'px ' . $out_position . ';
									}';
						endif;
					endforeach;



endif;




// header('content-type: text/css; charset=utf-8');
$salida .= '<style>';
	$salida .= $chus;
$salida .= '</style>';