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

class ReDJModelRedirects extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 'a.id',
        'fromurl', 'a.fromurl',
        'tourl', 'a.tourl',
        'redirect', 'a.redirect',
        'case_sensitive', 'a.case_sensitive',
        'request_only', 'a.request_only',
        'decode_url', 'a.decode_url',
        'hits', 'a.hits',
        'last_visit', 'a.last_visit',
        'ordering', 'a.ordering',
        'published', 'a.published',
        'checked_out', 'a.checked_out',
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
    $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
    $this->setState('filter.state', $state);

    $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '', 'string');
    // Convert search to lower case
    $search = JString::strtolower($search);
    $this->setState('filter.search', $search);

    // Load the parameters.
    $params = JComponentHelper::getParams('com_redj');
    $this->setState('params', $params);

    // List state information.
    parent::populateState('a.ordering', 'asc');
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
    $query->select('a.id, a.fromurl, a.tourl, a.redirect, a.case_sensitive, a.request_only, a.decode_url, a.hits, a.last_visit, a.ordering, a.published, a.checked_out');

    // From the table
    $query->from('#__redj_redirects AS a');

    // Filter by state
    $state = $this->getState('filter.state');
    if (is_numeric($state)) {
      $query->where('a.published = '.(int) $state);
    } else if ($state === '') {
      $query->where('(a.published IN (0, 1))'); // By default only published and unpublished
    }

    // Filter by search
    $search = $this->getState('filter.search');
    if (!empty($search)) {
      $query->where('LOWER(a.fromurl) LIKE '.$db->Quote('%'.$db->getEscaped($search, true).'%').'OR LOWER(a.tourl) LIKE '.$db->Quote('%'.$db->getEscaped($search, true).'%'));
    }

    // Add the list ordering clause
    $orderCol = $this->state->get('list.ordering', 'a.ordering');
    $orderDirn = $this->state->get('list.direction', 'asc');
    $query->order($db->getEscaped($orderCol.' '.$orderDirn));

    return $query;
  }

}
?>
