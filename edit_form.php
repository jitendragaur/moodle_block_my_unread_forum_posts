<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * My unread forum posts block edit form page 
 *
 * @package   blocks
 * @subpackage my_unread_forum_posts
 * @copyright 2013 Jitendra Gaur
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_my_unread_forum_posts_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_my_unread_forum_posts'));
        $mform->setType('config_title', PARAM_MULTILANG);
        $mform->setDefault('config_title', get_string('pluginname', 'block_my_unread_forum_posts'));

        $numberofforums = array();
        for ($i = 1; $i <= 30; $i++) {
            $numberofforums[$i] = $i;
        }

        $seprator = array('&raquo' => '&raquo',
            '&#8211' => '&#8211',
            '&rarr;' => '&rarr;',
            '&#58' => '&#58',
            '&#62;' => '&#62;',
            '&nbsp;' => '&nbsp;');

        $mform->addElement('select', 'config_numberofforums', get_string('numentriestodisplay', 'block_my_unread_forum_posts'), $numberofforums);
        $mform->setDefault('config_numberofforums', 10);

        $mform->addElement('select', 'config_coursenameseparator', get_string('coursenameseparator', 'block_my_unread_forum_posts'), $seprator);
        $mform->setDefault('config_coursenameseparator', 0);

        $mform->addElement('select', 'config_forumnamelength', get_string('forumnamelength', 'block_my_unread_forum_posts'), $numberofforums);
        $mform->setDefault('config_forumnamelength', 15);
    }

}
