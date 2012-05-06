# [Aqua Resizer](http://aquagraphite.com/)
### Version 1.1

This small script will allow you to resize & crop WordPress images uploaded via the media uploader. It relies on WP's native functions to resize the images, and checks if there is an already resized version of the image so that it won't be wasting your server's resources to regenerate the images.

## Why use it?

There are a couple of image resizing scripts out there that already have this function. Some authors simply use the add_image_size() function to define custom image sizes that will be generated for each image uploaded via the media uploader. I mostly find these methods somewhat a little complicated to use, or having some limitations or too resource intensive.

With Aqua Resizer, the only required inputs are the URL and width. It's easy, fast & efficient. Additionally, you have the additional options such as the height, crop, and array return.

## How to use

Simple copy the functions into your functions.php file or anywhere in your theme where WordPress can read it, then you're good to go.

### Example 1
Put this in the single.php file

```
<?php

$thumb = get_post_thumbnail_id();
$img_url = wp_get_attachment_url( $thumb,'full'); //get full URL to image (use "large" or "medium" if the images too big)
$image = aq_resize( $img_url, '', 560, 310, true ); //resize & crop the image

?>

<article <?php post_class()?> id="post-<?php the_ID(); ?>">

	<?php if($image) : ?>
		<img src="<?php echo $image ?>"/>
	<?php endif; ?>
	
	....
```

### Example 2
If you want to output a gallery, or a slider from a post.
Let's say you're using this in a file called format-gallery.php

```
<?php

$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $post->ID,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'orderby'		 => 'menu_order',
	'numberposts'    => -1,
);
$attachments = get_posts($args);

?>

<div id="slider">

<?php

if ($attachments) {
	foreach ($attachments as $attachment) {
		$attachment_url = wp_get_attachment_url($attachment->ID , 'full');
		$image = aq_resize($attachment_url, 600, 350, false); //resize & retain image proportions (soft crop)
		echo '<div class="slide"><img src="'.$image.'"/></div>';
	}	
}

?>

</div>
```

### Example 3
On some occasions, you may want to get width & height of the image.
This is mostly the case for image types like logo, or if you're using the older non-HTML5 markup
In this example, let's say you're using an image uploaded from [SMOF](https://github.com/sy4mil/Options-Framework)

```
<?php

$logo_img = $data['logo_img']; //get the original logo url
$logo_w = $data['logo_width']; ////
$logo_h = $data['logo_height']; // user defined width & height
$crop = false; //resize but retain proportions
$single = true; //return array

$logo = aq_resize($logo, $logo_w, $logo_h, $crop, $single);

?>

<?php if($logo) : ?>

<div id="logo" style="width:<?php echo $logo['width'] ?>px;height:<?php echo $logo['height'] ?>px">
	<img src="<?php echo $logo['url'] ?>" width="<?php echo $logo['width'] ?>" height="<?php echo $logo['height'] ?>"/>
</div>

<?php endif; ?>
```

## License
[WTFPL](http://sam.zoy.org/wtfpl/)

Do whatever you want with it. A linkback would be nice :)

## Donations
If you have some spare bucks, please seriously consider helping the World Food Programme to build world without hunger. Your donations will provide foods & shelter who needs it most! - [Fill the Cup!](https://www.wfp.org/donate/fillthecup_getinvolved)

I have some themes on [Themeforest](http://themeforest.net/user/SyamilMJ/portfolio) that you might be interested in. :)

## Contacts

Twitter: http://twitter.com/syamilmj

Website: http://aquagraphite.com

## Changelog

**v1.1**
- fix issue with smaller widths

**v1.0**
first commit












