<?php
/**
 * ReDJ Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2013
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.1
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

require_once JPATH_COMPONENT.'/helpers/redj.php';

/**
 * HTML View class for the ReDJ Redirects component
 *
 * @package ReDJ
 *
 */
class ReDJViewRedirects extends JViewLegacy
{
  protected $enabled;
  protected $items;
  protected $pagination;
  protected $state;

  public function display($tpl = null)
  {
    // Initialise variables
    $this->enabled = ReDJHelper::isEnabled();
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
      JToolBarHelper::custom('redirects.copy', 'copy.png', 'copy_f2.png', JText::_('COM_REDJ_TOOLBAR_COPY'));
      JToolBarHelper::addNew('redirect.add');
    }

    if ($canDo->get('core.edit')) {
      JToolBarHelper::editList('redirect.edit');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.edit.state')) {
      if ($this->state->get('filter.state') != 2){
        JToolBarHelper::publish('redirects.publish', 'JTOOLBAR_PUBLISH', true);
        JToolBarHelper::unpublish('redirects.unpublish', 'JTOOLBAR_UNPUBLISH', true);
      }

      JToolBarHelper::divider();

      if ($this->state->get('filter.state') != -1 ) {
        if ($this->state->get('filter.state') != 2) {
          JToolBarHelper::archiveList('redirects.archive');
        }
        else if ($this->state->get('filter.state') == 2) {
          JToolBarHelper::unarchiveList('redirects.publish');
        }
      }

      //JToolBarHelper::checkin('redirects.checkin');
      JToolBarHelper::custom('redirects.checkin', 'checkin', '', 'JTOOLBAR_CHECKIN', true);
      JToolBarHelper::trash('redirects.trash');

    }

    if ( $canDo->get('core.delete')) {
      JToolBarHelper::deleteList('', 'redirects.delete', 'JTOOLBAR_EMPTY_TRASH');
    }

    JToolBarHelper::divider();

    if ($canDo->get('core.admin')) {
      JToolBarHelper::preferences('com_redj');
    }

  }

}
?>
