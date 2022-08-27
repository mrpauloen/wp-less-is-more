== WP Less is More ==
Editors: mrpauloen
Contributors: miccweb
Requires at least: 5.0
Requires PHP: 7.0
Tested up to: 5.5
Version: 1.1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: responsive-layout, mobile-ready, light, white, narrow, one-column, custom-menu, custom-background, custom-header, custom-logo, editor-style, footer-widgets, featured-images, sticky-post, post-formats, theme-options, threaded-comments, translation-ready, blog, e-commerce, entertainment, portfolio

== Description ==

Based on the popular Bootstrap 3 library, this theme shows how mobile friendly CSS framework can be used to create sleek, simple, fast and functional websites, with ease and intuitive way in modern front-end web developmen days.


== Installation ==

Manual installation:

1. Download the wp-less-is-more.zip archiwe from WordPress repository on the computer.
2. Unzip the archive
3. Then Upload the wp-less-is-more folder to the /wp-content/themes/ directory

Installation using ''Add New Theme''

1. From your Admin UI (Dashboard), use the menu to select Themes -> Add New
2. Search for ''WP Less is More''
3. Click the ''Install'' button to open the theme's repository listing
4. Click the ''Install'' button

Activiation and Use

1. Activate the Theme through the ''Themes'' menu in WordPress
2. See Appearance -> Theme Options to change theme specific options


== Copyright & License Notes ==

WP Less is More WordPress Theme, Copyright 2016-2020 Pawel Nowak
WP Less is More is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

License URI: http://www.gnu.org/licenses/gpl-2.0.html

In general words, feel free and encouraged to use, modify and redistribute this theme however you like.
You may remove any copyright references (unless required by third party components) and crediting is not necessary.
The theme is offered free of charge. If someone asked money for it, someone just tricked you.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

''' WP Less is More theme bundles the following third-party resources: '''

*! screenshot.png
** Copyright:   https://stocksnap.io/
** @link:       https://stocksnap.io/photo/typewriter-vintage-8E6502A3BC
** Author:      Sergey Zolkin
** Author URI:  https://stocksnap.io/author/276
** License:     CC0
** Licence URI: https://stocksnap.io/license

*! pin.svg
** Copyright: Entypo
** Author URI: http://www.entypo.com/
** Licence: CC-BY-SA 4.0
** Licence URI: https://creativecommons.org/licenses/by-sa/4.0/

