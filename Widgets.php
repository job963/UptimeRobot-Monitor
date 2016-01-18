<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * 
 * @copyright (c) 2014-2016, Joachim Barthel
 * @author Joachim Barthel <jobarthel@gmail.com>
 * @category Piwik_Plugins
 * @package UptimeRobotMonitor
 **/

namespace Piwik\Plugins\UptimeRobotMonitor;

use Piwik\Piwik;

class Widgets extends \Piwik\Plugin\Widgets
{
    protected $category = 'UptimeRobot Monitor';

    protected function init()
    {
        $this->addWidget('UptimeRobotMonitor_widgetLiveLogList', 'UptimeRobotMonitor_widgetLiveLogList');
        
        $settings = new Settings('UptimeRobotMonitor');
        $widgetTitles  = explode( "\n", $settings->widgetTitles->getValue() );
        
        foreach ($widgetTitles as $key => $widgetTitle) {
            $params = array('id' => $key);
            $this->addWidget($widgetTitle, 'widgetTimeBar', $params);
        }
    }
    

}
