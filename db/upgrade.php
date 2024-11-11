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
 * Upgrade changes between versions
 *
 * @package   lytix_logs
 * @author    Günther Moser <moser@tugraz.at>
 * @copyright 2021 Educational Technologies, Graz, University of Technology
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or laterB
 */

/**
 * Upgrade Measure Basic DB
 * @param int $oldversion
 * @return bool
 * @throws ddl_exception
 * @throws downgrade_exception
 * @throws upgrade_exception
 */
function xmldb_lytix_logs_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2023091100) {

        // Define field widget to be added to lytix_logs_logs.
        $table = new xmldb_table('lytix_logs_logs');
        $field = new xmldb_field('widget', XMLDB_TYPE_TEXT, null, null, null, null, null, 'timestamp');

        // Conditionally launch add field widget.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        $field = new xmldb_field('meta', XMLDB_TYPE_TEXT, null, null, null, null, null, 'widget');

        // Conditionally launch add field meta.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Logs savepoint reached.
        upgrade_plugin_savepoint(true, 2023091100, 'lytix', 'logs');
    }

    if ($oldversion < 2024111100) {
        global $DB;
        // Delete deleted users from table 'lytix_logs_logs'.
        $DB->delete_records_select('lytix_logs_logs',
                'userid IN (SELECT id FROM  {user} WHERE deleted = 1)');

        // Delete non-existing courses from table 'lytix_logs_logs'.
        $DB->delete_records_select('lytix_logs_logs',
                'courseid NOT IN (SELECT id FROM  {course})');

        // Delete deleted users from table 'lytix_logs_aggregated_logs'.
        $DB->delete_records_select('lytix_logs_aggregated_logs',
                'userid IN (SELECT id FROM  {user} WHERE deleted = 1)');

        // Delete non-existing courses from table 'lytix_logs_aggregated_logs'.
        $DB->delete_records_select('lytix_logs_aggregated_logs',
                'courseid NOT IN (SELECT id FROM  {course})');

        // Coursepolicy savepoint reached.
        upgrade_plugin_savepoint(true, 2024111100, 'lytix', 'logs');
    }

    return true;
}
