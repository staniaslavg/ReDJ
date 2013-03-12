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

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo JRoute::_('index.php?option=com_redj&view=pages404'); ?>" method="post" name="adminForm" id="adminForm">
<div style="display:none">
  <fieldset id="filter-bar">
    <div class="filter-search fltlft">
      <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
      <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_REDJ_FILTER'); ?>" />
      <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
      <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
  </fieldset>
</div>
  <div class="clr"> </div>

<div id="editcell">
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
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_PAGES404_ID', 'p.id', $listDirn, $listOrder); ?>
      </th>
      <th width="20%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_PAGES404_TITLE', 'p.title', $listDirn, $listOrder); ?>
      </th>
      <th width="20%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_PAGES404_LANGUAGE', 'p.language', $listDirn, $listOrder); ?>
      </th>
      <th width="36%">
        <?php echo JText::_('COM_REDJ_HEADING_PAGES404_PAGE'); ?>
      </th>
      <th width="5%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_PAGES404_HITS', 'p.hits', $listDirn, $listOrder); ?>
      </th>
      <th width="7%">
        <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_PAGES404_LAST_VISIT', 'p.last_visit', $listDirn, $listOrder); ?>
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
      $item_link = JRoute::_('index.php?option=com_redj&task=page404.edit&id='.(int) $item->id);
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
            $item_title = ReDJHelper::trimText($item->title);
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
                echo $item_title;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_REDJ_EDIT_ITEM'); ?>"><?php echo $item_title; ?></a>
          <?php
            }
          ?>
        </td>
        <td>
          <?php
            $item_language = ReDJHelper::trimText($item->language);
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
              echo $item_language;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_REDJ_EDIT_ITEM'); ?>"><?php echo $item_language; ?></a>
          <?php
            }
          ?>
        </td>
        <td>
          <?php
            $max_chars = 100;
            $item_page = ReDJHelper::trimText(strip_tags($item->page), $max_chars);
            if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
              echo $item_page;
            } else {
          ?>
              <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_REDJ_EDIT_ITEM'); ?>"><?php echo $item_page; ?></a>
          <?php
            }
          ?>
        </td>
        <td class="center">
          <?php echo $item->hits; ?>
        </td>
        <td>
          <?php echo $item->last_visit; ?>
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