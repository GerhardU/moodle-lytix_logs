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
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    lytix_logs
 * @author     Guenther Moser
 * @copyright  2020 Educational Technologies, Graz, University of Technology
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace lytix_logs;

/**
 * Class logger
 */
class logger {

    /**
     * @var LOGTABLE Table for the logs.
     */
    const LOGTABLE = 'lytix_logs_logs';

    /**
     * @var TYPE_ADD Type ADD for the logs.
     */
    const TYPE_ADD    = 'ADD';
    /**
     * @var TYPE_EDIT Type EDIT for the logs.
     */
    const TYPE_EDIT   = 'EDIT';
    /**
     * @var TYPE_DELETE Type DELETE for the logs.
     */
    const TYPE_DELETE = 'DELETE';
    /**
     * @var TYPE_OPEN Type OPEN for the logs.
     */
    const TYPE_OPEN   = 'OPEN';
    /**
     * @var TYPE_CLOSE Type CLOSE for the logs.
     */
    const TYPE_CLOSE  = 'CLOSE';
    /**
     * @var TYPE_VIEW Type VIEW for the logs.
     */
    const TYPE_VIEW   = 'VIEW';
    /**
     * @var TYPE_LOAD Type LOAD for the logs.
     */
    const TYPE_LOAD   = 'LOAD';
    /**
     * @var TYPE_UNLOAD Type UNLOAD for the logs.
     */
    const TYPE_UNLOAD = 'UNLOAD';

    /**
     * @var TYPE_EVENT Type EVENT for the logs.
     */
    const TYPE_EVENT     = 'EVENT';
    /**
     * @var TYPE_MILESTONE Type MILESTONE for the logs.
     */
    const TYPE_MILESTONE = 'MILESTONE';
    /**
     * @var TYPE_DIARY Type DIARY for the logs.
     */
    const TYPE_DIARY     = 'DIARY';
    /**
     * @var TYPE_PAGE Type PAGE for the logs.
     */
    const TYPE_PAGE      = 'PAGE';
    /**
     * @var TYPE_MAIL Type Mail for the logs.
     */
    const TYPE_MAIL = 'MAIL';
    /**
     * @var TYPE_MESSAGE Type MESSAGE for the logs.
     */
    const TYPE_MESSAGE = 'MESSAGE';
    /**
     * @var TYPE_REPORT Type REPORT for the logs.
     */
    const TYPE_REPORT = 'REPORT';
    /**
     * @var TYPE_TOGGLE Type TOGGLE for the logs.
     */
    const TYPE_TOGGLE = 'TOGGLE';
    /**
     * @var TYPE_OTHERS Type OTHERS for the logs.
     */
    const TYPE_OTHERS = 'OTHERS';
    /**
     * @var TYPE_CHANGE Type CHANGE for the logs.
     */
    const TYPE_CHANGE = 'CHANGE';
    /**
     * @var TYPE_ACTIVITY Type ACTIVITY for the logs.
     */
    const TYPE_ACTIVITY = 'ACTIVITY';
    /**
     * @var TYPE_CHART Type CHART for the logs.
     */
    const TYPE_CHART = 'CHART';

    /**
     * Add
     * @param int $userid
     * @param int $courseid
     * @param int $contextid
     * @param string $type
     * @param string $target
     * @param int $targetid
     * @param int $time
     * @param string $widget
     * @param string $meta
     * @throws \dml_exception
     */
    public static function add($userid, $courseid, $contextid, $type = self::TYPE_ADD, $target = self::TYPE_EVENT,
                               $targetid = 0, $time = 0, $widget = self::TYPE_PAGE, $meta = '') {
        global $DB;

        $msg            = new \stdClass();
        $msg->userid    = $userid;
        $msg->courseid  = $courseid;
        $msg->contextid = $contextid;
        $msg->type      = $type;
        $msg->target    = $target;
        $msg->targetid  = $targetid;
        $msg->timestamp = ($time == 0) ? time() : $time;
        $msg->widget    = $widget;
        $msg->meta      = $meta;

        $DB->insert_record(self::LOGTABLE, $msg);
    }

    /**
     * Get user logs.
     * @param int $userid
     * @return array
     * @throws \dml_exception
     */
    public static function get_user_logs($userid) {
        global $DB;

        return $DB->get_records(self::LOGTABLE, ['userid' => $userid], 'timestamp DESC');
    }

    /**
     * Get user context logs.
     * @param int $userid
     * @param int $contextid
     * @return array
     * @throws \dml_exception
     */
    public static function get_user_context_logs($userid, $contextid) {
        global $DB;

        return $DB->get_records(self::LOGTABLE, ['userid' => $userid, 'contextid' => $contextid], 'timestamp DESC');
    }
}
