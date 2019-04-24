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
	use TestsBuild;

	public function setUp(): void
	{
		$this->builder = new ResourceBuilder();
	}

	public function tearDown(): void
	{
		unset($this->builder);
	}

	public function dataBuildSet(): Generator
	{
		yield [[], __DIR__ . '/assets/EmptyBuilder0.html'];

		yield [
			[
				['add', 'dns-prefetch', 'stub dns-prefetch'],
				['add', 'preconnect', 'stub preconnect'],
				['add', 'prefetch', 'stub prefetch'],
				['add', 'stylesheet', 'stub stylesheet'],
				['add', 'script', 'stub script'],
				['add', 'script', 'stub script', ['async' => null, 'defer' => null]],
			],
			__DIR__ . '/assets/ResourceBuilder1.html',
		];
	}
}
