<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class BuilderDelegate
 */
class BuilderDelegate implements BuilderInterface
{
	/** @var BuilderInterface[] */
	protected $builders;

	/**
	 * BuilderDelegate constructor.
	 */
	public function __construct(BuilderInterface ...$builders)
	{
		$this->builders = $builders;
	}

	/**
	 * @inheritdoc
	 */
	public function add(string $name, string $value, array $attributes = []): BuilderInterface
	{
		foreach ($this->builders as $builder) {
			$builder->add($name, $value, $attributes);
		}

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function build(): string
	{
		$build = '';

		foreach ($this->builders as $builder) {
			$build .= $builder->build();
		}

		return $build;
	}
}
