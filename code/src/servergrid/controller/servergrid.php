<?php

/*
*
*   _____                           _____      _     _
*  / ____|                         / ____|    (_)   | |
* | (___   ___ _ ____   _____ _ __| |  __ _ __ _  __| |
*  \___ \ / _ \ '__\ \ / / _ \ '__| | |_ | '__| |/ _` |
*  ____) |  __/ |   \ V /  __/ |  | |__| | |  | | (_| |
* |_____/ \___|_|    \_/ \___|_|   \_____|_|  |_|\__,_|
*
* ServerGrid core control mechanisms
* Core routines for delivering and storing information
* Author: Rick Trotter <rick@gingercoder.com>
*
*/

class serverGrid extends MicroFramework{


    /*
    * Convert ServerIdent to ID
    * Used for URL mapping around the application
    */
    public function serverIdentToID($ident)
    {
      $sql = "SELECT * FROM client_servers WHERE serverIdent='".db::escapechars($ident)."'";
      $result = db::returnrow($sql);
      return $result['serverid'];
    }

    /*
     * Get the list of servers for a particular user
     *
     */
    public function getServerList($userid)
    {
        $sql = "SELECT
                    *
                FROM
                    client_servers
                WHERE
                    userid='".db::escapechars($userid)."'
                ORDER BY
                    serverName ASC";
        $serverlist = db::returnallrows($sql);
        return $serverlist;
    }

    /*
     * Add a server to their list of servers
     *
     */
    public function addServer($userid, $serverName, $serverOS, $ipaddress)
    {
        $serverident = md5(db::escapechars($serverName).db::escapechars($serverOS).date(YmdHis));

        $sql = "INSERT INTO
                    client_servers
                SET
                    userid='".db::escapechars($userid)."',
                    serverIdent='".$serverident."',
                    serverName='".db::escapechars($serverName)."',
                    serverOS='".db::escapechars($serverOS)."',
                    ipaddress = '".db::escapechars($ipaddress)."',
                    dateCreated=NOW(),
                    dateModified=NOW()";
        $insert = db::execute($sql);
        if($insert){
            $serverid = db::getlastid();
            $action = db::escapechars($userid)." added a server - $serverid";
            $this->logevent('Add Server', $action);
            return $serverident;
        }
        else{
            return false;
        }
    }
    /*
     * Function to edit a server
     * locks to user id
     */
    public function editServer($serverid, $userid, $serverName, $serverOS, $ipaddress)
    {
        $sql = "UPDATE
                    client_servers
                SET
                    serverName='".db::escapechars($serverName)."',
                    serverOS='".db::escapechars($serverOS)."',
                    ipaddress = '".db::escapechars($ipaddress)."',
                    dateModified=NOW()
                WHERE
                    serverid='".db::escapechars($serverid)."'
                AND
                    userid='".db::escapechars($userid)."'
                LIMIT 1";
        $insert = db::execute($sql);
        if($insert){
            $action = db::escapechars($userid)." edited their server - ".db::escapechars($serverid);
            $this->logevent('Edit Server', $action);
            return true;
        }
        else{
            return false;
        }
    }

    /*
     * function to remove a server
     * locks to current user
     */
    public function removeServer($serverid)
    {
        $sql = "DELETE FROM
                    client_servers
                WHERE
                    serverid='".db::escapechars($serverid)."'
                AND
                    userid='".db::escapechars($this->usernametoid($_SESSION['username']))."'
                LIMIT 1";
        $remove = db::execute($sql);
        if($remove){
            // Remove the server entries in the log system
            $sql = "DELETE FROM
                        client_servers_log
                    WHERE
                        serverid='".db::escapechars($serverid)."'
                    AND
                        userid='".db::escapechars($userid)."'";
            $removelogs = db::execute($sql);
            if($removelogs){
                $action = db::escapechars($_SESSION['username'])." removed their server - ".db::escapechars($serverid);
            }
            else{
                $action = db::escapechars($_SESSION['username'])." removed server ".db::escapechars($serverid)." but logs could not be removed";
            }
            $this->logevent('Remove Server', $action);
            return true;
        }
        else{
            return false;
        }
    }
    /*
     * Function to pull a specific server's information
     * used in edit screen
     */
    public function getServerInfo($serverid)
    {
        $sql = "SELECT
                    *
                FROM
                    client_servers
                WHERE
                    serverid='".db::escapechars($serverid)."'";
        $result = db::returnrow($sql);
        return $result;
    }

