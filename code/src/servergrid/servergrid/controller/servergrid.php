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
* Author: Rick Trotter <rick@pizzaboxsoftware.co.uk>
*
*/

class serverGrid extends MicroFramework{


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
    public function addServer($userid, $serverName, $serverOS)
    {
        $serverident = md5(db::escapechars($serverName).db::escapechars($serverOS).date(YmdHis));

        $sql = "INSERT INTO
                    client_servers
                SET
                    userid='".db::escapechars($userid)."',
                    serverIdent='".$serverident."',
                    serverName='".db::escapechars($serverName)."',
                    serverOS='".db::escapechars($serverOS)."',
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
    public function editServer($serverid, $userid, $serverName, $serverOS)
    {
        $sql = "UPDATE
                    client_servers
                SET
                    serverName='".db::escapechars($serverName)."',
                    serverOS='".db::escapechars($serverOS)."',
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
    public function createServerCode($serverid, $frequency)
    {
        $sql = "SELECT
                    *
                FROM
                    client_servers
                WHERE
                    serverid='".db::escapechars($serverid)."'";
        $serverinfo = db::returnrow($sql);

        $mylocations = $this->fileLocations($serverinfo['serverOS']);


        $servercode = "<h3>serverGrid.php</h3><br/>&lt;?php<br/>
                        /* <br/>
                        * Filename: serverGrid.php<br/>
                        * Description:<br/>
                        * ServerGrid<br/>
                        * Developed by PizzaBoxSoftware.co.uk<br/>
                        * Non-invasive data capture file v1.0.1<br/>
                        */<br/>
                        &dollar;myIdent = \"".$serverinfo['serverIdent']."\";<br/>
                        &dollar;serverid = \"".$serverinfo['serverid']."\";<br/>
                        &dollar;userid = \"".$this->usernametoid($_SESSION['username'])."\";<br/>
                        ";

        $servercode .= "&dollar;memfree =shell_exec('".$mylocations['memory']."');<br/>";
        $servercode .= "&dollar;hostname =shell_exec('".$mylocations['hostname']."');<br/>";
        $servercode .= "&dollar;version =shell_exec('".$mylocations['version']."');<br/>";
        $servercode .= "&dollar;uptime =shell_exec('".$mylocations['uptime']."');<br/>";
        $servercode .= "&dollar;loadavg =shell_exec('".$mylocations['loadavg']."');<br/>";

        $servercode .="
                        &dollar;url = 'http://".$_SERVER['SERVER_ADDR']."/api/updateMyGrid/';<br/>
                        &dollar;fields = array(<br/>
                                                'memfree' => urlencode(&dollar;memfree),<br/>
                                                'hostname' => urlencode(&dollar;hostname),<br/>
                                                'version' => urlencode(&dollar;version),<br/>
                                                'uptime' => urlencode(&dollar;uptime),<br/>
                                                'loadavg' => urlencode(&dollar;loadavg),<br/>
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
        $servercode .= "?&gt;<br/><br/><br/>";

        // Create the cron job code:
        // Frequency used to determine
        $frequency = db::escapechars($frequency);
        if($frequency < 60){
            $servercode .= "<h3>Cron Entry</h3><br/><br/>
                        */".$frequency." * * * * /usr/bin/php serverGrid.php<br/>";
        }
        else{
            $servercode .= "<h3>Cron Entry</h3><br/><br/>
                        0 * * * * /usr/bin/php serverGrid.php<br/>";
        }
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
    public function getServerStats($userid, $serverid)
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
                    dateCreated ASC";

        $resultset = db::returnallrows($sql);
        return $resultset;
    }

    public function checkServerState($serverid)
    {
        $getstatus = $this->getServerStats($this->usernametoid($_SESSION['username']),$serverid);

                if(!$getstatus){
                    $returnCode = "<div class=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>\n
                    <h4>&quot;".$this->getServerName($serverid)."&quot; server</h4>\n
                    <p><strong>Warning!</strong> I haven't seen this server in the past 24 hours!</p>
                    </div><br/>";

                }
        return $returnCode;
    }

    public function getServerName($serverid)
    {
        $sql = "SELECT serverName FROM client_servers WHERE serverid='".db::escapechars($serverid)."'";
        $result = db::returnrow($sql);
        return $result['serverName'];
    }
}

?>