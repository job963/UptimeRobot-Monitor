# UptimeRobot Monitor Plugin

## Description

This plugin shows data, collected by UptimeRobot, in Piwik. This helps you to see all information about your website in one system without having the need to login into several systems.

The access to UptimeRobot will be managed by an individual monitor API key, which you have to create in UptimeRobot (see FAQ).


## Screenshots
**LogList Widget**  
![](https://github.com/job963/UptimeRobot-Monitor/raw/master/screenshots/widgetLogList.png)

**TimeBar Widget**  
![](https://github.com/job963/UptimeRobot-Monitor/raw/master/screenshots/widgetTimeBar.png)

**Plugin Settings**  
![](https://github.com/job963/UptimeRobot-Monitor/raw/master/screenshots/SettingsDE.png)


## Installation

Install it via [Piwik Marketplace](http://plugins.piwik.org/).

OR 

Install manually:

1. Clone the plugin into the plugins directory of your Piwik installation.

   ```
   cd plugins/
   git clone https://github.com/job963/UptimeRobot-Monitor.git UptimeRobotMonitor
   ```

2. Login as superuser into your Piwik installation and activate the plugin under Settings -> Plugins

3. Goto Settings -> Plugin Settings an setup the values for the widget.

4. You will now find the widget under the UptimeRobotMonitor -> UptimeRobot - Latest Events.

## Changelog

* **0.1.0 Initial release**
  * Widget for latest events
  * Setting for monitor API key

* **0.1.1 Small corrections**
  * Small correction in README

* **0.1.2 New Language added**
  * Now usable in hungarian language (thanks to sagikazarmark)

* **0.1.3 Readme updated**
  * New version description added

* **0.2 Timebar widget added**
  * New widget for displaying the log as a time bar
  * Support of multiple servers

## FAQ

**Where do I get the API key?**  

Go in UptimeRoboto to "My Settings" and click in the paragraph "Monitor-specific API Keys" on "Show/hide it". Search as next for the name of the desired website. Now you will see the API key for monitoring this website.  
This API key you have to enter in the plugin settings of _UptimeRobotMonitor_.

## License

GPL v3 or later

## Support

Please report any issues directly in [Github](https://github.com/job963/UptimeRobot-Monitor/issues). 

## Contribute 

If you are interested in contributing to this plugin, feel free to send pull requests!

