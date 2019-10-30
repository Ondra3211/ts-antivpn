<?php
// Teamspeak Server Connection

$cf["connect"] = [
	"username" => "serveradmin",
	"password" => "2lM3Nop6",
	"host" => "127.0.0.1",
	"qport" => "10011",
	"vport" => "9987",
	"nickname" => "Anti VPN",
	"default_channel" => false // false to disable
];

// https://iphub.info

$cf["anti-vpn"] = [
	"API-Key" => "",
	"ignored_groups" => array(51594, 51618, 52335, 51601, 51606, 51620, 51602, 51607, 51604, 51608, 51605, 51609, 51592, 51622, 51610),
	"kick_message" => "VPN Is not allowed!"
];
?>
