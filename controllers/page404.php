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

jimport('joomla.application.component.controllerform');

/**
 * ReDJ Controller Page 404
 *
 * @package ReDJ
 *
 */
class ReDJControllerPage404 extends JControllerForm
{
  public function __construct($config = array())
  {
    parent::__construct($config);
    $this->view_list = 'pages404';
  }

}