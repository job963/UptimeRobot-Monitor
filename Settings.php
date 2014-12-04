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
use Piwik\Settings\SystemSetting;
use Piwik\Settings\UserSetting;


class Settings extends \Piwik\Plugin\Settings
{
    public $apiKey;
    
    protected function init()
    {
        $this->setIntroduction( Piwik::translate('UptimeRobotMonitor_SettingsDescription') );

        $this->createApiKeySetting();
    }
    

    private function createApiKeySetting()
    {
        $this->apiKey = new SystemSetting('apiKey', Piwik::translate('UptimeRobotMonitor_ApiKeyLabel') );
        $this->apiKey->readableByCurrentUser = true;
        $this->apiKey->uiControlType = static::CONTROL_TEXTAREA;
        $this->apiKey->description   = Piwik::translate('UptimeRobotMonitor_ApiKeyDescription');

        $this->addSetting($this->apiKey);
    }
        
}