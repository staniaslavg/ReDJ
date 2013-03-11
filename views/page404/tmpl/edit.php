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

// Include the HTML helpers
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

// Add tooltip style
$document =& JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important;}' );
$document->addStyleDeclaration( 'table.paramlist td.paramlist_key {width: 92px; text-align: left; height: 30px;}' );
?>

<script type="text/javascript">
  Joomla.submitbutton = function(task)
  {
    if (task == 'page404.cancel' || document.formvalidator.isValid(document.id('page404-form'))) {
      Joomla.submitform(task, document.getElementById('page404-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_redj&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="page404-form" class="form-validate">
  <div class="width-60 fltlft">
    <fieldset class="adminform">
      <legend><?php echo empty($this->item->id) ? JText::_('COM_REDJ_PAGE404_NEW') : JText::_('COM_REDJ_PAGE404_EDIT'); ?></legend>
      <ul class="adminformlist">
      <li><?php echo $this->form->getLabel('title'); ?>
      <?php echo $this->form->getInput('title'); ?></li>

      <li><?php echo $this->form->getLabel('language'); ?>
      <?php echo $this->form->getInput('language'); ?></li>

      <li><?php echo $this->form->getLabel('page'); ?>
      <?php echo $this->form->getInput('page'); ?></li>

      <li><?php echo $this->form->getLabel('id'); ?>
      <?php echo $this->form->getInput('id'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="width-40 fltrt">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_REDJ_PAGE404_STATS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('hits'); ?>
        <?php echo $this->form->getInput('hits'); ?></li>

        <li><?php echo $this->form->getLabel('last_visit'); ?>
        <?php echo $this->form->getInput('last_visit'); ?></li>
        </ul>
    </fieldset>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
  </div>

  <div class="clr"></div>

</form>
