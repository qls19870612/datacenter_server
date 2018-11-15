<?php
/**
 * VIEWER_CLASS_NAME
 *
 * 视图类名,如不设定该值,将没有视图类可调用,模版显示则无法实现
 *
 * @constvar String VIEWER_CLASS_NAME
 */
define('VIEWER_CLASS_NAME', 'Viewer');


/**
 * AUTO_VIEW_METHOD
 * 是否在调用方法后,自动调用视图类根据Controller和Method进行显示
 * @constvar String VIEWER_CLASS_NAME
 */
define('AUTO_VIEW_METHOD', FALSE);
$GLOBALS['ViewerConfig'] = array(
    'template_dir' => WEB_PATH . 'Tpl' //采用绝对路径
);