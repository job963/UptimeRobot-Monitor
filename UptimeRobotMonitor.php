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

use Piwik\Piwik;
use Piwik\WidgetsList;


class UptimeRobotMonitor extends \Piwik\Plugin
{
    /**
     * @see Piwik\Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'WidgetsList.addWidgets'   => 'addWidgets'
        );
    }

    
    /**
     * List of available Widgets
     */
    public function  addWidgets()
    {
        WidgetsList::add('UptimeRobot Monitor', 'UptimeRobotMonitor_widgetLiveLogList', 'UptimeRobotMonitor', 'widgetLiveLogList');
        WidgetsList::add('UptimeRobot Monitor', 'UptimeRobotMonitor_widgetTimeBar', 'UptimeRobotMonitor', 'widgetTimeBar');
    }
    
}
