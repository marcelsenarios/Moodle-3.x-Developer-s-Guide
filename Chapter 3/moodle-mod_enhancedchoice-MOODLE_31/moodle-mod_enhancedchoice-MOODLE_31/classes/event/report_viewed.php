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
 * The mod_enhancedchoice report viewed event.
 *
 * @package mod_enhancedchoice
 * @copyright 2017 Ian Wild
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_enhancedchoice\event;
defined('MOODLE_INTERNAL') || die();

/**
 * The mod_enhancedchoice report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string content: (optional) The content we are viewing.
 * }
 *
 * @package    mod_enhancedchoice
 * @since      Moodle 3.1
 * @copyright  2017 Ian Wild
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'choice';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'mod_enhancedchoice');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the report for the enhancedchoice activity with course module id
            '$this->contextinstanceid'";
    }

    /**
     * Returns relevant URL.
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/enhancedchoice/report.php', array('id' => $this->contextinstanceid));
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        $url = new \moodle_url('report.php', array('id' => $this->contextinstanceid));
        return array($this->courseid, 'enhancedchoice', 'report', $url->out(), $this->objectid, $this->contextinstanceid);
    }

    public static function get_objectid_mapping() {
        return array('db' => 'enhancedchoice', 'restore' => 'enhancedchoice');
    }

    public static function get_other_mapping() {
        // No need to map the 'content' value.
        return false;
    }
}