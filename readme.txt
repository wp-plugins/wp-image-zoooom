=== WP Image Zoooom ===
Created: 10/06/2015
Contributors: diana_burduja
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=diana.burduja@gmail.com&lc=AT&item_name=Diana%20Burduja&item_number=WP%2dImage%2dZoooom%2dplugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Email: diana@burduja.eu
Tags: image, zoom, woocommerce, image zoom, magnifier, image magnifier, product image, no lightbox 
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1.0.6 
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html


Add zoom effect over the an image, whether it is an image in a post/page or the featured image of a product in a WooCommerce shop. 

== Description ==

The zoom will be applied by default to all feature images of products in the WooCommerce shop. It will override the "lightbox" that comes with WooCommerce. 

If you want to add the zoom effect on an image in a post/page, then in the edit page you can click on the "Image Zoooom" button in the editor while the image is selected.
 
In the admin side you can configure the zooming effect, which can be tested live on the image provided in the form. Once you hit the "Save" button, the effect will be applied to the entire website.

= Available Zoom Effects =

* No lens - the image will be simply be zoomed within its own borders
* Circle Lens - you get a round magnifying glass that will zoom the hoovered area. You can configure the lens size, border thickness, border color, fade time and tint.
* Square lens - you get a square magnifying glass that will zoom the hoovered area.
* With Zoom Window - next to the image appears a Zoom Window with the magnified version of the hoovered area. You can configure the Zoom Window size, border thickness, border color and fade time. The Zoom Window also offers you the chance to control the zoom level with the mousewheel.


== Installation ==

* From the WP admin panel, click "Plugins" -> "Add new".
* In the browser input box, type "WP Edit".
* Select the "WP Edit" plugin (authored by "josh401"), and click "Install".
* Activate the plugin.

OR...

* Download the plugin from this page.
* Save the .zip file to a location on your computer.
* Open the WP admin panel, and click "Plugins" -> "Add new".
* Click "upload".. then browse to the .zip file downloaded from this page.
* Click "Install".. and then "Activate plugin".

OR...

* Download the plugin from this page.
* Extract the .zip file to a location on your computer.
* Use either FTP or your hosts cPanel to gain access to your website file directories.
* Browse to the `wp-content/plugins` directory.
* Upload the extracted `wp_edit` folder to this directory location.
* Open the WP admin panel.. click the "Plugins" page.. and click "Activate" under the newly added "WP Edit" plugin.

== Frequently Asked Questions ==

= Does it work with variable products? =
Yes

= Does it work with W3 Total Cache? =
Yes

== Screenshots ==

1. Configuration menu for the Round Lens

2. Configuration menu for the Square Lens

3. Configuration menu for the Zoom Window

4. Application of zoom on an image in a post

5. General configuration menu

6. WooCommerce product page with the Round Lens applied on the featured image

== Credits ==

* Demo photo from http://pixabay.com/en/wordcloud-tagcloud-cloud-text-tag-679951/ under CC0 Public Domain license

== Changelog ==

= 1.0.6 =
* 06/03/2015
* Solved https://wordpress.org/support/topic/the-zoom-button-does-not-appear (it was assumed that the path to the plugin is the standard one. Now it loads the .png from a path relative to tinyMCE-button.js)

= 1.0.5 =
* 06/01/2015
* Solved https://wordpress.org/support/topic/parse-error-334 (retrieval of static variables for PHP<5.2 is done differently)

= 1.0.4 =
* 05/27/2015
* Solved the JS bug that was leading to "works in the upper-left of the image"

= 1.0.3 =
* 05/26/2015
* Add version number to the css, otherwise the css was taken from the cache from the previous version

= 1.0.2 =
* 05/26/2015
* Added "Like this Plugin?" box in the admin
* Refactored the "Zoom Settings" page in the admin and added steps

= 1.0 =
* 05/19/2015
* Initial commit

== Upgrade Notice ==

Nothing at the moment
