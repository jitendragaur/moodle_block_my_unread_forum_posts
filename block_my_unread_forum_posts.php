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
 * Unread forum post block page
 *
 * @package   blocks
 * @subpackage my_unread_forum_posts
 * @copyright 2013 Jitendra Gaur
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * This block will show number of unread forum post entries with count LIKE - test_forum (1 unread post)
 */
require_once($CFG->dirroot . '/mod/forum/lib.php');

class block_my_unread_forum_posts extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_my_unread_forum_posts');
        $this->content_type = BLOCK_TYPE_TEXT;
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function instance_allow_config() {
        return true;
    }

    function specialization() {
        $this->title = !empty($this->config->title) ? $this->config->title : get_string('pluginname', 'block_my_unread_forum_posts');
    }

    function get_content() {
        global $CFG, $USER, $OUTPUT;

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($this->config->numberofforums)) {
            $this->config->numberofforums = 10;
        }
        if (empty($this->config->forumnamelength)) {
            $this->config->forumnamelength = 15;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        //load all the user courses
        $courses = enrol_get_all_users_courses($USER->id);
        $forumlist = array();
        $counter = 0;

        foreach ($courses as $course) {
            //count the unread forum 
            $forums = forum_tp_get_course_unread_posts($USER->id, $course->id);
            if (!empty($forums)) {
                foreach ($forums as $forum) {
                    if ($cm = get_coursemodule_from_instance('forum', $forum->id, $course->id)) {

                        $viewforumurl = new moodle_url('/mod/forum/view.php', array('id' => $cm->id));
                        $viewcourseurl = new moodle_url('/course/view.php', array('id' => $course->id));
                        $output = '<div style="overflow:hidden;height:auto;"><div>';
                        $icon = '<img src="' . $OUTPUT->pix_url('icon', 'forum') .
                                '" class="icon" alt="" />&nbsp;';
                        $output .= html_writer::link($viewcourseurl, $icon . $course->fullname);
                        //add course separator
                        $output .= ' ' . $this->config->coursenameseparator . ' ';

                        if ($forum->unread == 1) {
                            $formcount = get_string('unreadforumpostsone'
                                    , 'block_my_unread_forum_posts');
                        } else {
                            $formcount = get_string('unreadforumpostsnumber'
                                    , 'block_my_unread_forum_posts', $forum->unread);
                        }
                        $output .= html_writer::link($viewforumurl, shorten_text($cm->name, $this->config->forumnamelength)) . '</div>';
                        $output .= ' <div style="text-align:right;"><span class="unread">&nbsp;' . html_writer::link($viewforumurl, $formcount) . '&nbsp;</span></div>';
                        $output .= '<hr/></div>';
                        $forumlist[] = $output;

                        $counter++;

                        if ($this->config->numberofforums == $counter) {
                            break 2;
                        }
                    }
                }
            }
        }
        if ($counter > 0) {
            $this->content->text = html_writer::alist($forumlist, array('class' => 'list'));
        } else {
            $this->content->text = get_string('nounreadforumpost', 'block_my_unread_forum_posts');
        }
    }

}
