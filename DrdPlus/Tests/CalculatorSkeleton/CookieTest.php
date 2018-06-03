<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\CalculatorSkeleton;

use Granam\Tests\Tools\TestWithMockery;

class CookieTest extends TestWithMockery
{
    /**
     * @test
     * @runInSeparateProcess
     * @backupGlobals enabled
     */
    public function I_can_set_get_and_delete_cookie(): void
    {
        self::assertNull(Cookie::getCookie('foo'));
        self::assertTrue(Cookie::setCookie('foo', 'bar'));
        self::assertSame('bar', Cookie::getCookie('foo'));
        self::assertSame('bar', $_COOKIE['foo'] ?? false);
        self::assertTrue(Cookie::deleteCookie('foo'));
        self::assertNull(Cookie::getCookie('foo'));
        self::assertFalse(array_key_exists('foo', $_COOKIE));
    }
}