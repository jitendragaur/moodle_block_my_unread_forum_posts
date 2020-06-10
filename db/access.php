<?php
/**
 * This script is owned by CBlue SPRL, please contact CBlue regarding any licences issues.
 * @author : xinghels@cblue.be
 * @date: 10.06.20
 * @copyright : CBlue SPRL
 */



defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'block/my_unread_forum_posts:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),

    'block/my_unread_forum_posts:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
);
