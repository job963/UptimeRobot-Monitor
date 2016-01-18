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
use Piwik\Settings\SystemSetting;
use Piwik\Settings\UserSetting;


class Settings extends \Piwik\Plugin\Settings
{
    public $widgetTitles;
    public $monitorRange;
    public $apiKeys;
    
    protected function init()
    {
        $this->setIntroduction( Piwik::translate('UptimeRobotMonitor_SettingsDescription') );

        $this->createBarWidgetTitlesSetting();
        $this->createMonitorRangeSetting();
        $this->createApiKeysSetting();
    }
    

    private function createBarWidgetTitlesSetting()
    {
        $this->widgetTitles = new SystemSetting('widgetTitles', Piwik::translate('UptimeRobotMonitor_WidgetTitles') );
        $this->widgetTitles->readableByCurrentUser = true;
        //$this->widgetTitles->type  = static::TYPE_STRING;
        $this->widgetTitles->uiControlType = static::CONTROL_TEXTAREA;
        $this->widgetTitles->description   = Piwik::translate('UptimeRobotMonitor_WidgetTitlesDescription');
        $this->widgetTitles->inlineHelp    = Piwik::translate('UptimeRobotMonitor_WidgetTitlesHelp');

        $this->addSetting($this->widgetTitles);
    }
    
    
    private function createMonitorRangeSetting()
    {
        $this->monitorRange = new SystemSetting('monitorRange', Piwik::translate('UptimeRobotMonitor_MonitorRange') );
        $this->monitorRange->readableByCurrentUser = true;
        $this->monitorRange->uiControlType = static::CONTROL_RADIO;
        $this->monitorRange->availableValues  = array(
                    '1' => Piwik::translate('UptimeRobotMonitor_Range2Days'), 
                    '7' => Piwik::translate('UptimeRobotMonitor_Range7Days'), 
                    '14' => Piwik::translate('UptimeRobotMonitor_Range14Days'), 
                    '30' => Piwik::translate('UptimeRobotMonitor_Range30Days') );
        //$this->monitorRange->description   = Piwik::translate('UptimeRobotMonitor_MonitorRangeDescription');
        $this->monitorRange->inlineHelp    = Piwik::translate('UptimeRobotMonitor_MonitorRangeHelp');

        $this->addSetting($this->monitorRange);
    }
    

    private function createApiKeysSetting()
    {
        $this->apiKeys = new SystemSetting('apiKeys', Piwik::translate('UptimeRobotMonitor_ApiKeysLabel') );
        $this->apiKeys->readableByCurrentUser = true;
        $this->apiKeys->uiControlType = static::CONTROL_TEXTAREA;
        $this->apiKeys->description   = Piwik::translate('UptimeRobotMonitor_ApiKeysDescription');
        $this->apiKeys->inlineHelp    = Piwik::translate('UptimeRobotMonitor_ApiKeysHelp');

        $this->addSetting($this->apiKeys);
    }
        
}