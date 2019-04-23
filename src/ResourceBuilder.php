<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class ResourceBuilder
 */
class ResourceBuilder extends AbstractBuilder
{
	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this
			->addRule('dns-prefetch', [$this, 'ruleLink'])
			->addRule('preconnect', [$this, 'ruleLink'])
			->addRule('prefetch', [$this, 'ruleLink'])
			->addRule('stylesheet', [$this, 'ruleLink'])
			->addRule('script', [$this, 'ruleScript']);
	}

	/**
	 * @param string   $href
	 * @param string   $rel
	 * @param string[] $attributes
	 */
	protected function ruleLink(string $href, string $rel, array $attributes = []): void
	{
		$el = $this->createElement('link');

		$el->setAttribute('rel', $rel);
		$el->setAttribute('href', $href);

		foreach ($attributes as $name => $value) {
			$el->appendChild($this->createAttribute($name, $value));
		}
	}

	/**
	 * @param string   $src
	 * @param string   $name
	 * @param string[] $attributes
	 */
	protected function ruleScript(string $src, string $name, array $attributes = []): void
	{
		$el = $this->createElement('script');

		$el->setAttribute('type', 'text/javascript');
		$el->setAttribute('src', $src);

		foreach ($attributes as $name => $value) {
			$el->appendChild($this->createAttribute($name, $value));
		}
	}
}
