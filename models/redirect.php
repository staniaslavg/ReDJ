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

class ReDJModelRedirect extends JModelAdmin
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
  public function getTable($type = 'Redirect', $prefix = 'ReDJTable', $config = array())
  {
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * Method to get the record form
   *
   * @param  array  $data    Data for the form
   * @param  boolean  $loadData  True if the form is to load its own data (default case), false if not
   * @return  mixed  A JForm object on success, false on failure
   * @since  1.6
   */
  public function getForm($data = array(), $loadData = true)
  {
    // Get the form.
    $form = $this->loadForm('com_redj.redirect', 'redirect', array('control' => 'jform', 'load_data' => $loadData));
    if (empty($form)) {
      return false;
    }

    return $form;
  }

  /**
   * Method to get the data that should be injected in the form
   *
   * @return  mixed  The data for the form
   * @since  1.6
   */
  protected function loadFormData()
  {
    // Check the session for previously entered form data
    $data = JFactory::getApplication()->getUserState('com_redj.edit.redirect.data', array());

    if (empty($data)) {
      $data = $this->getItem();
    }

    return $data;
  }

  /**
   * Prepare and sanitise the table data prior to saving
   *
   * @param  JTable  A JTable object
   * @since  1.6
   */
  protected function prepareTable(&$table)
  {
    if (JRequest::getVar('task') == 'save2copy') {
      $table->fromurl = JText::_('COM_REDJ_COPY_OF') . $table->fromurl;
    }
    parent::prepareTable($table);
  }

  /**
   * Method to set case_sensitive property for specified items
   *
   * @access  public
   * @return  boolean  True on success
   */
  public function setcase($cid = array(), $case_sensitive = 1)
  {
    $user = JFactory::getUser();

    if (count($cid))
    {
      JArrayHelper::toInteger($cid);
      $cids = implode(',', $cid);

      $db = $this->getDbo();
      $query = 'UPDATE #__redj_redirects'
        . ' SET case_sensitive = ' . (int) $case_sensitive
        . ' WHERE id IN ( ' . $cids . ' )'
        . ' AND ( checked_out = 0 OR ( checked_out = ' . (int) $user->get('id') . ' ) )'
      ;
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  /**
   * Method to set request_only property for specified items
   *
   * @access  public
   * @return  boolean  True on success
   */
  public function setrequest($cid = array(), $request_only = 1)
  {
    $user = JFactory::getUser();

    if (count($cid))
    {
      JArrayHelper::toInteger($cid);
      $cids = implode(',', $cid);

      $db = $this->getDbo();
      $query = 'UPDATE #__redj_redirects'
        . ' SET request_only = ' . (int) $request_only
        . ' WHERE id IN ( ' . $cids . ' )'
        . ' AND ( checked_out = 0 OR ( checked_out = ' . (int) $user->get('id') . ' ) )'
      ;
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  /**
   * Method to set decode_url property for specified items
   *
   * @access  public
   * @return  boolean  True on success
   */
  public function setdecode($cid = array(), $decode_url = 1)
  {
    $user = JFactory::getUser();

    if (count($cid))
    {
      JArrayHelper::toInteger($cid);
      $cids = implode(',', $cid);

      $db = $this->getDbo();
      $query = 'UPDATE #__redj_redirects'
        . ' SET decode_url = ' . (int) $decode_url
        . ' WHERE id IN ( ' . $cids . ' )'
        . ' AND ( checked_out = 0 OR ( checked_out = ' . (int) $user->get('id') . ' ) )'
      ;
      $db->setQuery( $query );
      if(!$db->query()) {
        $this->setError($db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

}
?>
