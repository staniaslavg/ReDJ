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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of ReDJ component
 */
class ReDJController extends JControllerLegacy
{
  /**
   * @var    string  The default view.
   * @since  1.6
   */
  protected $default_view = 'redirects';

  /**
   * Display view
   *
   * @return void
   */
  public function display($cachable = false, $urlparams = false)
  {
    $input =JFactory::getApplication()->input;
    $view = $input->get('view', 'redirects');
    $layout = $input->get('layout', 'default');
    $id = $input->get('id');

    // Set the submenu
    require_once JPATH_COMPONENT.'/helpers/redj.php';
    ReDJHelper::addSubmenu($view);

    // Check for edit form
    if ($view == 'redirect' && $layout == 'edit' && !$this->checkEditId('com_redj.edit.redirect', $id)) {
      // Somehow the person just went to the form - we don't allow that
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_redj&view=redirects', false));

      return false;
    }
    else if ($view == 'page404' && $layout == 'edit' && !$this->checkEditId('com_redj.edit.page404', $id)) {
      // Somehow the person just went to the form - we don't allow that
      $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
      $this->setMessage($this->getError(), 'error');
      $this->setRedirect(JRoute::_('index.php?option=com_redj&view=pages404', false));

      return false;
    }

    // Call parent behavior
    //$res = new JControllerLegacy(array('name'=>'redirects'));
    parent::display();

    return $this;
  }

}
