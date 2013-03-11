<?php
/**
 * ReDJ Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2012
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.6.2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
* ReDJ Page 404 Table class
*
* @package ReDJ
*
*/
class ReDJTablePage404 extends JTable
{
 function __construct(& $db) {
  parent::__construct('#__redj_pages404', 'id', $db);
 }

}
?>
