<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     remove_leading_zero<br>
 * Purpose:  Remove all leading zeros.<br>
 * Example:  {$var|strip} {$var|strip:"&nbsp;"}
 * Date:     September 25th, 2002
 * @link http://smarty.php.net/manual/en/language.modifier.remove.leading.zero.php
 *          strip (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_remove_leading_zero($text)
{
    return ltrim($text, "0");
}

/* vim: set expandtab: */

?>
