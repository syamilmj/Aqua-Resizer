<?php
/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.2.2
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string $url - (required) must be uploaded using wp media uploader
 * @param int $width - (required)
 * @param int $height - (optional)
 * @param bool $crop - (optional) default to soft crop
 * @param bool $single - (optional) returns an array if false
 * @param bool $upscale - (optional) resizes smaller images
 *
 * @return string|array
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions()
 * @uses  wp_get_image_editor()
 */
namespace Sy4mil\AqResize;

/**
 * Class AbstractSingleton
 *
 * @package AqResize
 */
abstract class AbstractSingleton {
	/**
	 * Call this method to get singleton
	 */
	public static function getInstance() {
		static $instance = false;
		if ( $instance === false ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Make constructor private, so nobody can call "new Class".
	 */
	protected function __construct() {
	}

	/**
	 * Make clone magic method private, so nobody can clone instance.
	 */
	private function __clone() {
	}

	/**
	 * Make sleep magic method private, so nobody can serialize instance.
	 */
	private function __sleep() {
	}

	/**
	 * Make wakeup magic method private, so nobody can unserialize instance.
	 */
	private function __wakeup() {
	}
}
