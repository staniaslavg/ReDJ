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
 * HTML View class for the ReDJ Page 404 component
 *
 * @package ReDJ
 *
 */
class ReDJViewPage404 extends JViewLegacy
{
  protected $form;
  protected $item;
  protected $state;

  /**
   * Display the view
   */
  public function display($tpl = null)
  {
    // Initialiase variables.
    $this->form = $this->get('Form');
    $this->item = $this->get('Item');
    $this->state = $this->get('State');

    // Check for errors.
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
    JRequest::setVar('hidemainmenu', true);

    $user = JFactory::getUser();
    $userId = $user->get('id');
    $isNew = ($this->item->id == 0);
    $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
    $canDo = ReDJHelper::getActions();

    JToolBarHelper::title($isNew ? JText::_('COM_REDJ_PAGE404_NEW') : JText::_('COM_REDJ_PAGE404_EDIT'), 'redj.png');

    // If not checked out, can save the item
    if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_redj', 'core.create')) > 0)) {
      JToolBarHelper::apply('page404.apply');
      JToolBarHelper::save('page404.save');

      if ($canDo->get('core.create')) {
        //JToolBarHelper::save2new('page404.save2new');
        JToolBarHelper::custom('page404.save2new', 'save-new', '', 'JTOOLBAR_SAVE_AND_NEW', false);
      }
    }

    // If an existing item, can save to a copy
    if (!$isNew && $canDo->get('core.create')) {
      //JToolBarHelper::save2copy('page404.save2copy');
      JToolBarHelper::custom('page404.save2copy', 'save-copy', '', 'JTOOLBAR_SAVE_AS_COPY', false);
    }

    if (empty($this->item->id)) {
      JToolBarHelper::cancel('page404.cancel');
    } else {
      JToolBarHelper::cancel('page404.cancel', 'JTOOLBAR_CLOSE');
    }

  }

}
?>
