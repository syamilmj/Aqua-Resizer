<?php
/**
 * Plugin Name: WP Image Resizer
 * Plugin URI:  
 * Text Domain: wp-img-resizer
 * Domain Path: /languages
 * Description: Resize images on the fly - an TimThumb alternative with WordPress defaults
 * Version:	    1.0.0
 * Author:      Frank Bültge
 * Author URI:  http://bueltge.de
 * License:     GPLv3
 */

/**
 * Based on solution Aqua-Resizer https://github.com/sy4mil/Aqua-Resizer
 * by Syamil MJ
 */
 
/**
License:
==============================================================================
Copyright 2012 Frank Bültge  (email : frank@bueltge.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Requirements:
==============================================================================
This plugin requires WordPress >= 3.3 and tested with PHP Interpreter >= 5.3
*/


if ( ! function_exists( 'wp_img_resizer_src' ) ) {
	
	/**
	 * Resize images on the fly
	 * 
	 * @param   $args  Array with
	 *          url    
	 *          width  
	 *          height 
	 *          crop   => Optional, Whether to crop image or resize. | default is FALSE 
	 *          single => Optional, true for single url on return $image, false for Array | default is TRUE
	 * @return  $image Array with url, width, height
	 */
	function wp_img_resizer_src( $args = '' ) {
		
		// set defaults
		$defaults = array(
			'url'    => FALSE,
			'width'  => FALSE,
			'height' => NULL,
			'crop'   => NULL,
			'single' => TRUE
		);
		
		// set an filter for custom settings via plugin
		$args = wp_parse_args(
			$args,
			apply_filters( 'wp_img_resizer_args', $defaults )
		);
		
		// validate inputsan is an @ToDo
		if ( ! $args['url'] )
			return FALSE;
		
		if ( ! $args['width'] )
			return FALSE;
		
		// set var for original image
		$original = array(
			'width',
			'height'
		);
		
		// set var for the noun, the result of new image
		$noun = array(
			'width',
			'height',
			'url',
			'file',
			'path'
		);
		
		/**
		 * define upload path & dir
		 * 
		 * wp_upload_dir -- On success, the returned array will have many indices:
		 * 'path' - base directory and sub directory or full path to upload directory.
		 * 'url' - base url and sub directory or absolute URL to upload directory.
		 * 'subdir' - sub directory if uploads use year/month folders option is on.
		 * 'basedir' - path without subdir.
		 * 'baseurl' - URL path without subdir.
		 * 'error' - set to false.
		 */
		$upload_info = wp_upload_dir();
		$upload_dir  = $upload_info['basedir'];
		$upload_url  = $upload_info['baseurl'];
		
		//check if image url is local
		if ( FALSE === strpos( $args['url'], home_url() ) )
			return FALSE;
		
		// define path of image
		$rel_path = str_replace( $upload_url, '', $args['url'] );
		$img_path = $upload_dir . $rel_path;
		
		// check if img path exists, and is an image indeed
		if ( ! file_exists( $img_path ) || ! getimagesize( $img_path ) )
			return FALSE;
		
		// get image info
		$info = pathinfo( $img_path );
		$ext  = $info['extension'];
		list( $original['width'], $original['height'] ) = getimagesize( $img_path );
		
		// get image size after cropping
		$dimensions = image_resize_dimensions(
			$original['width'], $original['height'],
			$args['width'], $args['height'], $args['crop']
		);
		$noun['weight'] = $dimensions[4];
		$noun['height'] = $dimensions[5];
		
		// use this to check if cropped image already exists, so we can return that instead
		$suffix = "{$noun['weight']}x{$noun['height']}";
		$noun['path'] = str_replace( '.'.$ext, '', $rel_path );
		$noun['file'] = "{$upload_dir}{$noun['path']}-{$suffix}.{$ext}";
		
		// if orig size is smaller
		if ( $args['width'] >= $original['width'] ) {
			
			if ( ! $noun['height'] )  {
				// can't resize, so return original url
				$noun['url'] = $args['url'];
				$noun['weight'] = $original['width'];
				$noun['height'] = $original['height'];
				
			} else {
				//else check if cache exists
				if ( file_exists( $noun['file'] ) && getimagesize( $noun['file'] ) ) {
					$noun['url'] = "{$upload_url}{$noun['path']}-{$suffix}.{$ext}";
				} else { //else resize and return the new resized image url
					$resized_img_path = image_resize( $img_path, $args['width'], $args['height'], $args['crop'] );
					$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
					$noun['url'] = $upload_url . $resized_rel_path;
				}
				
			}
			
		} else if ( 
			file_exists( $noun['file'] ) && getimagesize( $noun['file'] )
			) { // else check if cache exists
			$noun['url'] = "{$upload_url}{$noun['path']}-{$suffix}.{$ext}";
		} else { //else, we resize the image and return the new resized image url
			$resized_img_path = image_resize(
				$img_path, $args['width'], $args['height'], $args['crop']
			);
			$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
			$noun['url'] = $upload_url . $resized_rel_path;
		}
		
		// return the output
		if ( $args['single'] ) {
			//str return
			$image = $noun['url'];
		} else {
			//array return
			$image = array (
				0 => $noun['url'],
				1 => $noun['weight'],
				2 => $noun['height']
			);
		}
		
		return $image;
	} // end function
	
} // end if function exists


if ( ! function_exists( 'wp_img_resizer' ) ) {
	
	function wp_img_resizer( $args = '', $attr = '' ) {
		
		// set to get an array
		$args['single'] = FALSE;
		// set for an default echo if img tag
		$args['echo']   = TRUE;
		
		$image = wp_img_resizer_src( $args );
		
		list( $image[0], $image[1], $image[2] ) = $image;
		$hwstring = image_hwstring($image[1], $image[2]);
		
		// set defaults
		$default_attr = array(
			'src'   => $image[0],
			'class' => "attachment-{$image[1]}x{$image[2]}",
			'alt'   => trim( strip_tags(
				get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE )
			) ), // Use Alt field first
			'title' => trim( strip_tags( get_the_title() ) ),
		);
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim( strip_tags( get_the_excerpt() ) ); // If not, Use the Caption
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim( strip_tags( get_the_title() ) ); // Finally, use the title
		
		$attr = wp_parse_args( $attr, $default_attr );
		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
		
		if ( $args['echo'] )
			echo $html;
		else
			return $html;
	}
}

if ( ! function_exists( 'aq_resize' ) ) {
	
	function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {
		
		$args = array(
			'url'    => $url,
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
			'single' => $single
		);
		
		return wp_img_resizer_src( $args );
	}
}
