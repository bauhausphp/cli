<?php

namespace Bauhaus\Cli\Attribute;

use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function invalidNames(): array
    {
        return [
            ['inv lid'],
            ['inv@lid'],
            [' invalid'],
            [''],
            ['-'],
            ['invalid:'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidNames
     */
    public function throwExceptionIfNameIsInvalid(string $invalid): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage("Invalid cli argument: '$invalid'");

        new Name($invalid);
    }

    public function validNames(): array
    {
        return [
            ['valid'],
            ['val:id'],
            ['va:aa:lid'],
            ['v:aa:lid'],
            ['v:a:lid'],
            ['val_id'],
            ['val-id'],
            ['val-i_d'],
            ['val_-id'],
        ];
    }

    /**
     * @test
     * @dataProvider validNames
     */
    public function convertToString(string $str): void
    {
        $name = new Name($str);

        $this->assertEquals($str, (string) $name);
    }

    /**
     * @test
     */
    public function returnTrueIfTwoNameAreEqual(): void
    {
        $name = new Name('something');

        $this->assertTrue($name->equalTo(new Name('something')));
    }

    /**
     * @test
     */
    public function returnFalseIfTwoNameAreNotEqual(): void
    {
        $name = new Name('something');

        $this->assertFalse($name->equalTo(new Name('anotherThing')));
    }
}
