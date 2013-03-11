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
    if (task == 'redirect.cancel' || document.formvalidator.isValid(document.id('redirect-form'))) {
      Joomla.submitform(task, document.getElementById('redirect-form'));
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_redj&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="redirect-form" class="form-validate">
  <div class="width-60 fltlft">
    <fieldset class="adminform">
      <legend><?php echo empty($this->item->id) ? JText::_('COM_REDJ_REDIRECT_NEW_REDIRECT') : JText::_('COM_REDJ_REDIRECT_EDIT_REDIRECT'); ?></legend>
      <ul class="adminformlist">
      <li><?php echo $this->form->getLabel('fromurl'); ?>
      <?php echo $this->form->getInput('fromurl'); ?></li>

      <li><?php echo $this->form->getLabel('tourl'); ?>
      <?php echo $this->form->getInput('tourl'); ?></li>

      <li><?php echo $this->form->getLabel('redirect'); ?>
      <?php echo $this->form->getInput('redirect'); ?></li>

      <li><?php echo $this->form->getLabel('case_sensitive'); ?>
      <?php echo $this->form->getInput('case_sensitive'); ?></li>

      <li><?php echo $this->form->getLabel('request_only'); ?>
      <?php echo $this->form->getInput('request_only'); ?></li>

      <li><?php echo $this->form->getLabel('decode_url'); ?>
      <?php echo $this->form->getInput('decode_url'); ?></li>

      <li><?php echo $this->form->getLabel('id'); ?>
      <?php echo $this->form->getInput('id'); ?></li>
      </ul>
    </fieldset>
  </div>

  <div class="width-40 fltrt">
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_REDJ_REDIRECT_OPTIONS'); ?></legend>
      <ul class="adminformlist">
        <li><?php echo $this->form->getLabel('published'); ?>
        <?php echo $this->form->getInput('published'); ?></li>
      </ul>
    </fieldset>
    <fieldset class="adminform">
      <legend><?php echo JText::_('COM_REDJ_REDIRECT_STATS'); ?></legend>
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

  <div class="width-100 fltlft">
    <?php echo JHtml::_('sliders.start','redj-redirect-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_REDJ_REDIRECT_QUICK_HELP_LABEL'), 'quick-help'); ?>
    <fieldset class="panelform">
      <?php $errordocument = "<b>ErrorDocument 404 " . JURI::root(true) . "/</b>"; ?>
      <p><?php echo JText::sprintf('COM_REDJ_REDIRECT_QUICK_HELP_DESC', $errordocument); ?></p> 
    </fieldset>
    <?php echo JHtml::_('sliders.panel',JText::_('COM_REDJ_REDIRECT_SUPPORTED_MACROS_LABEL'), 'supported-macros'); ?>
    <fieldset class="panelform">
      <p><?php echo JText::_('COM_REDJ_REDIRECT_SUPPORTED_MACROS_DESC'); ?></p> 
    </fieldset>
    <?php echo JHtml::_('sliders.end'); ?>
  </div>

  <div class="clr"></div>
</form>
