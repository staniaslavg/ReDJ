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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * ReDJ Controller
 *
 * @package ReDJ
 *
 */
class ReDJControllerRedirects extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);

        // Register Extra tasks
        $this->registerTask('case_on', 'setcase');
        $this->registerTask('case_off', 'setcase');
        $this->registerTask('request_on', 'setrequest');
        $this->registerTask('request_off', 'setrequest');
        $this->registerTask('decode_on', 'setdecode');
        $this->registerTask('decode_off', 'setdecode');
        $this->registerTask('copy', 'copy');
    }

    public function copy()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
        JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_redj/tables');
        $table =& JTable::getInstance('Redirect', 'ReDJTable');
        $n = count( $cid );

        if ($n > 0)
        {
          $i = 0;
          foreach ($cid as $id)
          {
            if ($table->load( (int)$id ))
            {
              $table->id            = 0;
              $table->fromurl       = JText::_('COM_REDJ_COPY_OF') . $table->fromurl;
              $table->hits          = 0;
              $table->ordering      = 0;
              $table->published     = 0;
              $table->checked_out   = false;

              if ($table->store()) {
                $i++;
              } else {
                JFactory::getApplication()->enqueueMessage( JText::sprintf('COM_REDJ_COPY_ERROR_SAVING', $id, $table->getError()), 'error' );
              }
            }
            else {
              JFactory::getApplication()->enqueueMessage( JText::sprintf('COM_REDJ_COPY_ERROR_LOADING', $id, $table->getError()), 'error' );
            }
          }
        }
        else {
          return JError::raiseWarning( 500, JText::_('COM_REDJ_COPY_ERROR_NO_SELECTION') );
        }

        $this->setMessage( JText::sprintf('COM_REDJ_COPY_OK', $i) );

        $this->setRedirect( 'index.php?option=com_redj&view=redirects' );

    }

    public function setcase()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
        JArrayHelper::toInteger($cid);
        $case = ($this->getTask() == 'case_on') ? 1 : 0;

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_('COM_REDJ_CHANGE_CASE_NO_SELECTION') );
        }

        $model = $this->getModel('redirect');
        if(!$model->setcase($cid, $case)) {
          $message = JText::sprintf('COM_REDJ_ERROR_SETCASE_FAILED', $model->getError());
          $this->setRedirect(JRoute::_('index.php?option=com_redj&view=redirects', false), $message, 'error');
        } else {
          $this->setRedirect( 'index.php?option=com_redj&view=redirects' );
        }
    }

    public function setrequest()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
        JArrayHelper::toInteger($cid);
        $request = ($this->getTask() == 'request_on') ? 1 : 0;

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_('COM_REDJ_CHANGE_REQUEST_NO_SELECTION') );
        }

        $model = $this->getModel('redirect');
        if(!$model->setrequest($cid, $request)) {
          $message = JText::sprintf('COM_REDJ_ERROR_SETREQUEST_FAILED', $model->getError());
          $this->setRedirect(JRoute::_('index.php?option=com_redj&view=redirects', false), $message, 'error');
        } else {
          $this->setRedirect( 'index.php?option=com_redj&view=redirects' );
        }
    }

    public function setdecode()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
        JArrayHelper::toInteger($cid);
        $decode = ($this->getTask() == 'decode_on') ? 1 : 0;

        if (count( $cid ) < 1) {
            JError::raiseError(500, JText::_('COM_REDJ_CHANGE_DECODE_NO_SELECTION') );
        }

        $model = $this->getModel('redirect');
        if(!$model->setdecode($cid, $decode)) {
          $message = JText::sprintf('COM_REDJ_ERROR_SETDECODE_FAILED', $model->getError());
          $this->setRedirect(JRoute::_('index.php?option=com_redj&view=redirects', false), $message, 'error');
        } else {
          $this->setRedirect( 'index.php?option=com_redj&view=redirects' );
        }
    }

    /**
     * Proxy for getModel
     * @since  1.6
     */
    public function getModel($name = 'Redirect', $prefix = 'ReDJModel', $config = array('ignore_request' => true))
    {
      $model = parent::getModel($name, $prefix, $config);

      return $model;
    }

}
?>
