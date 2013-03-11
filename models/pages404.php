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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class ReDJModelPages404 extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 'p.id',
        'title', 'p.title',
        'language', 'p.language',
        'page', 'p.page',
        'hits', 'p.hits',
        'last_visit', 'p.last_visit',
        'checked_out', 'p.checked_out'
      );
    }

    parent::__construct($config);
  }

  /**
   * Method to auto-populate the model state
   *
   * Note. Calling getState in this method will result in recursion
   */
  protected function populateState($ordering = null, $direction = null)
  {
    $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
    // Convert search to lower case
    $search = JString::strtolower($search);
    $this->setState('filter.search', $search);

    // Load the parameters.
    $params = JComponentHelper::getParams('com_redj');
    $this->setState('params', $params);

    // List state information.
    parent::populateState('p.id', 'asc');
  }

  /**
   * Method to build an SQL query to load the list data
   *
   * @return string An SQL query
   */
  protected function getListQuery()
  {
    // Create a new query object
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    // Select required fields
    $query->select('p.id, p.title, p.language, p.page, p.hits, p.last_visit, p.checked_out');

    // From the table
    $query->from('#__redj_pages404 AS p');

    // Filter by search
    $search = $this->getState('filter.search');
    if (!empty($search)) {
      $query->where('LOWER(p.title) LIKE '.$db->Quote('%'.$db->getEscaped($search, true).'%'));
    }

    // Add the list ordering clause
    $orderCol = $this->state->get('list.ordering', 'p.id');
    $orderDirn = $this->state->get('list.direction', 'asc');
    $query->order($db->getEscaped($orderCol.' '.$orderDirn));

    return $query;
  }

}
?>
