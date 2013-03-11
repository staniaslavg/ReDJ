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
 * HTML View class for the ReDJ About component
 *
 * @package ReDJ
 *
 */
class ReDJViewAbout extends JViewLegacy
{

  public function display($tpl = null)
  {
    $this->addToolbar();
    echo "<div style=\"float: left; margin-right: 20px;\"><img src=\"".JURI::root()."administrator/components/com_redj/images/logo.png\" alt=\"ReDJ\"/></div>";
    echo "<div style=\"float: none;\">".JText::_('COM_REDJ_COPYRIGHT')."</div>";
    echo "<div>".JText::_('COM_REDJ_ABOUT_DESC')."<br /><br /></div>";
    echo "<div>".JText::_('COM_REDJ_DONATE')."<br /><br /></div>";
    echo "<div>".JText::_('COM_REDJ_DONATE_PAYPAL')."</div>";
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

    if ($canDo->get('core.admin')) {
      JToolBarHelper::preferences('com_redj');
    }

  }

}
?>
