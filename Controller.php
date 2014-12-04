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
    protected $apiKey = '';

    /**
     * Container for the Live Log List widget
     **/
    function widgetLiveLogList()
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $output = '';
        
        foreach ($apiKeys as $index => $apiKey) {
            $apiKey = trim($apiKey);
            $monitorData = API::getInstance()->getMonitorData($apiKey);
            $output .= '<div style="font-size:1.1em;font-weight:bold;background-color:#e0e0e0;padding:6px;" title="' . $monitorData->url . '">' . $monitorData->friendlyname . '</div>';
            $output .= $this->widgetLiveLogTable($index, $apiKey);
        }

        return $output;
    }
    

    /**
     * This widget shows ...
     **/
    function widgetLiveLogTable($index, $apiKey)
    {
        $controllerAction = $this->pluginName . '.' . __FUNCTION__;
        $apiAction = 'UptimeRobotMonitor.getLiveLogData' . $index;
        $this->apiKey = $apiKey;

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
    
    
    /**
     * Container for the TimeBars of all monitored servers
     **/
    function widgetTimeBar()
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $output = '';
        
        foreach ($apiKeys as $index => $apiKey) {
            $apiKey = trim($apiKey);
            $output .= $this->widgetTimeBarElement($apiKey);
        }

        return $output;
    }
    

    /**
     * This widget shows ...
     **/
    function widgetTimeBarElement($apiKey)
    {
        $monitorData = API::getInstance()->getMonitorData($apiKey);
        $logData = API::getInstance()->getTimeBarData($apiKey);

        $view = new View('@UptimeRobotMonitor/widgetTimeBarElement.twig');
        $this->setBasicVariablesView($view);
        $view->friendlyName = $monitorData->friendlyname;
        $view->url = $monitorData->url;
        $view->timeRange = array( 'start' => date("Y-m-d", strtotime('now')), 'end' => date("Y-m-d", strtotime('-14 days')) );
        $view->timeBar = $logData;

        return $view->render();
    }
    
}