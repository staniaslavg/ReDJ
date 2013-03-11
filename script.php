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

jimport('joomla.installer.installer');

/**
 * Script file of ReDJ component
 */
class com_ReDJInstallerScript
{
  /**
   * method to install the component
   *
   * @return void
   */
  function install($parent)
  {
    // Install plugin
    $myparent = $parent->getParent();
    $plugin_path = $myparent->getPath('source').DS.'plugins'.DS.'system'.DS.'redj';
    $installer = new JInstaller();
    if (!$installer->install($plugin_path)) {
      echo '<p>' . JText::sprintf('COM_REDJ_PLUGIN_INSTALLATION_FAILED', JText::_('plg_system_redj')) . '</p>';
      JError::raiseWarning(1, 'ReDJInstallerScript::install(): ' . JText::_('COM_REDJ_PLUGIN_INSTALLATION_FAILED_SHORT'));
    } else {
      echo '<p>' . JText::sprintf('COM_REDJ_PLUGIN_INSTALLATION_SUCCESS', JText::_('plg_system_redj')) . '</p>';
    }

  }

  /**
   * method to update the component
   *
   * @return void
   */
  function update($parent)
  {
    // Install plugin
    $myparent = $parent->getParent();
    $plugin_path = $myparent->getPath('source').DS.'plugins'.DS.'system'.DS.'redj';
    $installer = new JInstaller();
    if (!$installer->install($plugin_path)) {
      echo '<p>' . JText::sprintf('COM_REDJ_PLUGIN_INSTALLATION_FAILED', JText::_('plg_system_redj')) . '</p>';
      JError::raiseWarning(1, 'ReDJInstallerScript::install(): ' . JText::_('COM_REDJ_PLUGIN_INSTALLATION_FAILED_SHORT'));
    } else {
      echo '<p>' . JText::sprintf('COM_REDJ_PLUGIN_INSTALLATION_SUCCESS', JText::_('plg_system_redj')) . '</p>';
    }

  }

  /**
   * method to uninstall the component
   *
   * @return void
   */
  function uninstall($parent)
  {
    $db =& JFactory::getDBO();
    $query = 'SELECT `extension_id`, `name` FROM #__extensions WHERE type = \'plugin\' AND element = \'redj\' AND folder = \'system\'';
    $db->setQuery($query);
    $plugins = $db->loadObjectList();

    if (count($plugins)) {
      foreach ($plugins as $plugin) {
        $installer = new JInstaller();
        if (!$installer->uninstall('plugin', $plugin->extension_id, 0)) {
          echo '<p>' . JText::_('COM_REDJ_PLUGIN_UNINSTALLATION_FAILED') . '</p><br />';
          JError::raiseWarning(1, 'ReDJInstallerScript::uninstall(): ' . JText::_('COM_REDJ_PLUGIN_UNINSTALLATION_FAILED_SHORT') . $plugin->name);
        } else {
          echo '<p>' . JText::_('COM_REDJ_PLUGIN_UNINSTALLATION_SUCCESS') . $plugin->name . '</p><br />';
        }
      }
    }

    echo '<p>' . JText::_('COM_REDJ_UNINSTALLATION_TEXT') . '</p>';

  }

}

?>
