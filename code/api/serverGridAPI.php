<?php

    /*
    *
    *                                                      .d8888b.          d8b      888 
    *                                                     d88P  Y88b         Y8P      888 
    *                                                     888    888                  888 
    * .d8888b   .d88b.  888d888 888  888  .d88b.  888d888 888        888d888 888  .d88888 
    * 88K      d8P  Y8b 888P"   888  888 d8P  Y8b 888P"   888  88888 888P"   888 d88" 888 
    * "Y8888b. 88888888 888     Y88  88P 88888888 888     888    888 888     888 888  888 
    *      X88 Y8b.     888      Y8bd8P  Y8b.     888     Y88b  d88P 888     888 Y88b 888 
    *  88888P'  "Y8888  888       Y88P    "Y8888  888      "Y8888P88 888     888  "Y88888 
    * ServerGrid API Mechanism
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
    public function updateMyServer($serverid, $userid, $memfree='', $hostname='', $version='', $uptime='', $loadavg='', $ipaddress='', $spacefree='')
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
                freedisk='".db::escapechars($spacefree)."',
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