<?php

namespace Haritsyp\Snowflake\Tests;

use PHPUnit\Framework\TestCase;
use Haritsyp\Snowflake\Snowflake;

class SnowflakeTest extends TestCase
{
    /** @test */
    public function it_generates_int64_id()
    {
        $sf = new Snowflake(1, 3, 'int');
        $id = $sf->nextId();
        $this->assertIsInt($id);
        $parsed = Snowflake::parse($id);

        $this->assertEquals(1, $parsed['datacenter']);
        $this->assertEquals(3, $parsed['node']);
        $this->assertIsInt($parsed['sequence']);
        $this->assertNotNull($parsed['timestamp']);
    }

    /** @test */
    public function it_generates_base62_id()
    {
        $sf = new Snowflake(2, 4, 'base62');
        $idStr = $sf->nextId();

        $this->assertIsString($idStr);
        $parsed = Snowflake::parse($idStr);

        $this->assertEquals(2, $parsed['datacenter']);
        $this->assertEquals(4, $parsed['node']);
        $this->assertIsInt($parsed['sequence']);
        $this->assertNotNull($parsed['timestamp']);
    }

    /** @test */
    public function it_can_parse_id_correctly()
    {
        $sf = new Snowflake(1, 1, 'int');
        $id = $sf->nextId();

        $parsed = Snowflake::parse($id);

        $this->assertArrayHasKey('timestamp', $parsed);
        $this->assertArrayHasKey('datacenter', $parsed);
        $this->assertArrayHasKey('node', $parsed);
        $this->assertArrayHasKey('sequence', $parsed);
    }
}
