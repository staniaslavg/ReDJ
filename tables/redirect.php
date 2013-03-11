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
* ReDJ Redirect Table class
*
* @package ReDJ
*
*/
class ReDJTableRedirect extends JTable
{
 function __construct(& $db) {
  parent::__construct('#__redj_redirects', 'id', $db);
 }

 function check() {
  /** check for unique fromurl */
  $query = 'SELECT id FROM #__redj_redirects WHERE fromurl = '.$this->_db->Quote($this->fromurl);
  $this->_db->setQuery($query);

  $xid = intval($this->_db->loadResult());
  if ($xid && $xid != intval($this->id)) {
   $this->setError(JText::_('COM_REDJ_WARNING_DUPLICATED_FROMURL'));
   return false;
  }
  return true;
 }

}
?>
