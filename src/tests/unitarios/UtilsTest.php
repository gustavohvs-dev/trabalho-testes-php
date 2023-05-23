<?php

use app\models\impetus\ImpetusUtils;
use PHPUnit\Framework\TestCase;

include_once "app/models/impetus/ImpetusUtils.php";

class UtilsTest extends TestCase
{

    public function testIsDateSucess()
    {
        $response = ImpetusUtils::isDate("01/02/2003");
        $this->assertEquals(true, $response);
    }

    public function testIsDateError()
    {
        $response = ImpetusUtils::isDate("02/43/2031");
        $this->assertEquals(false, $response);
    }

    public function testIsEmailSucess()
    {
        $response = ImpetusUtils::isEmail("email@email.com.br");
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isEmail("email@email.com");
        $this->assertEquals(true, $response);
    }

    public function testIsEmailError()
    {
        $response = ImpetusUtils::isEmail("email");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isEmail("email.com.br");
        $this->assertEquals(false, $response);
    }

    public function testIsBooleanSucess()
    {
        $response = ImpetusUtils::isBoolean(true);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isBoolean(1);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isBoolean(false);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isBoolean(0);
        $this->assertEquals(true, $response);
    }

    public function testIsBooleanError()
    {
        $response = ImpetusUtils::isBoolean("1");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isBoolean("0");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isBoolean("true");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isBoolean("false");
        $this->assertEquals(false, $response);
    }

    public function testIsPasswordSucess()
    {
        $response = ImpetusUtils::isPassword("Test#123");
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isPassword("1234@Test1");
        $this->assertEquals(true, $response);
    }

    public function testIsPasswordError()
    {
        $response = ImpetusUtils::isPassword("emailtst");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isPassword("emailtestecombr");
        $this->assertEquals(false, $response);
    }
    public function testIsStrongPasswordSuccess()
    {
        $response = ImpetusUtils::isStrongPassword("ComedorDeKsada@12358");
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isStrongPassword("KsadaQda@12377");
        $this->assertEquals(true, $response);
    }

    public function testIsStrongPasswordError()
    {
        $response = ImpetusUtils::isStrongPassword("1234");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isStrongPassword("Abcd1234");
        $this->assertEquals(false, $response);
    }

    public function testIsIntSuccess()
    {
        $response = ImpetusUtils::isInt(-4);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::isInt(12);
        $this->assertEquals(true, $response);
    }

    public function testIsIntError()
    {
        $response = ImpetusUtils::isInt(1.2);
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::isInt("1.4");
        $this->assertEquals(false, $response);
    }

    public function testIsNumberSuccess()
    {
        $response = ImpetusUtils::IsNumber("123");
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::IsNumber(12);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::IsNumber(1.432);
        $this->assertEquals(true, $response);
        $response = ImpetusUtils::IsNumber(-34);
        $this->assertEquals(true, $response);
    }

    public function testIsNumberError()
    {
        $response = ImpetusUtils::IsNumber("teste");
        $this->assertEquals(false, $response);
        $response = ImpetusUtils::IsNumber("1.43f");
        $this->assertEquals(false, $response);
    }

}