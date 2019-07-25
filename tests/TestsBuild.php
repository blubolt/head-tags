<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderInterface;
use Exception;

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
			$callable = [$this->builder, $func];

			if (!is_callable($callable)) {
				throw new Exception('Builder not callable');
			}

			call_user_func_array($callable, $args);
		}

		$this->assertHtmlStringEqualsHtmlFile($result, '<head>' . $this->builder->build() . '</head>');
	}
}
