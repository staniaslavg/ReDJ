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

require_once JPATH_COMPONENT.'/helpers/redj.php';

/**
 * HTML View class for the ReDJ Pages 404 component
 *
 * @package ReDJ
 *
 */
class ReDJViewPages404 extends JViewLegacy
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

    $canDo = ReDJHelper::getActions();

    if ($canDo->get('core.create')) {
      JToolBarHelper::custom('pages404.copy', 'copy.png', 'copy_f2.png', JText::_('COM_REDJ_TOOLBAR_COPY'));
      JToolBarHelper::addNew('page404.add');
    }

    if ($canDo->get('core.edit')) {
      JToolBarHelper::editList('page404.edit');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.edit.state')) {
      //JToolBarHelper::checkin('pages404.checkin');
      JToolBarHelper::custom('pages404.checkin', 'checkin', '', 'JTOOLBAR_CHECKIN', true);
    }
    if ( $canDo->get('core.delete')) {
      JToolBarHelper::deleteList('', 'pages404.delete');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.admin')) {
      JToolBarHelper::preferences('com_redj');
    }

  }

}
?>
