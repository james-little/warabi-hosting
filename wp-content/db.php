<?php
/**
 * WordPress DB Class Customized
 *
 * Original code from {@link http://php.justinvincent.com Justin Vincent (justin@visunet.ie)}
 *
 * @package WordPress
 * @subpackage Database
 * @since 1.0
 */

class warabi_wpdb extends wpdb {


}

$wpdb = new warabi_wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
