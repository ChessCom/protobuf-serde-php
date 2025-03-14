<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Objects\Schema;

use FlixTech\AvroSerializer\Objects\Schema;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ArrayTypeTest extends TestCase
{
    #[Test]
    public function it_should_serialize_array_types(): void
    {
        $serializedArray = Schema::array()
            ->items(Schema::string())
            ->default(['foo', 'bar'])
            ->serialize();

        $expectedArray = [
            'type' => 'array',
            'items' => 'string',
            'default' => ['foo', 'bar'],
        ];

        $this->assertEquals($expectedArray, $serializedArray);
    }

    #[Test]
    public function it_should_parse_array_types(): void
    {
        $parsedSchema = Schema::array()
            ->items(Schema::string())
            ->default(['foo', 'bar'])
            ->parse();

        $this->assertEquals('array', $parsedSchema->type());
    }
}
