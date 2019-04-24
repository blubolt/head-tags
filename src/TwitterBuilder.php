<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class TwitterBuilder
 *
 * @link https://dev.twitter.com/cards/markup - specification
 */
class TwitterBuilder extends AbstractBuilder
{
	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this
			->addRule('twitter:card', [$this, 'ruleCommon'], true)
			->addRule('twitter:title', [$this, 'ruleCommon'], true)
			->addAlias('title', 'twitter:title')
			->addRule('twitter:description', [$this, 'ruleCommon'], true)
			->addAlias('description', 'twitter:description')
			->addRule('twitter:site', [$this, 'ruleCommon'], true)
			->addRule('twitter:site:id', [$this, 'ruleCommon'], true)
			->addRule('twitter:creator', [$this, 'ruleCommon'], true)
			->addRule('twitter:creator:id', [$this, 'ruleCommon'], true)
			->addRule('image', [$this, 'ruleImage'], true)
			->addRule('twitter:image', [$this, 'ruleCommon'], true)
			->addRule('twitter:image:alt', [$this, 'ruleCommon'], true)
			->addRule('twitter:player', [$this, 'ruleCommon'], true)
			->addRule('twitter:player:width', [$this, 'ruleCommon'], true)
			->addRule('twitter:player:height', [$this, 'ruleCommon'], true)
			->addRule('twitter:player:stream', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:name:iphone', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:id:iphone', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:url:iphone', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:name:ipad', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:id:ipad', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:url:ipad', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:name:googleplay', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:id:googleplay', [$this, 'ruleCommon'], true)
			->addRule('twitter:app:url:googleplay', [$this, 'ruleCommon'], true);
	}

	/**
	 * @param string   $content
	 * @param string   $name
	 * @param string[] $properties
	 */
	protected function ruleImage(string $content, string $name, array $properties = []): void
	{
		$this->ruleCommon($content, 'twitter:image');
		$alt = $properties['alt'] ?? null;

		if ($alt) {
			$this->ruleCommon($alt, 'twitter:image:alt');
		}
	}

	protected function ruleCommon(string $content, string $name): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('name', $name);
		$el->setAttribute('content', $content);
	}
}
