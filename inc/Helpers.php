<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;

if ( ! function_exists( 'dd' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function dd() {
		echo '<pre>';
		array_map( function ( $x ) {
			var_dump( $x );
		}, func_get_args() );
		echo '</pre>';
		die;
	}
}

if ( ! function_exists( 'starts_with' ) ) {
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param string $haystack
	 * @param string|array $needles
	 *
	 * @return bool
	 */
	function starts_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( $needle != '' && substr( $haystack, 0, strlen( $needle ) ) === (string) $needle ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'mix' ) ) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param string $path
	 * @param string $manifestDirectory
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	function mix( $path, $manifestDirectory = '' ): string {
		if ( ! $manifestDirectory ) {
			//Setup path for standard AWPS-Folder-Structure
			$manifestDirectory = "assets/dist/";
		}
		static $manifest;
		if ( ! starts_with( $path, '/' ) ) {
			$path = "/{$path}";
		}
		if ( $manifestDirectory && ! starts_with( $manifestDirectory, '/' ) ) {
			$manifestDirectory = "/{$manifestDirectory}";
		}
		$rootDir = dirname( __FILE__, 2 );
		if ( file_exists( $rootDir . '/' . $manifestDirectory . '/hot' ) ) {
			return getenv( 'WP_SITEURL' ) . ":8080" . $path;
		}
		if ( ! $manifest ) {
			$manifestPath = $rootDir . $manifestDirectory . 'mix-manifest.json';
			if ( ! file_exists( $manifestPath ) ) {
				throw new Exception( 'The Mix manifest does not exist.' );
			}
			$manifest = json_decode( file_get_contents( $manifestPath ), true );
		}

		if ( starts_with( $manifest[ $path ], '/' ) ) {
			$manifest[ $path ] = ltrim( $manifest[ $path ], '/' );
		}

		$path = $manifestDirectory . $manifest[ $path ];

		return get_template_directory_uri() . $path;
	}
}

function newsfit_html( $html, $checked = true ) {
	$allowed_html = [
		'a'      => [
			'href'   => [],
			'title'  => [],
			'class'  => [],
			'target' => [],
		],
		'br'     => [],
		'span'   => [
			'class' => [],
			'id'    => [],
		],
		'em'     => [],
		'strong' => [],
		'i'      => [
			'class' => []
		],
		'iframe' => [
			'class'                 => [],
			'id'                    => [],
			'name'                  => [],
			'src'                   => [],
			'title'                 => [],
			'frameBorder'           => [],
			'width'                 => [],
			'height'                => [],
			'scrolling'             => [],
			'allowvr'               => [],
			'allow'                 => [],
			'allowFullScreen'       => [],
			'webkitallowfullscreen' => [],
			'mozallowfullscreen'    => [],
			'loading'               => [],
		],
	];

	if ( $checked ) {
		return wp_kses( $html, $allowed_html );
	} else {
		return $html;
	}
}

