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

use Piwik\DataTable;


class API extends \Piwik\Plugin\API
{

    function getLiveLogData0($idSite)
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $apiKey = trim($apiKeys[0]);
        return $this->getLiveLogData($apiKey);
    }
    

    function getLiveLogData1($idSite)
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $apiKey = trim($apiKeys[1]);
        return $this->getLiveLogData($apiKey);
    }
    

    function getLiveLogData2($idSite)
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $apiKey = trim($apiKeys[2]);
        return $this->getLiveLogData($apiKey);
    }
    

    function getLiveLogData3($idSite)
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $apiKey = trim($apiKeys[3]);
        return $this->getLiveLogData($apiKey);
    }
    

    function getLiveLogData4($idSite)
    {
        $settings = new Settings('UptimeRobotMonitor');
        $apiKeys  = explode( "\n", $settings->apiKey->getValue() );
        $apiKey = trim($apiKeys[4]);
        return $this->getLiveLogData($apiKey);
    }
    

    function getMonitorData($apiKey = '')
    {
        $url = "http://api.uptimerobot.com/getMonitors?apiKey={$apiKey}&format=json";
        $encapString = "jsonUptimeRobotApi()";

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($c);
        $response = substr( $response, strlen($encapString) - 1, strlen($response) - strlen($encapString) );
        $aResponse = json_decode($response);
        curl_close($c);
        /*echo '<pre>';
        print_r($aResponse->monitors->monitor[0]);
        echo '</pre>';*/
        
        return $aResponse->monitors->monitor[0];
    }
    

    function getLiveLogData($apiKey = '')
    {
        $url = "http://api.uptimerobot.com/getMonitors?apiKey={$apiKey}&logs=1&format=json";
        $encapString = "jsonUptimeRobotApi()";

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($c);
        $response = substr( $response, strlen($encapString) - 1, strlen($response) - strlen($encapString) );
        $aResponse = json_decode($response);
        curl_close($c);

        $aLog = $aResponse->monitors->monitor[0]->log;
        
        $aData = array();
        $aLog[0]->timediff = DATE( "z,G,i,s", strtotime(date("Y-m-d H:i:s")) - strtotime($aLog[0]->datetime) );
        array_push($aData, array(
                'type'     => $this->_transformType( $aLog[0]->type ),
                'datetime' => $this->_transformDateTime( $aLog[0]->datetime ),
                'timediff' => $this->_transformTimePeriod( $aLog[0]->timediff )
            ));
        for($i=1; $i<count($aLog); $i++) {
            array_push($aData, array(
                    'type'     => $this->_transformType( $aLog[$i]->type ),
                    'datetime' => $this->_transformDateTime( $aLog[$i]->datetime ),
                    'timediff' => $this->_transformTimePeriod( DATE( "z,G,i,s", strtotime($aLog[$i-1]->datetime) - strtotime($aLog[$i]->datetime) ) )
                ));
        }
        
        $dataTable = new DataTable();
        $dataTable = DataTable::makeFromIndexedArray($aData);

        return $dataTable;
    }

    
    function getTimeBarData($apiKey = '')
    {
        $url = "http://api.uptimerobot.com/getMonitors?apiKey={$apiKey}&logs=1&format=json";
        $encapString = "jsonUptimeRobotApi()";

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($c);
        $response = substr( $response, strlen($encapString) - 1, strlen($response) - strlen($encapString) );
        $aResponse = json_decode($response);
        curl_close($c);
        
        $aLog = $aResponse->monitors->monitor[0]->log;
        
        $watchTime = '-14 days';
        $aData = array();
        $watchPeriod =  strtotime( 'now' ) - strtotime($watchTime);
        
        $aLog[0]->timediff = strtotime(date("Y-m-d H:i:s")) - strtotime($aLog[0]->datetime);
        array_push($aData, array(
                'state'     => $aLog[0]->type,
                'period' => min( $aLog[0]->timediff / $watchPeriod * 100.0, 100.0),
                'timediff' => $this->_transformTimePeriod( DATE( "z,G,i,s", $aLog[0]->timediff) )
            ));
        
        for($i=1; $i<count($aLog); $i++) {
            if ( (strtotime( 'now' ) - strtotime($aLog[$i-1]->datetime)) < $watchPeriod ) {
                if ( (strtotime( 'now' ) - strtotime($aLog[$i]->datetime)) > $watchPeriod )
                    $timePeriod = strtotime($aLog[$i-1]->datetime) - strtotime($watchTime);
                else
                    $timePeriod = strtotime($aLog[$i-1]->datetime) - strtotime($aLog[$i]->datetime);
                array_push($aData, array(
                        'state'     => $aLog[$i]->type,
                        'period' => min( ( $timePeriod ) / $watchPeriod * 100.0, 100.0 ),
                        'timediff' => $this->_transformTimePeriod( DATE( "z,G,i,s", strtotime($aLog[$i-1]->datetime) - strtotime($aLog[$i]->datetime) ) )
                    ));
            }
        }
        
        $dataTable = new DataTable();
        $dataTable = DataTable::makeFromIndexedArray($aData);

        return $dataTable;
    }
    
    
    function _transformType($type)
    {
        if ($type == '2') {
            return '<div style="color:#fff;background-color:forestgreen;display:inline;border-radius:3px;">&nbsp;&#9650; UP&nbsp;</div>';
        }
        else {
            return '<div style="color:#fff;background-color:firebrick;display:inline;border-radius:3px;">&nbsp;&#9660; DOWN&nbsp;</div>';
        }
    }
    
    
    function _transformDateTime($dateTime)
    {
        return date( "Y-m-d H:i:s", strtotime($dateTime) );
    }
    
    
    function _transformTimePeriod($timePeriod)
    {
        $aTimes = explode( ',', $timePeriod );
        foreach ($aTimes as $key => $value) {
            $aTimes[$key] = (int)$value;
        }
        $timeDiff = '';
        if ($aTimes[0] != 0)
            $timeDiff .= $aTimes[0] . 'd ';
        if ($aTimes[1] != 0)
            $timeDiff .= $aTimes[1] . 'h ';
        if ($aTimes[2] != 0)
            $timeDiff .= $aTimes[2] . 'm ';
        if ($aTimes[3] != 0)
            $timeDiff .= $aTimes[3] . 's ';
        return $timeDiff;
    }
	
}