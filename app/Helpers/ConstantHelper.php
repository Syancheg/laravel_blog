<?php


namespace App\Helpers;


class ConstantHelper
{
    static $POST_TYPE = 1;
    static $CATEGORY_TYPE = 2;
    static $POST_MAIN_IMAGE_WIDTH = 300;
    static $POST_MAIN_IMAGE_HEIGTH = 300;

    static $MAIN_STYLES = [
        'styles/main_styles.css',
        'styles/responsive.css'
    ];
    static $CATEGORY_STYLES = [
        'styles/category.css',
        'styles/category_responsive.css'
    ];

    static $CONTACT_STYLES = [
        'styles/contact.css',
        'styles/contact_responsive.css'
    ];

    static $MAIN_SCRIPTS = [
        'plugins/masonry/images_loaded.js',
        'js/custom.js',
    ];
    static $CATEGORY_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/category.js'
    ];
    static $CONTACT_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/contact.js'
    ];

    static $POST_STYLES = [
        'styles/post_nosidebar.css',
        'styles/post_nosidebar_responsive.css'
    ];
    static $POST_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/post_nosidebar.js'
    ];
}
