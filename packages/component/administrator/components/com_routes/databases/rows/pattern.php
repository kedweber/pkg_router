<?php
/**
 * Com
 *
 * @author      Dave Li <dave@moyoweb.nl>
 * @category    Nooku
 * @package     Socialhub
 * @subpackage  ...
 * @uses        Com_
 */
 
defined('KOOWA') or die('Protected resource');

class ComRoutesDatabaseRowPattern extends KDatabaseRowDefault
{
    public function save()
    {
        if($this->rebuild == 1) {
            $identifier             = clone $this->getIdentifier();
            $identifier->package    = str_replace('com_', '', $this->component);
            $identifier->path       = array('controller');
            $identifier->name       = KInflector::singularize($this->view);

			$iso_code = substr(JFactory::getLanguage()->getTag(), 0, 2);

			$this->getService('com://admin/routes.model.routes')->package($identifier->package)->name($identifier->name)->custom(0)->lang($iso_code)->getList()->delete();

            $rows = $this->getService($identifier)->limit(0)->browse();

            //TODO:: Support for composite keys!
            foreach($rows as $row) {
                $relations  = array();
                $table      = $row->getTable();

                if($table->hasBehavior('routable')) {
                    $relations  = $table->getBehavior('routable')->getRelations();
                    $filters    = $table->getBehavior('routable')->getFilters();
                }

                $config = array(
                    'package'	=> $identifier->package,
                    'name'      => $identifier->name,
                    'pattern'   => $this->pattern,
                    'relations' => $relations,
                    'filters'   => $filters,
                    'row'       => $row,
                );

                $route          = $this->getService('com://admin/routes.database.row.route');
                $route->query   = 'option=com_'.$identifier->package.'&view='.$identifier->name.'&id='.$row->id;
                $route->lang    = substr(JFactory::getLanguage()->getTag(), 0, 2);
                $route->build($config);
            }

            return false;
        }

		parent::save();
    }
}