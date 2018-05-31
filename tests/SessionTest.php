<?php

namespace Tests\CoRex\Session;

use CoRex\Session\Session;
use PHPUnit\Framework\TestCase;
use stdClass;

class SessionTest extends TestCase
{
    private $namespace1 = 'Namespace 1';
    private $namespace2 = 'Namespace 2';
    private $testName1 = 'test name 1';
    private $testName2 = 'test name 2';
    private $testValue1 = 'test value 1';
    private $testValue2 = 'test value 2';

    /**
     * Test Clear.
     */
    public function testClear()
    {
        // Set test data for non namespace and for namespace.
        Session::set($this->testName1, $this->testValue1);
        Session::set($this->testName2, $this->testValue2, $this->namespace2);

        // Test values set.
        $this->assertEquals($this->testValue1, Session::get($this->testName1));
        $this->assertEquals($this->testValue2, Session::get($this->testName2, null, $this->namespace2));

        // Clear default session and check values.
        Session::clear();
        $this->assertNull(Session::get($this->testName1));
        $this->assertEquals($this->testValue2, Session::get($this->testName2, null, $this->namespace2));

        // Clear default session and check values.
        Session::clear($this->namespace2);
        $this->assertNull(Session::get($this->testName1));
        $this->assertNull(Session::get($this->testName2, null, $this->namespace2));
    }

    /**
     * Test set/get integer.
     */
    public function testSetGetInteger()
    {
        Session::set('test', 4);
        $this->assertTrue(is_int(Session::get('test')));
    }

    /**
     * Test set/get string.
     */
    public function testSetGetString()
    {
        Session::set('test', 'test');
        $this->assertTrue(is_string(Session::get('test')));
    }

    /**
     * Test set/get array.
     */
    public function testSetGetArray()
    {
        Session::set('test', ['test']);
        $this->assertTrue(is_array(Session::get('test')));
        $this->assertEquals([], Session::getArray('unknown'));
    }

    /**
     * Test set/get boolean.
     */
    public function testSetGetBoolean()
    {
        Session::set('test', false);
        $this->assertTrue(is_bool(Session::get('test')));
    }

    /**
     * Test set/get float.
     */
    public function testSetGetFloat()
    {
        Session::set('test', 10.4);
        $this->assertTrue(is_float(Session::get('test')));
    }

    /**
     * Test set/get object.
     */
    public function testSetGetObject()
    {
        Session::set('test', new stdClass());
        $this->assertTrue(is_object(Session::get('test')));
    }

    /**
     * Test set/get null.
     */
    public function testSetGetNull()
    {
        Session::set('test', null);
        $this->assertNull(Session::get('test', 'test'));
    }

    /**
     * Test get array.
     */
    public function testGetArray()
    {
        Session::clear();
        Session::set($this->testName1, $this->testValue1);
        Session::set($this->testName2, $this->testValue2);
        $testArray = [
            $this->testName1 => $this->testValue1,
            $this->testName2 => $this->testValue2
        ];
        $this->assertEquals($testArray, Session::getArray());
    }

    /**
     * Test has.
     */
    public function testHas()
    {
        Session::clear();
        $this->assertFalse(Session::has('test'));
        Session::set('test', 'test');
        $this->assertTrue(Session::has('test'));
    }

    /**
     * Test delete.
     */
    public function testDelete()
    {
        Session::clear();
        Session::set('test', 'test');
        $this->assertTrue(Session::has('test'));
        Session::delete('test');
        $this->assertFalse(Session::has('test'));
    }

    /**
     * Test page clear.
     */
    public function testPageClear()
    {
        // Set test data for non namespace and for namespace.
        Session::pageSet($this->testName1, $this->testValue1, $this->namespace1);
        Session::pageSet($this->testName2, $this->testValue2, $this->namespace2);

        // Test values set.
        $this->assertEquals($this->testValue1, Session::pageGet($this->testName1, null, $this->namespace1));
        $this->assertEquals($this->testValue2, Session::pageGet($this->testName2, null, $this->namespace2));

        // Clear default session and check values.
        Session::pageClear($this->namespace1);
        $this->assertNull(Session::pageGet($this->testName1, null, $this->namespace1));
        $this->assertEquals($this->testValue2, Session::pageGet($this->testName2, null, $this->namespace2));

        // Clear default session and check values.
        Session::pageClear($this->namespace2);
        $this->assertNull(Session::pageGet($this->testName1, null, $this->namespace1));
        $this->assertNull(Session::pageGet($this->testName2, null, $this->namespace2));

        Session::pageClear();
    }

    /**
     * Test page set/get integer.
     */
    public function testPageSetGetInteger()
    {
        Session::pageSet('test', 4, $this->namespace1);
        $this->assertTrue(is_int(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get string.
     */
    public function testPageSetGetString()
    {
        Session::pageSet('test', 'test', $this->namespace1);
        $this->assertTrue(is_string(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get array.
     */
    public function testPageSetGetArray()
    {
        Session::pageSet('test', ['test'], $this->namespace1);
        $this->assertTrue(is_array(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get boolean.
     */
    public function testPageSetGetBoolean()
    {
        Session::pageSet('test', false, $this->namespace1);
        $this->assertTrue(is_bool(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get float.
     */
    public function testPageSetGetFloat()
    {
        Session::pageSet('test', 10.4, $this->namespace1);
        $this->assertTrue(is_float(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get object.
     */
    public function testPageSetGetObject()
    {
        Session::pageSet('test', new stdClass(), $this->namespace1);
        $this->assertTrue(is_object(Session::pageGet('test', null, $this->namespace1)));
    }

    /**
     * Test page set/get null.
     */
    public function testPageSetGetNull()
    {
        Session::pageSet('test', null, $this->namespace1);
        $this->assertNull(Session::pageGet('test', 'test', $this->namespace1));
    }

    /**
     * Test page set/get namespace.
     */
    public function testPageSetNamespace()
    {
        Session::pageSet('test', 'test');
        $this->assertTrue(is_string(Session::pageGet('test')));
    }

    /**
     * Test page get array.
     */
    public function testPageGetArray()
    {
        Session::pageClear($this->namespace1);
        Session::pageSet($this->testName1, $this->testValue1, $this->namespace1);
        Session::pageSet($this->testName2, $this->testValue2, $this->namespace1);
        $testArray = [
            $this->testName1 => $this->testValue1,
            $this->testName2 => $this->testValue2
        ];
        $this->assertEquals($testArray, Session::pageGetArray($this->namespace1));
        $data = Session::pageGetArray();
        $this->assertEquals(['test' => 'test'], $data);
    }

    /**
     * Test page has.
     */
    public function testPageHas()
    {
        Session::pageClear($this->namespace1);
        $this->assertFalse(Session::pageHas('test', $this->namespace1));
        Session::pageSet('test', 'test', $this->namespace1);
        $this->assertTrue(Session::pageHas('test', $this->namespace1));
        $this->assertFalse(Session::pageHas('unknown'));
    }

    /**
     * Test page delete.
     */
    public function testPageDelete()
    {
        Session::pageClear($this->namespace1);

        Session::pageSet('test', 'test', $this->namespace1);
        $this->assertTrue(Session::pageHas('test', $this->namespace1));
        Session::pageDelete('test', $this->namespace1);
        $this->assertFalse(Session::pageHas('test', $this->namespace1));

        Session::pageSet('test', 'test');
        $this->assertTrue(Session::pageHas('test'));
        Session::pageDelete('test');
        $this->assertFalse(Session::pageHas('test'));
    }
}