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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_redj')) {
  return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// import Joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the ReDJ controller
$controller = JControllerLegacy::getInstance('ReDJ');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();

?>
