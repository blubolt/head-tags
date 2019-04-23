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
	/** @var BuilderInterface */
	protected $builder;

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
				['title', 'stub title default'],
				['title', 'stub title'],
				['description', 'stub description'],
				['language', 'stub language'],
				['canonical', 'stub canonical'],
				['image', 'stub image'],
				['og:image', 'stub og:image'],
			],
			__DIR__ . '/assets/BuilderDelegate1.html',
		];
	}
}
