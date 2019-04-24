<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderInterface;

/**
 * TestsBuild Trait
 */
trait TestsBuild
{
	/** @var BuilderInterface */
	protected $builder;

	/**
	 * @dataProvider dataBuildSet
	 * @param mixed[] $set
	 * @param string  $result
	 */
	public function testBuild(array $set, string $result): void
	{
		foreach ($set as $args) {
			$func = array_shift($args);
			call_user_func_array([$this->builder, $func], $args);
		}

		$this->assertHtmlStringEqualsHtmlFile($result, '<head>' . $this->builder->build() . '</head>');
	}
}
