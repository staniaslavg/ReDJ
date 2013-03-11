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

/**
 * ReDJ Helper
 *
 * @package ReDJ
 *
 */
class ReDJHelper
{
  /**
   * Configure the Linkbar
   *
   * @param string The name of the active view
   *
   * @return void
   * @since 1.6
   */
  public static function addSubmenu($vName)
  {
    $document = JFactory::getDocument();
    $document->addStyleDeclaration('.icon-48-redj {background-image: url(../administrator/components/com_redj/images/icon-48-redj.png);}');

    JSubMenuHelper::addEntry(
      JText::_('COM_REDJ_MENU_REDIRECTS'),
      'index.php?option=com_redj&view=redirects',
      $vName == 'redirects'
    );

    JSubMenuHelper::addEntry(
      JText::_('COM_REDJ_MENU_PAGES404'),
      'index.php?option=com_redj&view=pages404',
      $vName == 'pages404'
    );

    JSubMenuHelper::addEntry(
      JText::_('COM_REDJ_MENU_ERRORS'),
      'index.php?option=com_redj&view=errors',
      $vName == 'errors'
    );

    JSubMenuHelper::addEntry(
      JText::_('COM_REDJ_MENU_REFERERS'),
      'index.php?option=com_redj&view=referers',
      $vName == 'referers'
    );

    JSubMenuHelper::addEntry(
      JText::_('COM_REDJ_MENU_ABOUT'),
      'index.php?option=com_redj&view=about',
      $vName == 'about'
    );

  }

  /**
   * Gets a list of the actions that can be performed
   *
   * @return JObject
   * @since 1.6
   */
  public static function getActions()
  {
    $user = JFactory::getUser();
    $result = new JObject;

    $assetName = 'com_redj';

    $actions = array(
      'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
    );

    foreach ($actions as $action) {
      $result->set($action,  $user->authorise($action, $assetName));
    }

    return $result;
  }

  public static function trimText($text_to_trim, $max_chars = '50') {
    if( strlen( $text_to_trim ) > $max_chars ) {
      return substr( $text_to_trim, 0, $max_chars ) . ' ...';
    } else {
      return $text_to_trim;
    }
  }

  /**
   * Determines if the plugin for ReDJ to work is enabled
   *
   * @return boolean
   */
  public static function isEnabled()
  {
    $db = JFactory::getDbo();
    $db->setQuery(
      'SELECT enabled' .
      ' FROM #__extensions' .
      ' WHERE folder = '.$db->quote('system').
      '  AND element = '.$db->quote('redj')
    );
    $result = (boolean) $db->loadResult();
    if ($error = $db->getErrorMsg()) {
      JError::raiseWarning(500, $error);
    }
    return $result;
  }

}
