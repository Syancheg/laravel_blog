<?php


namespace App\Helpers;




class ConstantHelper
{
    static $POST_MAIN_IMAGE_WIDTH = 300;
    static $POST_MAIN_IMAGE_HEIGTH = 300;

    const MAIN_STYLES = [
        'styles/main_styles.css',
        'styles/responsive.css'
    ];
    const CATEGORY_STYLES = [
        'styles/category.css',
        'styles/category_responsive.css'
    ];
    const CONTACT_STYLES = [
        'styles/contact.css',
        'styles/contact_responsive.css'
    ];
    const POST_STYLES = [
        'styles/post_nosidebar.css',
        'styles/post_nosidebar_responsive.css'
    ];

    const MAIN_SCRIPTS = [
        'plugins/masonry/images_loaded.js',
        'js/custom.js',
    ];
    const CATEGORY_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/category.js'
    ];
    const CONTACT_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/contact.js'
    ];
    const POST_SCRIPTS = [
        'plugins/parallax-js-master/parallax.min.js',
        'js/post_nosidebar.js'
    ];
}
