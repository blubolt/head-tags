<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\CommonBuilder;
use Generator;

/**
 * Class CommonBuilderTest
 */
class CommonBuilderTest extends TestCase
{
	use TestsBuild;

	public function setUp(): void
	{
		$this->builder = new CommonBuilder();
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
				['add', 'title', 'stub title'],
			],
			__DIR__ . '/assets/CommonBuilder1.html',
		];

		yield [
			[
				['addIfNotExists', 'title', 'expected'],
				['addIfNotExists', 'title', 'discard'],
			],
			__DIR__ . '/assets/CommonBuilder2.html',
		];
	}
}
