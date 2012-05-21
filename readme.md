# [WordPress Image Resizer]
Based on the solution of [Aqua Resizer](https://github.com/sy4mil/Aqua-Resizer) from [Syamil MJ](http://aquagraphite.com/)

## Description
This small script will allow you to resize & crop WordPress images uploaded via the media uploader. It relies on WP's native functions to resize the images, and checks if there is an already resized version of the image so that it won't be wasting your server's resources to regenerate the images.

### Why use it?
There are a couple of image resizing scripts out there that already have this function. Some authors simply use the add_image_size() function to define custom image sizes that will be generated for each image uploaded via the media uploader. I mostly find these methods somewhat a little complicated to use, or having some limitations or too resource intensive.

With Aqua Resizer, the only required inputs are the URL and width. It's easy, fast & efficient. Additionally, you have the additional options such as the height, crop, and array return.

### How to use
* Upload the file to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress

You can then use it in your theme as such:

**Echo img-tag**
```
	$args = array( 'url' => 'your img url', 'width' => 'your wish for width' );
	wp_img_resizer( $args );
```

**Return single value or array with url, width, height
```
	$args = array( 'url' => 'your img url', 'width' => 'your wish for width' );
	wp_img_resizer_src( $args );
```

**Also the first solution if Aqua Resizer
```
	aq_resize( $img_url,$width );
```

More usage instructions and examples can be found in our [wiki](https://github.com/sy4mil/Aqua-Resizer/wiki)












