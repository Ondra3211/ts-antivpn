<?php
require_once __DIR__ . "/libraries/TeamSpeak3/TeamSpeak3.php";
require __DIR__ . "/config.php";

TeamSpeak3::init();

msg("Bot Started | AntiVPN 1.1");
msg("PHP " . phpversion() . " | TS3Lib " . TeamSpeak3::LIB_VERSION);
msg("Bot by Ondra3211 | https://github.com/Ondra3211" . PHP_EOL);

try {
    TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyServerselected", "onSelect");
    $uri = "serverquery://" . rawurlencode($cf["connect"]["username"]) . ":" . rawurlencode($cf["connect"]["password"]) . "@{$cf["connect"]["host"]}:{$cf["connect"]["qport"]}/?server_port={$cf["connect"]["vport"]}&nickname=" . rawurlencode($cf["connect"]["nickname"] . "&blocking=0&timeout=5");
    $ts3 = TeamSpeak3::factory($uri);
    while (1) {
        $ts3->getAdapter()->wait();
    }
} catch (TeamSpeak3_Exception $e) {
    msg("Error " . $e->getCode() . ": " . $e->getMessage());
}

function msg($message)
{
    echo "[" . date("d.m.Y H:i:s") . "] {$message}" . PHP_EOL;
}

function onEnter(TeamSpeak3_Adapter_ServerQuery_Event $e, TeamSpeak3_Node_Host $host)
{
    global $cf;
    if ($e["client_type"] !== 1) {
        try {
            $user = $host->serverGetSelected()->clientGetByUid($e["client_unique_identifier"])->getInfo();
            $ip = $user["connection_client_ip"];

            if (IgnoreMe($user["client_servergroups"]) !== true) {
                
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        "X-Key:" . $cf["anti-vpn"]["API-Key"]
                    ],
                    CURLOPT_URL => "http://v2.api.iphub.info/ip/{$ip}"
                ]);

                $result = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($result, true);

                if ($result["block"] == 1 or $result["block"] == 2) {
                    msg("[VPN] " . $user["client_nickname"] . " | " . $ip . " > VPN Detected");
                    $host->serverGetSelected()->clientKick($user["clid"], TeamSpeak3::KICK_SERVER, $cf["anti-vpn"]["kick_message"]);
                } else {
                    msg("[VPN] " . $user["client_nickname"] . " | " . $ip . " > Not VPN");
                }
            } else {
                msg("[VPN] " . $user["client_nickname"] . " | " . $ip . " > Ignored");
            }
        } catch (TeamSpeak3_Exception $e) {
            msg("[VPN] Error " . $e->getCode() . ": " . $e->getMessage());
        }
    }
}

function IgnoreMe($clgroups)
{
    global $cf;
    foreach ($cf["anti-vpn"]["ignored_groups"] as $groups) {
        if (in_array($groups, explode(",", $clgroups))) {
            return true;
        }
    }
}

function onTimeout($seconds, TeamSpeak3_Adapter_ServerQuery $adapter)
{
    if ($adapter->getQueryLastTimestamp() < time() - 250) {
        $adapter->request("clientupdate");
    }
}

function onSelect(TeamSpeak3_Node_Host $host)
{
    global $cf;
    TeamSpeak3_Helper_Signal::getInstance()->subscribe("serverqueryWaitTimeout", "onTimeout");
    TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyCliententerview", "onEnter");
    $host->serverGetSelected()->notifyRegister("server");
    $host->serverGetSelected()->notifyRegister("channel");

    if ($cf["connect"]["default_channel"] != false) {
        $host->serverGetSelected()->clientMove($host->serverGetSelected()->whoamiGet("client_id"), $cf["connect"]["default_channel"]);
    }

    msg("Connected to: " . $host->serverGetSelected()->getProperty("virtualserver_name") . PHP_EOL);
}
