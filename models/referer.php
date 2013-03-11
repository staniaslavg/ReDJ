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
defined( '_JEXEC' ) or die( 'Restricted access' );

// import the Joomla modellist library
jimport('joomla.application.component.modeladmin');

class ReDJModelReferer extends JModelAdmin
{
  /**
   * Returns a reference to the a Table object, always creating it
   *
   * @param  type  The table type to instantiate
   * @param  string  A prefix for the table class name. Optional
   * @param  array  Configuration array for model. Optional
   * @return  JTable  A database object
   * @since  1.6
   */
  public function getTable($type = 'Referer', $prefix = 'ReDJTable', $config = array())
  {
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * Method for getting the form from the model
   *
   * @param  array    $data      Data for the form
   * @param  boolean  $loadData  True if the form is to load its own data (default case), false if not
   *
   * @return  mixed  A JForm object on success, false on failure
   *
   */
  public function getForm($data = array(), $loadData = true)
  {
    return false;
  }

  /**
   * Method to purge all items
   *
   * @access  public
   * @return  boolean  True on success
   */
  public function purge()
  {
    if ($this->canDelete()) {
      // Create a new query object
      $db = $this->getDbo();

      $query = 'TRUNCATE TABLE #__redj_referers';
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }

      $query = 'TRUNCATE TABLE #__redj_referer_urls';
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }

      $query = 'TRUNCATE TABLE #__redj_visited_urls';
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }

      return true;
    } else {
      JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_DELETE_NOT_PERMITTED'));
      return false;
    }
  }

}
?>
