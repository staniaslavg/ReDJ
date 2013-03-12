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

class ReDJModelReferers extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 'r.id',
        'visited_url', 'rv.visited_url',
        'referer_url', 'rr.referer_url',
        'domain', 'rr.domain',
        'hits', 'r.hits',
        'last_visit', 'r.last_visit'
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

    $decode = $this->getUserStateFromRequest($this->context.'.filter.decode', 'filter_decode', '0', 'int');
    $this->setState('filter.decode', $decode);

    // Load the parameters.
    $params = JComponentHelper::getParams('com_redj');
    $this->setState('params', $params);

    // List state information.
    parent::populateState('r.id', 'asc');
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
    $query->select('r.id AS id, rv.visited_url AS visited_url, rr.referer_url AS referer_url, rr.domain AS domain, r.hits AS hits, r.last_visit AS last_visit, "0" AS checked_out');

    // From the table
    $query->from('#__redj_referers AS r');
    $query->join('LEFT', '#__redj_visited_urls AS rv ON r.visited_url = rv.id');
    $query->join('LEFT', '#__redj_referer_urls AS rr ON r.referer_url = rr.id');

    // Filter by search
    $search = $this->getState('filter.search');
    if (!empty($search)) {
      $query->where('LOWER(rv.visited_url) LIKE '.$db->Quote('%'.$db->escape($search, true).'%').' OR LOWER(rr.referer_url) LIKE '.$db->Quote('%'.$db->escape($search, true).'%'));
    }

    // Add the list ordering clause
    $orderCol = $this->state->get('list.ordering', 'r.id');
    $orderDirn = $this->state->get('list.direction', 'asc');
    $query->order($db->escape($orderCol.' '.$orderDirn));

    return $query;
  }

}
?>
