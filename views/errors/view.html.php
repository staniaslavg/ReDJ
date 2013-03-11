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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the ReDJ Errors component
 *
 * @package ReDJ
 *
 */
class ReDJViewErrors extends JViewLegacy
{
  protected $items;
  protected $pagination;
  protected $state;

  public function display($tpl = null)
  {
    // Initialise variables
    $this->items = $this->get('Items');
    $this->pagination = $this->get('Pagination');
    $this->state = $this->get('State');

    // Check for errors
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode("\n", $errors));
      return false;
    }

    $this->addToolbar();
    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar
   *
   * @since  1.6
   */
  protected function addToolbar()
  {
    JToolBarHelper::title(JText::_('COM_REDJ_MANAGER'), 'redj.png');

    require_once JPATH_COMPONENT.'/helpers/redj.php';
    $canDo = ReDJHelper::getActions();

    if ($canDo->get('core.delete')) {
      JToolBarHelper::custom('errors.purge', 'trash.png', 'trash.png', JText::_('COM_REDJ_TOOLBAR_PURGE'), false, false);
      JToolBarHelper::deleteList('', 'errors.delete');
    }

    if ($canDo->get('core.admin')) {
      JToolBarHelper::divider();
      JToolBarHelper::preferences('com_redj');
    }

  }

}
?>