if ( ! function_exists( 'newsfit_custom_menu_cb' ) ) {
	/**
	 * Callback function for the main menu
	 *
	 * @param $args
	 *
	 * @return string|void
	 */
	function newsfit_custom_menu_cb( $args ) {
		$add_menu_link = admin_url( 'nav-menus.php' );
		$menu_text     = __( 'Add a menu', 'newsfit' );
		if ( ! current_user_can( 'manage_options' ) ) {
			$add_menu_link = home_url();
			$menu_text     = __( 'Home', 'newsfit' );
		}

		// see wp-includes/nav-menu-template.php for available arguments
		extract( $args );

		$link = $link_before . '<a href="' . $add_menu_link . '">' . $before . $menu_text . $after . '</a>' . $link_after;

		// We have a list
		if ( false !== stripos( $items_wrap, '<ul' ) || false !== stripos( $items_wrap, '<ol' ) ) {
			$link = "<li>$link</li>";
		}

		$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
		if ( ! empty ( $container ) ) {
			$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
		}

		if ( $echo ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'newsfit_require' ) ) {
	/**
	 * Require any file. If the file will available in the child theme, the file will load from the child theme
	 *
	 * @param $filename
	 * @param string $dir
	 *
	 * @return false|void
	 */
	function newsfit_require( $filename, string $dir = 'inc' ) {

		$dir        = trailingslashit( $dir );
		$child_file = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $dir . $filename;

		if ( file_exists( $child_file ) ) {
			$file = $child_file;
		} else {
			$file = get_template_directory() . DIRECTORY_SEPARATOR . $dir . $filename;
		}

		if ( file_exists( $file ) ) {
			require_once $file;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'newsfit_get_svg' ) ) {
	/**
	 * Get svg icon
	 *
	 * @param $name
	 *
	 * @return string|void
	 */
	function newsfit_get_svg( $name, $color = '#212121' ) {

		$svg_list = apply_filters( 'newsfit_svg_icon_list', [
			'search'    => '<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.3946 21.8517L17.0516 17.5087M17.0516 17.5087C17.7945 16.7658 18.3838 15.8839 18.7859 14.9133C19.1879 13.9426 19.3949 12.9023 19.3949 11.8517C19.3949 10.8011 19.1879 9.7608 18.7859 8.79017C18.3838 7.81954 17.7945 6.9376 17.0516 6.19472C16.3088 5.45183 15.4268 4.86254 14.4562 4.46049C13.4856 4.05844 12.4452 3.85151 11.3946 3.85151C10.344 3.85151 9.30373 4.05844 8.3331 4.46049C7.36247 4.86254 6.48053 5.45183 5.73765 6.19472C4.23732 7.69504 3.39444 9.72993 3.39444 11.8517C3.39444 13.9735 4.23732 16.0084 5.73765 17.5087C7.23798 19.009 9.27286 19.8519 11.3946 19.8519C13.5164 19.8519 15.5513 19.009 17.0516 17.5087Z" stroke="var(--newsfit-icon-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 155.139 155.139" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M89.584 155.139V84.378h23.742l3.562-27.585H89.584V39.184c0-7.984 2.208-13.425 13.67-13.425l14.595-.006V1.08C115.325.752 106.661 0 96.577 0 75.52 0 61.104 12.853 61.104 36.452v20.341H37.29v27.585h23.814v70.761h28.48z" style="" fill="var(--newsfit-icon-color)" data-original="var(--newsfit-icon-color)" class=""></path></g></svg>',
			'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 1226.37 1226.37" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M727.348 519.284 1174.075 0h-105.86L680.322 450.887 370.513 0H13.185l468.492 681.821L13.185 1226.37h105.866l409.625-476.152 327.181 476.152h357.328L727.322 519.284zM582.35 687.828l-47.468-67.894-377.686-540.24H319.8l304.797 435.991 47.468 67.894 396.2 566.721H905.661L582.35 687.854z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class="hovered-path"></path></g></svg>',
			'skype'     => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M374 512c-27.852 0-54.324-8.11-77.125-23.547-73.871 12.914-151.434-9.258-207.754-65.574-56.293-56.297-78.492-133.852-65.574-207.754C8.109 192.325 0 165.852 0 138 0 61.906 61.906 0 138 0c27.852 0 54.324 8.11 77.125 23.547C376.152-4.602 516.707 135.262 488.453 296.875 503.891 319.675 512 346.148 512 374c0 76.094-61.906 138-138 138zm-60.133-60.617C331.195 464.87 351.988 472 374 472c54.035 0 98-43.96 98-98 0-22.012-7.129-42.805-20.617-60.133a19.985 19.985 0 0 1-3.77-16.484c29.985-139.59-94.375-262.778-232.996-232.996a20.002 20.002 0 0 1-16.484-3.77C180.805 47.13 160.012 40 138 40c-54.035 0-98 43.96-98 98 0 22.012 7.129 42.805 20.617 60.133a19.985 19.985 0 0 1 3.77 16.484c-29.918 139.278 94.05 262.844 232.996 232.996a19.995 19.995 0 0 1 16.484 3.77zM354.668 315c0-54.008-68.277-70.516-83.559-75.207-31.656-9.715-73.777-20.547-73.777-42.793 0-21.14 26.867-39 58.668-39 25.3 0 48.367 11.457 56.098 27.86 4.71 9.988 16.629 14.273 26.62 9.562 9.989-4.711 14.27-16.625 9.563-26.617C332.543 135.418 293.406 118 256 118c-58.195 0-98.668 37.844-98.668 79 0 54.008 68.277 70.516 83.559 75.207 31.656 9.715 73.777 20.547 73.777 42.793 0 21.14-26.867 39-58.668 39-25.3 0-48.367-11.457-56.098-27.86-4.71-9.988-16.629-14.273-26.62-9.562-9.989 4.711-14.27 16.625-9.563 26.617C179.457 376.582 218.594 394 256 394c58.195 0 98.668-37.844 98.668-79zm0 0" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path></g></svg>',
			'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M23.994 24v-.001H24v-8.802c0-4.306-.927-7.623-5.961-7.623-2.42 0-4.044 1.328-4.707 2.587h-.07V7.976H8.489v16.023h4.97v-7.934c0-2.089.396-4.109 2.983-4.109 2.549 0 2.587 2.384 2.587 4.243V24zM.396 7.977h4.976V24H.396zM2.882 0C1.291 0 0 1.291 0 2.882s1.291 2.909 2.882 2.909 2.882-1.318 2.882-2.909A2.884 2.884 0 0 0 2.882 0z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path></g></svg>',
			'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M12 2.162c3.204 0 3.584.012 4.849.07 1.308.06 2.655.358 3.608 1.311.962.962 1.251 2.296 1.311 3.608.058 1.265.07 1.645.07 4.849s-.012 3.584-.07 4.849c-.059 1.301-.364 2.661-1.311 3.608-.962.962-2.295 1.251-3.608 1.311-1.265.058-1.645.07-4.849.07s-3.584-.012-4.849-.07c-1.291-.059-2.669-.371-3.608-1.311-.957-.957-1.251-2.304-1.311-3.608-.058-1.265-.07-1.645-.07-4.849s.012-3.584.07-4.849c.059-1.296.367-2.664 1.311-3.608.96-.96 2.299-1.251 3.608-1.311 1.265-.058 1.645-.07 4.849-.07M12 0C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.668 3.36.157 5.198.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.853.603 3.7 1.942 5.038 1.345 1.345 3.186 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 1.854-.085 3.698-.602 5.038-1.942 1.347-1.347 1.857-3.184 1.942-5.038.058-1.28.072-1.689.072-4.948 0-3.259-.014-3.668-.072-4.948-.085-1.855-.602-3.698-1.942-5.038C20.643.671 18.797.156 16.948.072 15.668.014 15.259 0 12 0z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path><path d="M12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path><circle cx="18.406" cy="5.594" r="1.44" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></circle></g></svg>',
			'pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M12.326 0C5.747.001 2.25 4.216 2.25 8.812c0 2.131 1.191 4.79 3.098 5.633.544.245.472-.054.94-1.844a.425.425 0 0 0-.102-.417c-2.726-3.153-.532-9.635 5.751-9.635 9.093 0 7.394 12.582 1.582 12.582-1.498 0-2.614-1.176-2.261-2.631.428-1.733 1.266-3.596 1.266-4.845 0-3.148-4.69-2.681-4.69 1.49 0 1.289.456 2.159.456 2.159S6.781 17.4 6.501 18.539c-.474 1.928.064 5.049.111 5.318.029.148.195.195.288.073.149-.195 1.973-2.797 2.484-4.678.186-.685.949-3.465.949-3.465.503.908 1.953 1.668 3.498 1.668 4.596 0 7.918-4.04 7.918-9.053C21.733 3.596 17.62 0 12.326 0z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path></g></svg>',
			'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M22.465 9.866a9.809 9.809 0 0 1-5.74-1.846v8.385c0 4.188-3.407 7.594-7.594 7.594a7.548 7.548 0 0 1-4.352-1.376 7.59 7.59 0 0 1-3.242-6.218c0-4.188 3.407-7.595 7.595-7.595.348 0 .688.029 1.023.074v4.212a3.426 3.426 0 0 0-1.023-.16 3.472 3.472 0 0 0-3.468 3.469 3.47 3.47 0 0 0 3.469 3.468 3.47 3.47 0 0 0 3.462-3.338L12.598 0h4.126a5.752 5.752 0 0 0 5.74 5.741v4.125z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class="hovered-path"></path></g></svg>',
			'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><defs><clipPath id="a" clipPathUnits="userSpaceOnUse"><path d="M0 512h512V0H0Z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)"></path></clipPath></defs><path d="m0 0 130 74L0 148Z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="matrix(1.33333 0 0 -1.33333 269.333 440)" fill="none" stroke="var(--newsfit-icon-color)" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="var(--newsfit-icon-color)" class=""></path><g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M0 0c0-39.49-3.501-75.479-7.497-103.698-5.191-36.655-34.801-64.96-71.646-68.567C-118.236-176.092-173.471-180-236-180c-62.529 0-117.764 3.908-156.857 7.735-36.845 3.607-66.455 31.912-71.646 68.567C-468.499-75.479-472-39.49-472 0c0 39.49 3.501 75.479 7.497 103.698 5.191 36.655 34.801 64.96 71.646 68.567C-353.764 176.092-298.529 180-236 180c62.529 0 117.764-3.908 156.857-7.735 36.845-3.607 66.455-31.912 71.646-68.567C-3.501 75.479 0 39.49 0 0Z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(492 255.75)" fill="none" stroke="var(--newsfit-icon-color)" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="var(--newsfit-icon-color)" class=""></path></g></g></svg>',
			'snapchat'  => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M23.914 17.469c-.167-.454-.484-.697-.846-.898a2.288 2.288 0 0 0-.184-.097c-.108-.056-.218-.11-.328-.166-1.127-.598-2.008-1.352-2.619-2.246a5.162 5.162 0 0 1-.45-.797c-.052-.149-.049-.233-.012-.311a.49.49 0 0 1 .144-.15l.529-.346c.241-.157.433-.28.556-.368.463-.324.787-.668.989-1.052a2.097 2.097 0 0 0 .104-1.74c-.307-.807-1.069-1.308-1.992-1.308a2.811 2.811 0 0 0-.73.097 17.3 17.3 0 0 0-.053-1.708c-.174-2.016-.88-3.072-1.616-3.915a6.418 6.418 0 0 0-1.643-1.322C14.647.505 13.38.181 12 .181s-2.64.324-3.758.961a6.427 6.427 0 0 0-1.646 1.325c-.736.842-1.442 1.901-1.616 3.915a17.308 17.308 0 0 0-.053 1.707l-.15-.036a2.76 2.76 0 0 0-.58-.061c-.924 0-1.687.501-1.993 1.308a2.097 2.097 0 0 0 .101 1.742c.203.385.526.728.99 1.052.123.086.315.21.556.368l.508.332a.531.531 0 0 1 .163.164c.039.081.04.167-.018.326a5.034 5.034 0 0 1-.442.78c-.597.876-1.452 1.616-2.543 2.209-.578.307-1.179.511-1.433 1.201-.192.521-.067 1.113.42 1.612.178.186.385.343.613.464.474.26.978.462 1.5.6.108.028.21.074.303.136.177.155.152.389.388.731a1.7 1.7 0 0 0 .444.451c.495.342 1.052.363 1.642.386.533.02 1.137.044 1.827.271.286.094.583.277.927.491.826.508 1.957 1.202 3.849 1.202 1.892 0 3.031-.698 3.863-1.208.342-.21.637-.391.915-.483.69-.228 1.294-.251 1.827-.271.59-.022 1.147-.044 1.642-.386a1.7 1.7 0 0 0 .505-.552c.17-.289.165-.491.325-.632a.932.932 0 0 1 .285-.13 6.662 6.662 0 0 0 1.521-.606c.242-.129.46-.3.644-.504l.006-.008c.454-.486.569-1.061.382-1.569zm-1.324.577c-.03.093-.133.202-.358.327-1.026.567-1.708.506-2.238.848-.197.127-.257.318-.289.512-.014.08-.022.161-.034.238-.025.161-.063.305-.188.391-.402.278-1.591-.019-3.127.488-1.267.419-2.075 1.623-4.353 1.623-2.279 0-3.068-1.202-4.356-1.626-1.533-.507-2.724-.21-3.128-.487-.327-.225-.061-.851-.511-1.141-.531-.341-1.213-.281-2.238-.844-.33-.182-.398-.329-.358-.443 0-.003.001-.005.003-.008.043-.109.184-.188.29-.239 1.742-.843 2.798-1.902 3.43-2.809.127-.182.236-.357.331-.524.442-.778.562-1.36.574-1.45.032-.249.067-.446-.208-.699-.265-.246-1.443-.975-1.77-1.203-.223-.156-.454-.343-.578-.592-.27-.541.153-1.068.71-1.068.099 0 .198.012.295.033.593.129 1.17.426 1.503.506.22.053.364-.047.351-.276-.038-.65-.13-1.915-.028-3.098a6.24 6.24 0 0 1 .381-1.721c.206-.529.535-1.001.906-1.426.3-.343 1.705-1.828 4.395-1.828 2.1 0 3.42.903 4.04 1.461.989.909 1.533 2.18 1.645 3.507.102 1.183.014 2.449-.028 3.098-.014.221.141.33.351.277.334-.081.91-.378 1.504-.507.438-.095.946.039 1.066.521.099.413-.141.759-.638 1.106-.327.228-1.505.956-1.77 1.202-.275.254-.239.45-.207.7.015.116.203 1.022 1.003 2.113l.002.002a7.623 7.623 0 0 0 .733.856c.624.628 1.466 1.266 2.597 1.812.093.045.2.101.261.187a.2.2 0 0 1 .034.181z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class="hovered-path"></path></g></svg>',
			'whatsapp'  => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M20.463 3.488A11.817 11.817 0 0 0 12.05 0C5.495 0 .16 5.334.157 11.892a11.87 11.87 0 0 0 1.588 5.946L.057 24l6.304-1.654a11.88 11.88 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.817 11.817 0 0 0-3.479-8.413zM12.05 21.785h-.004a9.86 9.86 0 0 1-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374a9.855 9.855 0 0 1-1.511-5.26c.002-5.45 4.437-9.884 9.889-9.884 2.64 0 5.122 1.03 6.988 2.898a9.827 9.827 0 0 1 2.892 6.993c-.003 5.452-4.437 9.886-9.885 9.886zm5.422-7.403c-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.148s-.767.967-.941 1.166c-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059s-.018-.458.13-.606c.134-.133.297-.347.446-.521.15-.172.199-.296.299-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.241-.58-.486-.501-.669-.51-.173-.009-.371-.01-.57-.01-.198 0-.52.074-.792.372s-1.04 1.017-1.04 2.479c0 1.463 1.065 2.876 1.213 3.074.148.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.29.173-1.413-.074-.125-.272-.199-.569-.348z" style="fill-rule:evenodd;clip-rule:evenodd;" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class=""></path></g></svg>',
			'reddit'    => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M9.25 14.5c-.689 0-1.25-.561-1.25-1.25S8.561 12 9.25 12s1.25.561 1.25 1.25-.561 1.25-1.25 1.25zM14.97 16.095a.324.324 0 0 1 0 .458c-.853.852-2.488.918-2.969.918-.481 0-2.116-.066-2.968-.918a.323.323 0 0 1 0-.458.323.323 0 0 1 .458 0c.538.538 1.688.728 2.51.728.822 0 1.972-.191 2.511-.729a.324.324 0 0 1 .458.001zM16 13.25a1.251 1.251 0 0 1-2.5 0c0-.689.561-1.25 1.25-1.25s1.25.561 1.25 1.25z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class="hovered-path"></path><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm6.957 13.599c.027.173.041.348.041.526 0 2.692-3.134 4.875-7 4.875s-7-2.183-7-4.875c0-.179.015-.355.042-.529a1.75 1.75 0 0 1 .716-3.346c.47 0 .896.186 1.21.488 1.212-.873 2.886-1.431 4.749-1.483l.89-4.185a.312.312 0 0 1 .37-.241l2.908.618A1.249 1.249 0 1 1 17 7.25c-.67 0-1.213-.529-1.244-1.191l-2.604-.554-.797 3.75c1.836.064 3.484.622 4.68 1.485a1.75 1.75 0 1 1 1.922 2.859z" fill="var(--newsfit-icon-color)" opacity="1" data-original="var(--newsfit-icon-color)" class="hovered-path"></path></g></svg>',
		] );

		if ( isset( $svg_list[ $name ] ) ) {
			return "<span style='--newsfit-icon-color:{$color}' class='rticon-{$name}'>{$svg_list[ $name ]}</span>";
		}

		return '';
	}
}

if ( ! function_exists( 'newsfit_get_file' ) ) {
	/**
	 * Get File Path
	 *
	 * @param $path
	 *
	 * @return string
	 */
	function newsfit_get_file( $path ): string {
		$file = get_stylesheet_directory_uri() . $path;
		if ( ! file_exists( $file ) ) {
			$file = get_template_directory_uri() . $path;
		}

		return $file;
	}
}

if ( ! function_exists( 'newsfit_get_img' ) ) {
	/**
	 * Get Image Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_img( $filename ): string {
		$path = '/assets/dist/images/' . $filename;

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_get_css' ) ) {
	/**
	 * Get CSS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_css( $filename ) {
		$path = '/assets/dist/css/' . $filename . '.css';

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_get_js' ) ) {
	/**
	 * Get JS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_js( $filename ) {
		$path = '/assets/dist/js/' . $filename . '.js';

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_maybe_rtl' ) ) {
	/**
	 * Get css path conditionally by RTL
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_maybe_rtl( $filename ) {
		if ( is_rtl() ) {
			$path = '/assets/dist/css-rtl/' . $filename . '.css';

			return newsfit_get_file( $path );
		} else {
			return newsfit_get_file( $filename );
		}
	}
}


if ( ! function_exists( 'newsfit_option' ) ) {
	/**
	 * Get Customize Options value by key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	function newsfit_option( $key, $echo = false ): mixed {
		if ( isset( Opt::$options[ $key ] ) ) {
			if ( $echo ) {
				echo newsfit_html( Opt::$options[ $key ] );
			} else {
				return Opt::$options[ $key ];
			}
		}

		return false;
	}
}

if ( ! function_exists( 'newsfit_get_socials' ) ) {
	/**
	 * Get Social icon list
	 * @return mixed|null
	 */
	function newsfit_get_socials(): mixed {
		return apply_filters( 'newsfit_socials_icon', [
			'facebook'  => [
				'title' => __( 'Facebook', 'newsfit' ),
				'url'   => newsfit_option( 'facebook' ),
			],
			'twitter'   => [
				'title' => __( 'Twitter', 'newsfit' ),
				'url'   => newsfit_option( 'twitter' ),
			],
			'linkedin'  => [
				'title' => __( 'Linkedin', 'newsfit' ),
				'url'   => newsfit_option( 'linkedin' ),
			],
			'youtube'   => [
				'title' => __( 'Youtube', 'newsfit' ),
				'url'   => newsfit_option( 'youtube' ),
			],
			'pinterest' => [
				'title' => __( 'Pinterest', 'newsfit' ),
				'url'   => newsfit_option( 'pinterest' ),
			],
			'instagram' => [
				'title' => __( 'Instagram', 'newsfit' ),
				'url'   => newsfit_option( 'instagram' ),
			],
			'skype'     => [
				'title' => __( 'Skype', 'newsfit' ),
				'url'   => newsfit_option( 'skype' ),
			],
		] );

	}
}

if ( ! function_exists( 'newsfit_get_social_html' ) ) {
	/**
	 * Get Social markup
	 *
	 * @param $color
	 *
	 * @return void
	 */

	function newsfit_get_social_html( $color = '' ): void {
		ob_start();
		foreach ( newsfit_get_socials() as $id => $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			?>
			<a target="_blank" href="<?php echo esc_url( $item['url'] ) ?>">
				<?php echo newsfit_get_svg( $id, $color ); ?>
			</a>
			<?php
		}

		echo ob_get_clean();
	}
}

if ( ! function_exists( 'newsfit_site_logo' ) ) {
	/**
	 * Newfit Site Logo
	 *
	 */
	function newsfit_site_logo() {
		$rt_logo         = newsfit_option( 'rt_logo' );
		$rt_logo_light   = newsfit_option( 'rt_logo_light' );
		$rt_logo_mobile  = newsfit_option( 'rt_logo_mobile' );
		$site_logo       = Opt::$has_tr_header ? $rt_logo_light : $rt_logo;
		$has_mobile_logo = ! empty( $rt_logo_mobile ) ? 'has-mobile-logo' : '';
		ob_start();
		?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="<?php echo esc_attr( $has_mobile_logo ) ?>">
			<?php
			if ( ! empty( $site_logo ) ) {
				echo wp_get_attachment_image( $site_logo, 'full', null, [ 'class' => 'site-logo' ] );
				if ( ! empty( $rt_logo_mobile ) ) {
					echo wp_get_attachment_image( $rt_logo_mobile, 'full', null, [ 'class' => 'site-logo' ] );
				}
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'newsfit_sidebar_lists' ) ) {
	/**
	 * Get Sidebar lists
	 * @return array
	 */
	function newsfit_sidebar_lists(): array {
		$sidebar_fields            = [];
		$sidebar_fields['sidebar'] = esc_html__( 'Sidebar', 'newsfit' );
		if ( class_exists( 'WooCommerce' ) ) {
			$sidebar_fields['woocommerce-archive-sidebar'] = esc_html__( 'WooCommerce Archive Sidebar', 'newsfit' );
			$sidebar_fields['woocommerce-single-sidebar']  = esc_html__( 'WooCommerce Single Sidebar', 'newsfit' );
		}
		$sidebars = get_option( "newsfit_custom_sidebars", [] );
		if ( $sidebars ) {
			foreach ( $sidebars as $sidebar ) {
				$sidebar_fields[ $sidebar['id'] ] = $sidebar['name'];
			}
		}

		return $sidebar_fields;
	}
}


if ( ! function_exists( 'newsfit_header_presets' ) ) {
	/**
	 * Get header presets
	 * @return array
	 */
	function newsfit_header_presets(): array {
		return apply_filters( 'newsfit_header_presets', [
			'1' => [
				'image' => newsfit_get_img( 'header-1.png' ),
				'name'  => __( 'Style 1', 'newsfit' ),
			],
			'2' => [
				'image' => newsfit_get_img( 'header-2.png' ),
				'name'  => __( 'Style 2', 'newsfit' ),
			],
			'3' => [
				'image' => newsfit_get_img( 'header-3.png' ),
				'name'  => __( 'Style 3', 'newsfit' ),
			],
		] );
	}
}
