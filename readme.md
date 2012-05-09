# [Aqua Resizer](http://aquagraphite.com/)
### Version 1.1.1

This small script will allow you to resize & crop WordPress images uploaded via the media uploader. It relies on WP's native functions to resize the images, and checks if there is an already resized version of the image so that it won't be wasting your server's resources to regenerate the images.

## Why use it?

There are a couple of image resizing scripts out there that already have this function. Some authors simply use the add_image_size() function to define custom image sizes that will be generated for each image uploaded via the media uploader. I mostly find these methods somewhat a little complicated to use, or having some limitations or too resource intensive.

With Aqua Resizer, the only required inputs are the URL and width. It's easy, fast & efficient. Additionally, you have the additional options such as the height, crop, and array return.

## How to use

Simply copy aq_resizer.php into your theme and reference it from your functions.php file e.g. `require_once('aq_resizer.php');`, then you're good to go.

You can then use it in your theme as such:

```
aq_resize($img_url,$width);
```

More usage instructions and examples can be found in our [wiki](https://github.com/sy4mil/Aqua-Resizer/wiki)

## License

[WTFPL](http://sam.zoy.org/wtfpl/)

Do whatever you want with it. A linkback would be nice :)

## Donations
If you have some spare bucks, please seriously consider helping the World Food Programme to build world without hunger. Your donations will provide foods & shelters to those who needs them the most! - [Fill the Cup!](https://www.wfp.org/donate/fillthecup_getinvolved)

Or, [buy me a coffee](http://goo.gl/tsbK5) :)

## Contacts

Twitter: http://twitter.com/syamilmj

Website: http://aquagraphite.com

## Changelog

**v1.1.1**
- default $single to true and return string

**v1.1**
- fix issue with smaller widths

**v1.0**
first commit












