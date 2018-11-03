<?php

$config = array();

Config::Set('shistoryLimit', 10);

Config::Set('block.rule_sessions', array(
    'action' => array(
        'sessions',
    ),
    'blocks' => array(
        'right' => array('actions/ActionProfile/sidebar.tpl')
    )
));

Config::Set('router.page.sessions', 'PluginSHistory_ActionSessions');

Config::Set('db.table.shistory', '___db.table.prefix___shistory');

return $config;
