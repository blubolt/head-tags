<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderInterface;
use blubolt\HeadTags\OpenGraphBuilder;
use Generator;

/**
 * Class OpenGraphBuilderTest
 */
class OpenGraphBuilderTest extends TestCase
{
	use TestsBuild;

	public function setUp(): void
	{
		$this->builder = new OpenGraphBuilder();
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
				['add', 'og:type', 'website'],
				['add', 'title', 'stub title'],
				['add', 'description', 'stub description'],
				['add', 'image', 'stub image 1', ['alt' => 'stub image 1 alt']],
				['add', 'image', 'stub image 2'],
			],
			__DIR__ . '/assets/OpenGraphBuilder1.html',
		];
	}
}
