<?php
if ( !function_exists( 'aq_resize_get_pixelratio' ) ){
	function aq_resize_get_pixelratio(){
		if( isset($_COOKIE["pixel_ratio"]) ){
			$pixel_ratio = $_COOKIE["pixel_ratio"];
			if( $pixel_ratio >= 2 ){
			   //HiRes Device;
				
				/**
				* Set filters for 2x AQ Resizer
				*/
				function retina_aq_width_resizer($width){
					$width = $width * 2;	
					return $width;
				}
				add_filter('aq_resize_width', 'retina_aq_width_resizer');
				//
				function retina_aq_height_resizer($height){
					$height = $height * 2;
					return $height;	
				}
				add_filter('aq_resize_height', 'retina_aq_height_resizer');
			}else{
				//Is NormalRes Device;
				//Leave width and height as is.
			}
		/**
		* Pixel Ratio cookie has not been set yet
		*/
		}else{
			//Set pixel_ratio cookie and reload page
			?>
			<script language="javascript">
				writeCookie();
				function writeCookie()
				{
					the_cookie = document.cookie;
					if( the_cookie ){
						if( window.devicePixelRatio >= 2 ){
							the_cookie = "pixel_ratio="+window.devicePixelRatio+";"+the_cookie;
							document.cookie = the_cookie;
							location = '<?php $_SERVER['PHP_SELF'] ?>';
						}
					}
				}
			</script>
			<?php
		}//isset($_COOKIE["pixel_ratio"]) 
	}//get_pixelratio
}
add_action( 'wp_enqueue_scripts', 'aq_resize_get_pixelratio' );
?>
