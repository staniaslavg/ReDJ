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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

// Add tooltip style
$document =& JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important;}' );

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<script language="javascript" type="text/javascript">
<!--
  Joomla.submitbutton = function(pressbutton) {
  var form = document.adminForm;
    if (pressbutton == 'purge') {
        if ( confirm("<?php echo JText::_('COM_REDJ_PURGE_CONFIRM', false); ?>") ) {
            submitform('purge');
        }
    } else {
        submitform(pressbutton);
    }
  }
//-->
</script>

<form action="<?php echo JRoute::_('index.php?option=com_redj&view=errors'); ?>" method="post" name="adminForm" id="adminForm">
  <fieldset id="filter-bar">
    <div class="filter-search fltlft">
      <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_REDJ_FILTER'); ?>" />
      <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
    <div class="filter-select fltrt">
      <?php
        $decode_options = array(
          JHTML::_('select.option', '0', JText::_('COM_REDJ_SHOW_RAW_ENTRIES')),
          JHTML::_('select.option', '1', JText::_('COM_REDJ_SHOW_DECODED_ENTRIES'))
        );
        echo JHTML::_('select.genericlist', $decode_options, 'filter_decode', 'class="inputbox" onchange="submitform( );"', 'value', 'text', $this->state->get('filter.decode'), 'filter_decode', true);
      ?>
    </div>
  </fieldset>
  <div class="clr"> </div>

<div id="editcell" style="overflow-x:scroll">
  <table class="adminlist">
  <thead>
    <tr>
      <th width="4%">
        <?php echo JText::_('COM_REDJ_NUM'); ?>
      </th>
      <th width="4%">
        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
      </th>
      <th width="4%" nowrap="nowrap">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_ID', 'e.id', $listDirn, $listOrder); ?>
      </th>
      <th width="35%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_VISITED_URL', 'e.visited_url', $listDirn, $listOrder); ?>
      </th>
      <th width="6%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_ERROR_CODE', 'e.error_code', $listDirn, $listOrder); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_HITS', 'e.hits', $listDirn, $listOrder); ?>
      </th>
      <th width="7%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_LAST_VISIT', 'e.last_visit', $listDirn, $listOrder); ?>
      </th>
      <th width="35%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_ERRORS_LAST_REFERER', 'e.last_referer', $listDirn, $listOrder); ?>
      </th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="8">
        <?php echo $this->pagination->getListFooter(); ?>
      </td>
    </tr>
  </tfoot>
  <tbody>
  <?php
    if( count( $this->items ) > 0 ) {
      foreach ($this->items as $i => $item) :
  ?>
      <tr class="row<?php echo $i % 2; ?>">
        <td>
          <?php echo $this->pagination->getRowOffset( $i ); ?>
        </td>
        <td class="center">
          <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td class="center">
          <?php echo $item->id; ?>
        </td>
        <td>
          <?php
            if ($this->state->get('filter.decode')) {
              $content = urldecode($item->visited_url);
              $tip = JText::_('COM_REDJ_RAW')."::".$item->visited_url;
            } else {
              $content = $item->visited_url;
              $tip = JText::_('COM_REDJ_DECODED')."::".urldecode($item->visited_url);
            }
          ?>
          <span style="display:block; width:400px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo $tip; ?>"><?php echo $content; ?></span>
        </td>
        <td>
          <?php echo $item->error_code; ?>
        </td>
        <td>
          <?php echo $item->hits; ?>
        </td>
        <td>
          <?php echo $item->last_visit; ?>
        </td>
        <td>
          <?php
            if ($this->state->get('filter.decode')) {
              $content = urldecode($item->last_referer);
              $tip = JText::_('COM_REDJ_RAW')."::".$item->last_referer;
            } else {
              $content = $item->last_referer;
              $tip = JText::_('COM_REDJ_DECODED')."::".urldecode($item->last_referer);
            }
          ?>
          <span style="display:block; width:400px; word-wrap:break-word;" class="editlinktip hasTip" title="<?php echo $tip; ?>"><?php echo $content; ?></span>
        </td>
      </tr>
  <?php
      endforeach;
    } else {
  ?>
      <tr>
        <td colspan="8">
          <?php echo JText::_('COM_REDJ_LIST_NO_ITEMS'); ?>
        </td>
      </tr>
  <?php
    }
  ?>
    </tbody>
  </table>
</div>

  <div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>