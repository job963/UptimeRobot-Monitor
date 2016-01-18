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

use Piwik\Common;
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
    

    function getResponseTimesData($apiKey = '')
    {
        $url = "http://api.uptimerobot.com/getMonitors?apiKey={$apiKey}&responseTimes=1&format=json";
        $encapString = "jsonUptimeRobotApi()";

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($c);
        $response = substr( $response, strlen($encapString) - 1, strlen($response) - strlen($encapString) );
        $aResponse = json_decode($response);
        curl_close($c);

        $aTimes = $aResponse->monitors->monitor[0]->responsetime;
        
        /*
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
        */

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
        //$aTimes = $aResponse->monitors->monitor[0]->reponsetime;
        
        $settings = new Settings('UptimeRobotMonitor');
        $watchTime = '-' . $settings->monitorRange->getValue() . ' day';  // -nn days
        
        $endDate = Common::getRequestVar('date', false);
        $startDate = date('Y-m-d', strtotime($watchTime, strtotime($endDate)));
        $startDateTime = strtotime( $startDate . ' 00:00:00' );
        $endDateTime = strtotime( $endDate . ' 23:59:59' );
        $watchPeriod = $endDateTime - $startDateTime;
        
        $aData = array();
        
        $sumPeriods = 0.0;
        for($i=0; $i<count($aLog); $i++) {
            $aLog[$i]->starttime = strtotime($aLog[$i]->datetime);
            if ($i == 0) {
                $aLog[$i]->endtime = $endDateTime;
            } else {
                $aLog[$i]->endtime = strtotime($aLog[$i-1]->datetime);
            }
        
            if ( ( ($aLog[$i]->starttime <= $endDateTime) && ($aLog[$i]->starttime >= $startDateTime) ) 
                    || ( ($aLog[$i]->endtime >= $startDateTime) && ($aLog[$i]->endtime <= $endDateTime) ) )  {
                $timePeriod = $aLog[$i]->endtime - $aLog[$i]->starttime;
                $remPeriods = 100.0 - $sumPeriods;
                array_push($aData, array(
                        'start'    => date("Y-m-d, H:i:s", strtotime($aLog[$i]->datetime)),
                        'state'    => $aLog[$i]->type,
                        'period'   => min( $remPeriods, $timePeriod/$watchPeriod*100.0, 100.0 ),
                        'timediff' => $this->_transformTimePeriod( DATE( "z,G,i,s", strtotime($aLog[$i-1]->datetime) - strtotime($aLog[$i]->datetime) ) )
                    ));
                $sumPeriods += min( ( $timePeriod ) / $watchPeriod * 100.0, 100.0 );
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