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
* ServerGrid API
*
* Core API mechanisms for the ServerGrid system
*/

class serverGridAPI{


    /*
     * Auth function
     *
     */
    public function doauth($userid, $ident)
    {
        $sql = "SELECT
                    client_servers.serverid
                FROM
                    (
                        users
                        JOIN
                        client_servers
                        ON
                        users.userid=client_servers.userid
                    )
                    WHERE
                        users.userid='".db::escapechars($userid)."'
                        AND
                        client_servers.serverIdent='".db::escapechars($ident)."'";
        $result = db::returnrow($sql);
        if($result){
            return $result['serverid'];
        }
        else{
            return false;
        }
    }



    /*
     * Update server with the minute-by-minute breakdown
     *
     */
    public function updateMyServer($serverid, $userid, $memfree='', $hostname='', $version='', $uptime='', $loadavg='', $ipaddress='')
    {

        $sql = "INSERT INTO client_servers_log
                SET
                serverid='".db::escapechars($serverid)."',
                userid='".db::escapechars($userid)."',
                dateCreated=NOW(),
                freemem='".db::escapechars($memfree)."',
                loadAverage='".db::escapechars($loadavg)."',
                uptime='".db::escapechars($uptime)."',
                kernelVersion='".db::escapechars($version)."',
                hostname='".db::escapechars($hostname)."',
                ipaddress='".db::escapechars($ipaddress)."'
                ";
        $insertLog = db::execute($sql);
        if($insertLog){
            return true;
        }
        else{
            return false;
        }
    }
}


?>