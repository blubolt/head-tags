<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderInterface;
use blubolt\HeadTags\ResourceBuilder;
use Generator;

/**
 * Class ResourceBuilderTest
 */
class ResourceBuilderTest extends TestCase
{
	/** @var BuilderInterface */
	protected $builder;

	public function setUp(): void
	{
		$this->builder = new ResourceBuilder();
	}

	public function tearDown(): void
	{
		unset($this->builder);
	}

	/**
	 * @dataProvider dataBuildSet
	 * @param mixed[] $set
	 * @param string  $result
	 */
	public function testBuild(array $set, string $result): void
	{
		foreach ($set as $args) {
			call_user_func_array([$this->builder, 'add'], $args);
		}

		$this->assertHtmlStringEqualsHtmlFile($result, '<head>' . $this->builder->build() . '</head>');
	}

	public function dataBuildSet(): Generator
	{
		yield [[], __DIR__ . '/assets/EmptyBuilder0.html'];

		yield [
			[
				['dns-prefetch', 'stub dns-prefetch'],
				['preconnect', 'stub preconnect'],
				['prefetch', 'stub prefetch'],
				['stylesheet', 'stub stylesheet'],
				['script', 'stub script'],
				['script', 'stub script', ['async' => null, 'defer' => null]],
			],
			__DIR__ . '/assets/ResourceBuilder1.html',
		];
	}
}
