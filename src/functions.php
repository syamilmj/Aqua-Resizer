<?php
/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 2.0.0
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

if ( ! function_exists( 'aq_resize' ) ) {
	/**
	 * This is just a tiny wrapper function for the class above so that there is no
	 * need to change any code in your own WP themes. Usage is still the same :)
	 *
	 * @param string $url - image url.
	 * @param null $width - image width.
	 * @param null $height - image height.
	 * @param null $crop  - crop.
	 * @param bool $single - is single.
	 * @param bool $upscale - is upscale.
	 *
	 * @return array|bool|string
	 */
	function aq_resize(
		$url,
		$width = null,
		$height = null,
		$crop = null,
		$single = true,
		$upscale = false
	) {
		/* WPML Fix */
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			global $sitepress;
			$url = $sitepress->convert_url( $url, $sitepress->get_default_language() );
		}
		/* WPML Fix */
		$aq_resize = Sy4mil\AqResize\Resize::getInstance();

		return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
	}
}
