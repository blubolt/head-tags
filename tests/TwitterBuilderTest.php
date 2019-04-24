<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\TwitterBuilder;
use Generator;

/**
 * Class TwitterBuilderTest
 */
class TwitterBuilderTest extends TestCase
{
	use TestsBuild;

	public function setUp(): void
	{
		$this->builder = new TwitterBuilder();
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
				['add', 'twitter:card', 'summary'],
				['add', 'title', 'stub title'],
				['add', 'description', 'stub description'],
			],
			__DIR__ . '/assets/TwitterBuilder1.html',
		];
	}
}
