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
 * Unit Tests for the logger helperclass
 *
 * @package    lytix_logs
 * @category   test
 * @author     Guenther Moser
 * @copyright  2020 Educational Technologies, Graz, University of Technology
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace lytix_logs;

use advanced_testcase;
use dml_exception;
use \lytix_logs\logger;
use local_lytix\helper\tests;

/**
 * Class logger_test
 * @coversDefaultClass \lytix_logs\logger
 */
class logger_test extends advanced_testcase {
    /**
     * Setup called before any test case.
     */
    protected function setUp(): void {
        global $DB, $CFG;

        // Create test teacher.
        if (!$DB->record_exists('user', ['username' => 'testteacher'])) {
            $newuser             = new \stdClass();
            $newuser->username   = 'teacher';
            $newuser->auth       = 'manual';
            $newuser->confirmed  = true;
            $newuser->mnethostid = $CFG->mnet_localhost_id;
            $newuser->firstname  = 'Teacher';
            $newuser->lastname   = 'Rehcaet';
            $newuser->email      = 'teacher@example.org';
            $newuser->password   = 'Teacher1!';

            $newuser = $this->getDataGenerator()->create_user($newuser);
        }

        // Create test student.
        if (!$DB->record_exists('user', ['username' => 'teststudent1'])) {
            $newuser             = new \stdClass();
            $newuser->username   = 'student';
            $newuser->auth       = 'manual';
            $newuser->confirmed  = true;
            $newuser->mnethostid = $CFG->mnet_localhost_id;
            $newuser->firstname  = 'Student';
            $newuser->lastname   = 'Tneduts';
            $newuser->email      = 'student@example.org';
            $newuser->password   = 'Student1!';
            $newuser             = $this->getDataGenerator()->create_user($newuser);
        }

        // Create test course.
        if (!$DB->record_exists('course', array('shortname' => 'testcourse'))) {
            $course            = new \stdClass();
            $course->fullname  = 'Test Course';
            $course->shortname = 'testcourse';
            $course->category  = 1; // Ignore categories and set all to miscellaneos.

            $newcourse = $this->getDataGenerator()->create_course((array) $course);
            $courseid  = $newcourse->id;

            // Enrol test teacher.
            $enrol    = enrol_get_plugin('manual');
            $instance = $DB->get_record('enrol', ['enrol' => 'manual', 'courseid' => $courseid]);

            $roleid  = $DB->get_record('role', ['shortname' => 'editingteacher'], '*')->id;
            $teacher = $DB->get_record('user', ['username' => 'teacher']);
            $enrol->enrol_user($instance, $teacher->id, $roleid, time(), 0, null, false);

            // Enrol test student.
            $enrol   = enrol_get_plugin('manual');
            $roleid  = $DB->get_record('role', ['shortname' => 'student'], '*')->id;
            $student = $DB->get_record('user', ['username' => 'student']);
            $enrol->enrol_user($instance, $student->id, $roleid, time(), 0, null, false);
        }
    }

    /**
     * Test add
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_add() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_EVENT, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_MILESTONE, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test edit
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_edit() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_EDIT, logger::TYPE_EVENT, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_EDIT, logger::TYPE_MILESTONE, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test delete
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_delete() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_DELETE, logger::TYPE_EVENT, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_DELETE, logger::TYPE_MILESTONE, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test open
     * @covers ::add
     * @covers ::get_user_context_logs
     * @throws dml_exception
     */
    public function test_log_open() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_EVENT, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_MILESTONE, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test close
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_close() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_CLOSE, logger::TYPE_EVENT, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_CLOSE, logger::TYPE_MILESTONE, 1);
        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(1, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test all
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_all() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_EDIT, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_CLOSE, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_DELETE, logger::TYPE_EVENT, 1);

        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(6, count($logs), 'There should be exactly one log for this user');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_EDIT, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_CLOSE, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_DELETE, logger::TYPE_MILESTONE, 1);

        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(6, count($logs), 'There should be exactly one log for this user');
    }

    /**
     * Test different target
     * @covers ::get_user_context_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_diff_target() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_EVENT, 2);

        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(2, count($logs), 'There should be exactly two logs for this user.');
        $this->assertEquals(1, reset($logs)->targetid, 'Wrong target.');
        $this->assertEquals(2, end($logs)->targetid, 'Wrong target.');

        $student = $DB->get_record('user', ['username' => 'student']);

        logger::add($student->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_MILESTONE, 1);
        logger::add($student->id, $course->id, $context->id, logger::TYPE_OPEN, logger::TYPE_MILESTONE, 2);

        $logs = logger::get_user_context_logs($teacher->id, $context->id);
        $this->assertEquals(2, count($logs), 'There should be exactly two logs for this user.');
        $this->assertEquals(1, reset($logs)->targetid, 'Wrong target.');
        $this->assertEquals(2, end($logs)->targetid, 'Wrong target.');
    }

    /**
     * Test different course
     * @covers ::get_user_logs
     * @covers ::add
     * @throws dml_exception
     */
    public function test_log_diff_courses() {
        $this->resetAfterTest(true);

        global $DB;

        $course  = $DB->get_record('course', ['shortname' => 'testcourse']);
        $context = \context_course::instance($course->id);
        $teacher = $DB->get_record('user', ['username' => 'teacher']);

        $newcourse  = $this->getDataGenerator()->create_course();
        $newcontext = \context_course::instance($newcourse->id);

        logger::add($teacher->id, $course->id, $context->id, logger::TYPE_ADD, logger::TYPE_EVENT, 1);
        logger::add($teacher->id, $newcourse->id, $newcontext->id, logger::TYPE_ADD, logger::TYPE_EVENT, 1);

        $logs = logger::get_user_logs($teacher->id);
        $this->assertEquals(2, count($logs), 'There should be exactly two logs for this user.');

    }
}
