<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Objects\Schema;

use FlixTech\AvroSerializer\Objects\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LogicalTypeTest extends TestCase
{
    #[Test]
    #[DataProvider('provideLogicalTypes')]
    public function it_should_serialize_simple_logical_types(Schema $type, string $expectedAnnotatedType, string $expectedLogicalType): void
    {
        $expectedSchema = [
            'type' => $expectedAnnotatedType,
            'logicalType' => $expectedLogicalType,
        ];

        $this->assertEquals($expectedSchema, $type->serialize());
    }

    #[Test]
    #[DataProvider('provideLogicalTypes')]
    public function it_should_parse_simple_logical_types(Schema $type, string $expectedType, string $expectedLogicalType): void
    {
        $parsedSchema = $type->parse();
        $this->assertEquals($expectedType, $parsedSchema->type());
        $this->assertEquals($expectedLogicalType, $parsedSchema->logical_type());
    }

    #[Test]
    public function it_should_serialize_duration_types(): void
    {
        $schema = Schema::duration()
            ->name('User')
            ->namespace('org.acme')
            ->aliases('foobar')
            ->serialize();

        $expected = [
            'logicalType' => 'duration',
            'type' => 'fixed',
            'name' => 'User',
            'namespace' => 'org.acme',
            'aliases' => ['foobar'],
            'size' => 12,
        ];

        $this->assertEquals($expected, $schema);
    }

    #[Test]
    public function it_should_parse_duration_types(): void
    {
        $parsedSchema = Schema::duration()
            ->name('User')
            ->namespace('org.acme')
            ->aliases('foobar')
            ->parse();

        $this->assertEquals('fixed', $parsedSchema->type());
        $this->assertEquals('duration', $parsedSchema->logical_type());
    }

    public static function provideLogicalTypes(): array
    {
        return [
            'uuid' => [Schema::uuid(), 'string', 'uuid'],
            'date' => [Schema::date(), 'int', 'date'],
            'time-millis' => [Schema::timeMillis(), 'int', 'time-millis'],
            'time-micros' => [Schema::timeMicros(), 'long', 'time-micros'],
            'timestamp-millis' => [Schema::timestampMillis(), 'long', 'timestamp-millis'],
            'timestamp-micros' => [Schema::timestampMicros(), 'long', 'timestamp-micros'],
            'local-timestamp-millis' => [Schema::localTimestampMillis(), 'long', 'local-timestamp-millis'],
            'local-timestamp-micros' => [Schema::localTimestampMicros(), 'long', 'local-timestamp-micros'],
        ];
    }
}
