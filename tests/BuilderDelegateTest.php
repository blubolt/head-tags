<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderDelegate;
use blubolt\HeadTags\BuilderInterface;
use blubolt\HeadTags\CommonBuilder;
use blubolt\HeadTags\OpenGraphBuilder;
use blubolt\HeadTags\TwitterBuilder;
use Generator;

/**
 * Class BuilderDelegateTest
 */
class BuilderDelegateTest extends TestCase
{
	use TestsBuild;

	public function setUp(): void
	{
		$this->builder = new BuilderDelegate(
			new CommonBuilder(),
			new TwitterBuilder(),
			new OpenGraphBuilder()
		);
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
				['add', 'title', 'stub title default'],
				['add', 'title', 'stub title'],
				['add', 'description', 'stub description'],
				['add', 'language', 'stub language'],
				['add', 'canonical', 'stub canonical'],
				['add', 'image', 'stub image'],
				['add', 'og:image', 'stub og:image'],
			],
			__DIR__ . '/assets/BuilderDelegate1.html',
		];

		yield [
			[
				['addIfNotExists', 'title', 'expected'],
				['addIfNotExists', 'title', 'discard'],
			],
			__DIR__ . '/assets/BuilderDelegate2.html',
		];
	}
}
