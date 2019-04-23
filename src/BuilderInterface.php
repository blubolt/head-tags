<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Interface BuilderInterface
 */
interface BuilderInterface
{
	/**
	 * Add property to builder
	 *
	 * @param string   $name
	 * @param string   $value
	 * @param string[] $attributes
	 * @return static
	 */
	public function add(string $name, string $value, array $attributes = []): BuilderInterface;

	/**
	 * Build content which based on properties
	 *
	 * @return string
	 */
	public function build(): string;
}