    /*
     * Get the server status for a particular server
     *
     */
    public function getServerStatus($serverid)
    {
        $sql = "SELECT
                    *
                FROM
                    client_servers_log
                WHERE
                    serverid='".db::escapechars($serverid)."'
                ORDER BY
                    dateCreated DESC";
        $serverInfo = db::returnrow($sql);
        return $serverInfo;
    }

    /*
     * Function to generate the server code to be installed on the remote system
     * Generates a text-based PHP output
     */
    public function createServerCode($serverid, $frequency, $iface)
    {
        $serverinfo = $this->getServerInfo($serverid);
        $iface = strip_tags($iface);
        
        if($serverinfo['serverOS'] == "Windows")
        {
            return $this->createWindowsServerCode($serverid, $frequency);

        }

        $mylocations = $this->fileLocations($serverinfo['serverOS']);
        return $this->createUnixServerCode($serverinfo, $mylocations, $frequency, $iface);
    }

    /*
     * Function to create Unix Server Code
     *
     */
    public function createUnixServerCode($serverinfo, $mylocations, $frequency, $iface)
    {
        $myApp = $this->getAppSettings();
        if($myApp['serverName']){
            $serverLocation = $myApp['serverName'];
        }
        else{
            $serverLocation = $_SERVER['SERVER_ADDR'];
        }


        $servercode = "<div class=\"servercode\"><h3>serverGrid.php</h3><br/>&lt;?php<br/>
                        /* <br/>
                        * Filename: serverGrid.php<br/>
                        * Description:<br/>
                        * ServerGrid<br/>
                        * Developed by TohuMuna<br/>
                        * tohumuna.com<br/>
                        * Non-invasive data capture file v1.0.3<br/>
                        */<br/>
                        &dollar;myIdent = \"".$serverinfo['serverIdent']."\";<br/>
                        &dollar;serverid = \"".$serverinfo['serverid']."\";<br/>
                        &dollar;userid = \"".$this->usernametoid($_SESSION['username'])."\";<br/>
                        ";
        $servercode .= "&dollar;spacefree = disk_free_space(\"/\");<br/>
                        &dollar;spacetotal = disk_total_space(\"/\");<br/>
                        &dollar;spaceused = &dollar;spacetotal - &dollar;spacefree;<br/>
                        &dollar;percentfree = sprintf('%.2f',(&dollar;spaceused / &dollar;spacetotal) * 100);<br/>
                        ";

        $servercode .= "&dollar;memfree = shell_exec('".$mylocations['memory']."');<br/>";
        $servercode .= "&dollar;hostname = shell_exec('".$mylocations['hostname']."');<br/>";
        $servercode .= "&dollar;version = shell_exec('".$mylocations['version']."');<br/>";
        $servercode .= "&dollar;uptime = shell_exec('".$mylocations['uptime']."');<br/>";
        $servercode .= "&dollar;loadavg = shell_exec('".$mylocations['loadavg']."');<br/>";
        $servercode .= "&dollar;ipaddress = exec('/sbin/ifconfig ".$iface." |grep \"inet addr\" |awk \"{print &dollar;2}\" |awk -F: \"{print &dollar;2}\"', &dollar;ipoutput);<br/>";
        $servercode .= "&dollar;ipaddress = trim(&dollar;ipoutput[0]);<br/>";
        $servercode .= "&dollar;ipaddress = str_replace('inet addr:','',&dollar;ipaddress);<br/>";
        $servercode .= "&dollar;currentipaddress = explode(' ', &dollar;ipaddress);<br/>";
        $servercode .= "&dollar;spacefree = &dollar;percentfree;<br/>";

        $servercode .="
                        &dollar;url = 'http://".$serverLocation."/api/updateMyGrid.php';<br/>
                        &dollar;fields = array(<br/>
                                                'memfree' => urlencode(&dollar;memfree),<br/>
                                                'hostname' => urlencode(&dollar;hostname),<br/>
                                                'version' => urlencode(&dollar;version),<br/>
                                                'uptime' => urlencode(&dollar;uptime),<br/>
                                                'loadavg' => urlencode(&dollar;loadavg),<br/>
                                                'ipaddress' => urlencode(&dollar;currentipaddress[0]),<br/>
                                                'spacefree' => urlencode(&dollar;percentfree),<br/>
                                                'ident' => urlencode(&dollar;myIdent),<br/>
                                                'serverid' => urlencode(&dollar;serverid),<br/>
                                                'userid' => urlencode(&dollar;userid)<br/>
                                        );<br/>

                        &dollar;fields_string = '';<br/>
                        foreach(&dollar;fields as &dollar;key=>&dollar;value) { &dollar;fields_string .= &dollar;key.'='.&dollar;value.'&'; }<br/>
                        rtrim(&dollar;fields_string, '&');<br/>
                        &dollar;ch = curl_init();<br/>
                        curl_setopt(&dollar;ch,CURLOPT_URL, &dollar;url);<br/>
                        curl_setopt(&dollar;ch,CURLOPT_POSTFIELDS,&dollar;fields_string);<br/>
                        &dollar;result = curl_exec(&dollar;ch);<br/>
                        curl_close(&dollar;ch);<br/>
                        ";
        $servercode .= "?&gt;<br/></div><br/><br/>";

        // Create the cron job code:
        // Frequency used to determine
        $frequency = db::escapechars($frequency);
        if($frequency < 60){
            $servercode .= "<div class=\"servercode\"><h3>Cron Entry</h3><br/><br/>
                        */".$frequency." * * * * /usr/bin/php serverGrid.php<br/></div>";
        }
        else{
            $servercode .= "<div class=\"servercode\"><h3>Cron Entry</h3><br/><br/>
                        0 * * * * /usr/bin/php serverGrid.php<br/></div>";
        }
        return $servercode;
    }

    /*
     * Function to create windows powershell code
     *
     */
    public function createWindowsServerCode($serverinfo, $frequency)
    {
        $myApp = $this->getAppSettings();
        if($myApp['serverName']){
            $serverLocation = $myApp['serverName'];
        }
        else{
            $serverLocation = $_SERVER['SERVER_ADDR'];
        }
        $servercode = "<div class=\"servercode\"><h3>Windows Powershell Code</h3><br/>
		&dollar;at = Get-Date<br/>
		&dollar;duration = [TimeSpan]::MaxValue<br/>
		&dollar;interval = New-TimeSpan -minutes ".$frequency."<br/>
		&dollar;trigger = New-JobTrigger -Once -At $at -RepetitionDuration $duration -RepetitionInterval $interval<br/>
    <br/>
		Unregister-ScheduledJob -Name ServerGrid -Force<br/>
		Register-ScheduledJob -Name ServerGrid -Trigger $trigger -ScriptBlock {<br/>
      <br/>
		&dollar;url = 'http://".$serverLocation."/api/updateMyGrid.php'<br/>
						&dollar;os = Get-WmiObject Win32_OperatingSystem<br/>
						&dollar;myIdent = '".$serverinfo['serverIdent']."'<br/>
						&dollar;serverId = '".$serverinfo['serverid']."'<br/>
						&dollar;userId = '".$this->usernametoid($_SESSION['username'])."'<br/>
						&dollar;memfree = &dollar;os.FreePhysicalMemory<br/>
						&dollar;hostname = hostname<br/>
						&dollar;version = &dollar;os.Version<br/>
						&dollar;uptime = ((Get-Date) - [System.Management.ManagementDateTimeconverter]::ToDateTime(&dollar;os.LastBootUpTime)).TotalSeconds<br/>
						&dollar;proc =get-counter -Counter '\Processor(_Total)\% Processor Time' -SampleInterval 1 -MaxSamples 1<br/>
						&dollar;loadavg =((&dollar;proc.readings -split ':')[-1])/100<br/>
            <br/>
						&dollar;body = 'ident='+&dollar;myIdent+'&serverid='+&dollar;serverId+'&userid='+&dollar;userId+'&memfree=MemFree: '+&dollar;memfree+' kB&hostname='+&dollar;hostname+'&version='+&dollar;version+'&uptime='+&dollar;uptime+'&loadavg='+('{0:N2}' -f &dollar;loadavg)+' 0.00 0.00 0/0 0'<br/>
            <br/>
						&dollar;uri = New-Object System.Uri(&dollar;url)<br/>
						Invoke-WebRequest -Uri &dollar;uri.AbsoluteUri -Method Post -Body &dollar;body<br/>
		}</div>";
        return $servercode;
    }

    /*
     * Function to work out the file locations for files to call
     * which can depend on architecture of the linux system
     */
    public function fileLocations($systemType)
    {

        switch($systemType){


            case "Debian":
                $returnArray = array(
                    'memory'=>'cat /proc/meminfo |grep MemFree',
                    'hostname'=>'cat /etc/hostname',
                    'version'=>'cat /proc/version',
                    'loadavg'=>'cat /proc/loadavg',
                    'uptime'=>'cat /proc/uptime'
                );
                break;

            case "Ubuntu":
                $returnArray = array(
                    'memory'=>'cat /proc/meminfo |grep MemFree',
                    'hostname'=>'cat /etc/hostname',
                    'version'=>'cat /proc/version',
                    'loadavg'=>'cat /proc/loadavg',
                    'uptime'=>'cat /proc/uptime'
                );
                break;

            case "RHEL":
                $returnArray = array(
                    'memory'=>'cat /proc/meminfo |grep MemFree',
                    'hostname'=>'cat /etc/hostname',
                    'version'=>'cat /proc/version',
                    'loadavg'=>'cat /proc/loadavg',
                    'uptime'=>'cat /proc/uptime'
                );
                break;

            default:
                $returnArray = array(
                                    'memory'=>'cat /proc/meminfo |grep MemFree',
                                    'hostname'=>'cat /etc/hostname',
                                    'version'=>'cat /proc/version',
                                    'loadavg'=>'cat /proc/loadavg',
                                    'uptime'=>'cat /proc/uptime'
                                    );
        }
        return $returnArray;
    }


    /*
     * function to get free memory from last update
     *
     */
    public function getFreeMem($serverid)
    {
        $sql = "SELECT
                    freemem
                FROM
                    client_servers_log
                WHERE
                    serverid='".db::escapechars($serverid)."'
                ORDER BY
                    dateCreated
                DESC";
        $result = db::returnrow($sql);
        if($result){
            $freemem = str_replace('MemFree:','',$result['freemem']);
            return $freemem;
        }
        else{
            return "No Value Yet";
        }
    }


    /*
    * function to get free memory from last update
    *
    */
    public function getLoadAverage($serverid)
    {
        $sql = "SELECT
                    loadAverage
                FROM
                    client_servers_log
                WHERE
                    serverid='".db::escapechars($serverid)."'
                ORDER BY
                    dateCreated
                DESC";
        $result = db::returnrow($sql);
        if($result){
            return $result['loadAverage'];
        }
        else{
            return "No Value Yet";
        }
    }

    /*
     * Get all server stats
     * last 24 hours only
     */
    public function getServerStats($userid, $serverid, $startpoint='', $limitvalue='')
    {
        $startdate = date('Y-m-d H:i:s', strtotime("-1 day"));
        $enddate = date('Y-m-d H:i:s');

        $sql = "SELECT
                    *
                FROM
                    client_servers_log
                WHERE
                    userid='".db::escapechars($userid)."'
                AND
                    serverid='".db::escapechars($serverid)."'
                AND
                    dateCreated
                BETWEEN
                    '$startdate' AND '$enddate'
                ORDER BY
                    dateCreated DESC";
        // limit the results displayed
        if($limitvalue){
            $sql .= " LIMIT ".db::escapechars($startpoint)." , ".db::escapechars($limitvalue)."";
        }
        $resultset = db::returnallrows($sql);
        return $resultset;
    }

    /*
     *Check the state of the server
     */
    public function checkServerState($serverid)
    {
        $getstatus = $this->getServerStats($this->usernametoid($_SESSION['username']),$serverid, 0, 1);

                if(!$getstatus){
                    $returnCode = "<div class=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n
                    <h4>&quot;".$this->getServerName($serverid)."&quot; server</h4>\n
                    <p><i class=\"icon-warning-sign\"></i> <strong>Warning!</strong> I haven't seen this server in the past 24 hours!</p>
                    </div><br/>";

                }
        return $returnCode;
    }

    /*
     * Grab the name of the server
     */
    public function getServerName($serverid)
    {
        $sql = "SELECT serverName FROM client_servers WHERE serverid='".db::escapechars($serverid)."'";
        $result = db::returnrow($sql);
        return $result['serverName'];
    }

    /*
    * Get the ID of the server from the name
    *
    */
    public function getServerIDFromName($servername)
    {
      $sql = "SELECT serverid FROM client_servers WHERE serverName='".db::escapechars($servername)."'";
      $result = db::returnrow($sql);
      return $result['serverid'];
    }

    /*
     * Check to see if there's been a change in the ip address of the machine for warning message
     */
    public function checkForipAddressChange($serverid)
    {
        $serverinformation = $this->getServerInfo($serverid);

        $sql = "SELECT
                    *
                FROM
                    client_servers_log
                WHERE
                    serverid='".db::escapechars($serverid)."'
                ORDER BY
                    dateCreated DESC";
        $currentLog = db::returnrow($sql);
        if($serverinformation['ipaddress'] != $currentLog['ipaddress']){
            $returnCode = "<div class=\"alert alert-warning\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n
                    <h4>&quot;".$this->getServerName($serverid)."&quot; server</h4>\n
                    <p><i class=\"icon-warning-sign\"></i> <strong>Warning!</strong> IP Address change from ".$serverinformation['ipaddress']." to ".$currentLog['ipaddress']."</p>
                    </div><br/>";
            return $returnCode;
        }
        else{
            return;
        }
    }

    public function getmyipaddress($serverid)
    {
        $sql = "SELECT ipaddress FROM client_servers WHERE serverid='".db::escapechars($serverid)."'";
        $result = db::returnrow($sql);
        return $result['ipaddress'];
    }


    public function pingServer($ipaddress){
        $starttime = microtime(true);
        $file      = fsockopen ($ipaddress, 80, $errno, $errstr, 10);
        $stoptime  = microtime(true);
        $status    = 0;

        if (!$file){
            // Server unavailable
            return false;
        }
        else {
            fclose($file);
            $status = ($stoptime - $starttime) * 1000;
            $status = floor($status);
            return $status;
        }

    }

    /*
     * Get free disk space figures for / partition on server
     *
     */
    public function getUsedSpace($serverid)
    {
        $sql = "SELECT
                    freedisk
                FROM
                    client_servers_log
                WHERE
                    serverid='".(int)db::escapechars($serverid)."'
                ORDER BY
                    dateCreated DESC";

        $result = db::returnrow($sql);
        return $result['freedisk'];
    }

}

?>
