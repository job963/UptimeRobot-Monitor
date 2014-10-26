<?php

/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * 
 * @copyright (c) 2014, Joachim Barthel
 * @author Joachim Barthel <jobarthel@gmail.com>
 * @category Piwik_Plugins
 * @package UptimeRobotMonitor
 **/

namespace Piwik\Plugins\UptimeRobotMonitor;

use Piwik\API\Request;
use Piwik\Piwik;
use Piwik\View;
use Piwik\ViewDataTable\Factory as ViewDataTableFactory;


class Controller extends \Piwik\Plugin\Controller
{

    /**
     * Container for the Live Log List widget
     **/
    function widgetLiveLogList()
    {
        $output = '';
        $output .= $this->widgetLiveLogTable();

        return $output;
    }
    

    /**
     * This widget shows ...
     **/
    function widgetLiveLogTable()
    {
        $controllerAction = $this->pluginName . '.' . __FUNCTION__;
        $apiAction = 'UptimeRobotMonitor.getLiveLogData';

        $view = ViewDataTableFactory::build('table', $apiAction, $controllerAction);
	
        $view->config->columns_to_display = array('type', 'datetime', 'timediff');
        $view->config->translations['type'] = Piwik::translate('UptimeRobotMonitor_Event');
        $view->config->translations['datetime'] = Piwik::translate('UptimeRobotMonitor_DateTime');
        $view->config->translations['timediff'] = Piwik::translate('UptimeRobotMonitor_Duration');

        $view->requestConfig->filter_sort_column = 'datetime';
        $view->requestConfig->filter_sort_order = 'asc';
        
        $view->requestConfig->filter_limit = 5;
        $view->config->show_exclude_low_population = false;
        $view->config->show_table_all_columns = false;
        $view->config->show_all_views_icons = false;
        $view->config->disable_row_evolution  = true;
        $view->config->enable_sort = false;
        $view->config->show_search = false;
        
        return $view->render();
    }
    
}