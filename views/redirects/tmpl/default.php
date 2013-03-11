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
$document = JFactory::getDocument();
$document->addStyleDeclaration( '.tip-text {word-wrap: break-word !important;}' );

$user = JFactory::getUser();
$userId = $user->get('id');
$state = $this->get('state');;
$pagination = $this->get('pagination');
$listOrder = $this->escape($state->get('list.ordering'));
$listDirn = $this->escape($state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state');
$saveOrder = $listOrder=='a.ordering';
?>

<!--<form action="<?php echo JRoute::_('index.php?option=com_redj&view=redirects'); ?>" method="post" name="adminForm" id="adminForm">
<fieldset id="filter-bar">
    <div class="filter-search fltlft">
        <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($state->get('filter.search')); ?>" title="<?php echo JText::_('COM_REDJ_FILTER'); ?>" />
        <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
        <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>
    <div class="filter-select fltrt">
        <select name="filter_state" class="inputbox" onchange="this.form.submit()">
            <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
            <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $state->get('filter.state'), true);?>
        </select>
    </div>
</fieldset>-->
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
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_ID', 'a.id', $listDirn, $listOrder); ?>
            </th>
            <th width="20%">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_FROM_URL', 'a.fromurl', $listDirn, $listOrder); ?>
            </th>
            <th width="20%">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_TO_URL', 'a.tourl', $listDirn, $listOrder); ?>
            </th>
            <th width="5%">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_REDIRECT', 'a.redirect', $listDirn, $listOrder); ?>
            </th>
            <th width="5%" nowrap="nowrap">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_CASE_SENSITIVE', 'a.case_sensitive', $listDirn, $listOrder); ?>
                <br />
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_REQUEST_ONLY', 'a.request_only', $listDirn, $listOrder); ?>
                <br />
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_DECODE_URL', 'a.decode_url', $listDirn, $listOrder); ?>
            </th>
            <th width="8%">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_HITS', 'a.hits', $listDirn, $listOrder); ?>
            </th>
            <th width="7%">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_LAST_VISIT', 'a.last_visit', $listDirn, $listOrder); ?>
            </th>
            <th width="19%" nowrap="nowrap">
                <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                <?php if ($canOrder && $saveOrder): ?>
                <?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'redirects.saveorder'); ?>
                <?php endif;?>
            </th>
            <th width="4%" nowrap="nowrap">
                <?php echo JHTML::_('grid.sort', 'COM_REDJ_HEADING_REDIRECTS_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="11">
                <?php echo $pagination->getListFooter(); ?>
                <p class="footer-tip">
                    <?php if ($this->enabled) : ?>
                    <span class="enabled"><?php echo JText::sprintf('COM_REDJ_PLUGIN_ENABLED', JText::_('COM_REDJ_PLG_SYSTEM_REDJ')); ?></span>
                    <?php else : ?>
                    <span class="disabled"><?php echo JText::sprintf('COM_REDJ_PLUGIN_DISABLED', JText::_('COM_REDJ_PLG_SYSTEM_REDJ')); ?></span>
                    <?php endif; ?>
                </p>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php
        var_dump($this);
        if( $this->items ) {
            foreach ($this->items as $i => $item) :
                $ordering	= ($listOrder == 'a.ordering');
                $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out==$userId || $item->checked_out==0;
                $canChange	= $canOrder && $canCheckin;
                $item_link = JRoute::_('index.php?option=com_redj&task=redirect.edit&id='.(int) $item->id);
                ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td>
                    <?php echo $pagination->getRowOffset( $i ); ?>
                </td>
                <td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td class="center">
                    <?php echo $item->id; ?>
                </td>
                <td>
          <span style="display:block; width:340px; word-wrap:break-word;">
          <?php
              $max_chars = 100;
              $item_fromurl = ReDJHelper::trimText($item->fromurl, $max_chars);
              if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
                  echo $item_fromurl;
              } else {
                  ?>
                  <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_REDJ_EDIT_ITEM'); ?>"><?php echo $item_fromurl; ?></a>
                  <?php
              }
              ?>
          </span>
                </td>
                <td>
          <span style="display:block; width:340px; word-wrap:break-word;">
          <?php
              $max_chars = 100;
              $item_tourl = ReDJHelper::trimText($item->tourl, $max_chars);
              if (  JTable::isCheckedOut($userId, $item->checked_out) ) {
                  echo $item_tourl;
              } else {
                  ?>
                  <a href="<?php echo $item_link; ?>" title="<?php echo JText::_('COM_REDJ_EDIT_ITEM'); ?>"><?php echo $item_tourl; ?></a>
                  <?php
              }
              ?>
          </span>
                </td>
                <td class="center">
                    <?php echo $item->redirect; ?>
                </td>
                <td class="center">
                    <?php
                    if ($item->case_sensitive) {
                        $jtask = 'redirects.case_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
                    } else {
                        $jtask = 'redirects.case_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
                    }
                    ?>
                    <a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $jtask;?>')" title="<?php echo $jtext;?>">
                        <span class="state <?php echo $jstate;?>"><span class="text"><?php echo $jtext;?></span></span></a>
                    <br />
                    <?php
                    if ($item->request_only) {
                        $jtask = 'redirects.request_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
                    } else {
                        $jtask = 'redirects.request_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
                    }
                    ?>
                    <a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $jtask;?>')" title="<?php echo $jtext;?>">
                        <span class="state <?php echo $jstate;?>"><span class="text"><?php echo $jtext;?></span></span></a>
                    <br />
                    <?php
                    if ($item->decode_url) {
                        $jtask = 'redirects.decode_off'; $jtext = JText::_( 'JYES' ); $jstate = 'publish';
                    } else {
                        $jtask = 'redirects.decode_on'; $jtext = JText::_( 'JNO' ); $jstate = 'unpublish';
                    }
                    ?>
                    <a class="jgrid" href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $jtask;?>')" title="<?php echo $jtext;?>">
                        <span class="state <?php echo $jstate;?>"><span class="text"><?php echo $jtext;?></span></span></a>
                </td>
                <td class="center">
                    <?php echo $item->hits; ?>
                </td>
                <td>
                    <?php echo $item->last_visit; ?>
                </td>
                <td class="order">
                    <?php if ($canChange) : ?>
                    <?php if ($saveOrder) : ?>
                        <?php if ($listDirn == 'asc') : ?>
                            <span><?php echo $pagination->orderUpIcon($i, true, 'redirects.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                            <span><?php echo $pagination->orderDownIcon($i, $this->pagination->total, true, 'redirects.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                            <?php elseif ($listDirn == 'desc') : ?>
                            <span><?php echo $pagination->orderUpIcon($i, true, 'redirects.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                            <span><?php echo $pagination->orderDownIcon($i, $this->pagination->total, true, 'redirects.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
                    <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled; ?> class="text-area-order" />
                    <?php else : ?>
                    <?php echo $item->ordering; ?>
                    <?php endif; ?>
                </td>
                <td class="center">
                    <?php echo JHtml::_('jgrid.published', $item->published, $i, 'redirects.', $canChange); ?>
                </td>
            </tr>
                <?php
            endforeach;
        } else {
            ?>
        <tr>
            <td colspan="11">
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