*! Bootstrap v3.4.1 (http://getbootstrap.com)
** (e.g. bootstrap.js, bootstrap.css jumbotron-narrow.css as well as fonts folder)
** Copyright 2011-2019 Twitter, Inc.
** Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
** Or: 					http://getbootstrap.com/getting-started/#license-faqs

*! HTML5 Shiv v3.7.0,
** Copyright 2014 Alexander Farkas
** Licenses: 	MIT/GPL2
** Source: 		https://github.com/aFarkas/html5shiv

*! Respond.js v1.4.2: min/max-width media query polyfill
** Copyright 2013 Scott Jehl
** Licensed under https://github.com/scottjehl/Respond/blob/master/LICENSE-MIT

*! @Wp_Bootstrap_Navwalker class for Custom Navigation Walker
** GitHub URI: 	https://github.com/twittem/wp-bootstrap-navwalker
** Version: 	2.0.4
** Author: 		Edward McIntyre - @twittem
** License: 	GPL-2.0+
** License URI: http://www.gnu.org/licenses/gpl-2.0.txt


== Theme Features ==

'''Theme has several options available from Customizer'''

=== Read Me First section ===

Here you can find quick links to most important sites like:
* support
* review
* author page
* components

=== Custom footer section===

You can turn off/on or change default footer text simple on Customizer screen
Allowed HTML tags: ''a, b, del, em, i, q, s, strike, strong'' with some attributes.
Footer text is "on" by default.

=== Custom Excerpt Length section ===

By default the excerpt length is set to return 55 words.
Now you can change it in Customizer by moving the slider.
Available range is from 1 to 100 but you can set it precisely by input field below.

This functionality works only for posts with empty excerpt metabox
(even if you used <!-- more --> tag) and only with the_excerpt function,
so it doesn't work for teaser when the_content() function is used.

Read more in codex: https://codex.wordpress.org/Excerpt#Excerpt.2C_automatic_excerpt.2C_and_teaser
See docs for more information about this filter: https://developer.wordpress.org/reference/hooks/excerpt_length/

=== Widgets ===

Theme has four widgets area at the bottom, below main content area but above footer
# on the left side
# in the left middle side
# in the right middle side
# on the right side
Widges are in responsive columns. Preview shown on screenshot.

== Support ==

To contact with me, use facebook fanpage:
https://www.facebook.com/WPSolucje/
or better use official WordPress support forum on theme forums:
https://wordpress.org/support/theme/wp-less-is-more


== Changelog ==

=== 1.1.7 ===
''Released: August 16, 2020''

* Fixed some issue with comments reply script after wordpress update to 5.5
* Added:
** ''wp-less-is-more-popover.js'' script for allowed_tags popover, tooltip and autoheight comment textarea trigger handler
** ''wp_localize_script'' with ''allowed_tags'' value for popover button
* Comment legend moved to ''wp_less_is_more__comment_legend'' function and added extra condition
* Minified ''jumbotron-narrow.css'' and ''wp-less-is-more-popover.js''
* Theme description changed to more reliable

=== 1.1.6 ===
''Released: August 09, 2020''

* Theme URI changed to: https://www.facebook.com/WPSolucje/
* Author URI changed to: https://www.facebook.com/PawRakiety
* Screenshot licence changed to: https://stocksnap.io/ as well as image link

* Removed:
** ''wp_less_is_more__contact_form()'' with its related page template due to Theme requirements
** ''wp_less_is_more__bootstrap_link_pages()''
** ''comment_form_before'' and ''comment_form_after'' action hook
** ''wp_less_is_more__numeric_posts_nav()''
** ''wp_less_is_more__custom_comments_list_template()''
** ''wp_less_is_more__collapse_comments_list()''

* Added:
** native function ''wp_link_pages()''
** native function ''the_posts_pagination()''
** new design of comment form
** new design of comments list (comments no longer collapse)
** function ''wp_less_is_more__filter__hide_thumb_if_post_protected()'' (hides thumbnails if post password required)
** function ''wp_body_open()'' after body tag with backward compatibility
** ''navigation_markup_template'' filter hook
** skip link
** function ''wp_less_is_more__password_protcted()'' (adds padlock to post title)
** Current page number indicator for posts pagination on ''home.php'' and ''archive.php'' template
** Default css for WordPress gallery
** Style version param to ''wp_enqueue_style''
** ''cancel_comment_reply_link'' action hook with extra glyphicon
** class ''WP_Less_Is_More_Page_Walker'' extends ''Walker_Page''
** pencil icon to point customizer container
** templates folder

=== 1.1.5 ===
''Released: August 25, 2019''

* Bootstrap updated from 3.3.1 to 3.4.1 and config.json added to customize Bootstrap's components
* Author URL changed to wpsolucje.tk
* Sticky post title highlighted with background and pin

=== 1.1.4.1 ===
''Released: October 12, 2017''

* Small corrections in gettext strings
* Extra tags were added
* Screenshot changed to more realistic view
* Functions names changed to more readable

=== 1.1.4 ===
''Released: September 26, 2017''

* Fixed some html errors
* Added:
** Single taxonomy title on archive page
** Editor style
** Contact form templafe + contact form
** theme options to customizer:
*** the post meta date text replacement to icons
*** Speed Up & Clean Up option
*** Read Me section (for better support)
* Post author is now hyperlinced with ''the_author_link()'' function


=== 1.1.3 ===
''Released: April 06, 2017''

* Fixed some strings in translation

=== 1.1.2 ===
''Released: April 05, 2017''

* Fixed some strings in translation

=== 1.1.1 ===
''Released: March 23, 2017''

* Added:
** Customizer with 2 options:
*** custom footer text
*** excerpt lenght
* note when comments are closed
* comments pagination buttons
* New page template:
** Template Name: ''Page with title''
* Comments reply corrected (now link moves the comment form to just below the comment parent)
* Removed/replaced ''Leave a Response'' button
* Removed collapse effect (class) from form
** See: ''inc/customizer/customizer.php''

=== 1.1.0.8 ===
''Released: July 26, 2016''

* Added:
** Custom Site Title
*** See: line 494 in ''functions.php''

=== 1.1.0.7 ===
''Released: July 26, 2016''

* Added page template to retrieve or display list of pages in list (li) format.
** Template Name: ''List Child Pages''
** See: ''page_list-child-pages.php'' file
* Fixed issues with: Post Area.
** Post area didn't responding properly - nonclickable read more etc.

=== 1.1.0.6 ===
''Released: July 18, 2016''

* Theme has been approved and went live

=== 1.0 ===
''Initial Release''
