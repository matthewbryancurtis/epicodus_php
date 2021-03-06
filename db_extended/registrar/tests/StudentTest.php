<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once __DIR__."/../src/Student.php";
require_once __DIR__."/../src/Course.php";
require_once __DIR__."/../private/test_db_login.php";

class StudentTest extends PHPUnit_Framework_TestCase {

  function tearDown() {
    Student::deleteAll();
    Course::deleteAll();
    $GLOBALS['DB']->exec("DELETE FROM courses_students");
  }

  function test_construct() {
    $new_student = new Student("James Dean", "10/03/2016");

    $this->assertEquals("James Dean", $new_student->getName());
  }

  function test_save() {
    $new_student = new Student("James Dean", "10/03/2016");
    $new_student->save();

    $query = Student::getAll();

    $this->assertEquals([$new_student], $query);
  }

  function test_getAll() {
    $new_student = new Student("James Dean", "10/03/2016");
    $new_student2 = new Student("Margo Chow", "11/23/2016");
    $new_student->save();
    $new_student2->save();

    $query = Student::getAll();

    $this->assertEquals([$new_student, $new_student2], $query);
  }

  function test_deleteAll() {
    $new_student = new Student("James Dean", "10/03/2016");
    $new_student->save();

    Student::deleteAll();
    $query = Student::getAll();

    $this->assertEquals([], $query);
  }

  function test_addCourse() {
    $new_course = new Course("History", "HIST100");
    $new_course->save();
    $new_student = new Student("James Dean", "10/03/2016");
    $new_student->save();

    $new_student->addCourse($new_course->getId());
    $query = $new_student->getAllCourses();

    $this->assertEquals([$new_course], $query);
  }

  function test_getById() {
    $new_student = new Student("James Dean", "10/03/2016");
    $new_student2 = new Student("Margo Chow", "11/23/2016");
    $new_student->save();
    $new_student2->save();

    $query = Student::getById($new_student2->getId());

    $this->assertEquals($new_student2, $query);
  }

}

?>
