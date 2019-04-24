<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class OpenGraphBuilder
 *
 * @link http://ogp.me/ - specification
 */
class OpenGraphBuilder extends AbstractBuilder
{
	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this
			->addRule('og:type', [$this, 'ruleCommon'], true)
			->addRule('og:title', [$this, 'ruleCommon'], true)
			->addAlias('title', 'og:title')
			->addRule('og:description', [$this, 'ruleCommon'], true)
			->addAlias('description', 'og:description')
			->addRule('og:url', [$this, 'ruleCommon'], true)
			->addAlias('canonical', 'og:url')
			->addRule('og:determiner', [$this, 'ruleCommon'], true)
			->addRule('og:locale', [$this, 'ruleCommon'], true)
			->addAlias('language', 'og:locale')
			->addRule('og:locale:alternate', [$this, 'ruleCommon'], true)
			->addRule('og:site_name', [$this, 'ruleCommon'], true)
			->addRule('og:image', [$this, 'ruleImage'])
			->addAlias('image', 'og:image')
			->addRule('og:audio', [$this, 'ruleAudio'])
			->addRule('og:video', [$this, 'ruleVideo'])
			->addRule('article:published_time', [$this, 'ruleCommon'], true)
			->addRule('article:modified_time', [$this, 'ruleCommon'], true)
			->addRule('article:expiration_time', [$this, 'ruleCommon'], true)
			->addRule('article:author', [$this, 'ruleCommon'])
			->addRule('article:section', [$this, 'ruleCommon'])
			->addRule('article:tag', [$this, 'ruleCommon'])
			->addRule('book:author', [$this, 'ruleCommon'])
			->addRule('book:isbn', [$this, 'ruleCommon'])
			->addRule('book:release_date', [$this, 'ruleCommon'])
			->addRule('book:tag', [$this, 'ruleCommon'])
			->addRule('profile:first_name', [$this, 'ruleCommon'])
			->addRule('profile:last_name', [$this, 'ruleCommon'])
			->addRule('profile:username', [$this, 'ruleCommon'])
			->addRule('profile:gender', [$this, 'ruleCommon'])
			->addRule('music:duration', [$this, 'ruleCommon'])
			->addRule('music:album', [$this, 'ruleCommon'])
			->addRule('music:album:disc', [$this, 'ruleCommon'])
			->addRule('music:album:track', [$this, 'ruleCommon'])
			->addRule('music:musician', [$this, 'ruleCommon'])
			->addRule('music:song', [$this, 'ruleCommon'])
			->addRule('music:song:disc', [$this, 'ruleCommon'])
			->addRule('music:song:track', [$this, 'ruleCommon'])
			->addRule('music:release_date', [$this, 'ruleCommon'])
			->addRule('music:creator', [$this, 'ruleCommon'])
			->addRule('video:actor', [$this, 'ruleCommon'])
			->addRule('video:actor:role', [$this, 'ruleCommon'])
			->addRule('video:director', [$this, 'ruleCommon'])
			->addRule('video:writer', [$this, 'ruleCommon'])
			->addRule('video:duration', [$this, 'ruleCommon'])
			->addRule('video:release_date', [$this, 'ruleCommon'])
			->addRule('video:tag', [$this, 'ruleCommon'])
			->addRule('video:series', [$this, 'ruleCommon']);
	}

	/**
	 * @param string   $content
	 * @param string   $name
	 * @param string[] $properties
	 */
	protected function ruleImage(string $content, string $name, array $properties = []): void
	{
		$this->ruleStructured($content, 'og:image', $properties, ['secure_url', 'type', 'width', 'height', 'alt']);
	}

	/**
	 * @param string   $content
	 * @param string   $name
	 * @param string[] $properties
	 */
	protected function ruleVideo(string $content, string $name, array $properties = []): void
	{
		$this->ruleStructured($content, 'og:video', $properties, ['secure_url', 'type', 'width', 'height']);
	}

	/**
	 * @param string   $content
	 * @param string   $name
	 * @param string[] $properties
	 */
	protected function ruleAudio(string $content, string $name, array $properties = []): void
	{
		$this->ruleStructured($content, 'og:audio', $properties, ['secure_url', 'type']);
	}

	/**
	 * @param string   $content
	 * @param string   $name
	 * @param string[] $properties
	 * @param string[] $allowedProperties
	 */
	protected function ruleStructured(
		string $content,
		string $name,
		array $properties = [],
		array $allowedProperties = []
	): void {
		$this->ruleCommon($content, $name);

		foreach ($properties as $property => $value) {
			if (!in_array($property, $allowedProperties, true)) {
				continue;
			}

			$this->ruleCommon($value, $name . ':' . $property);
		}
	}

	protected function ruleCommon(string $content, string $name): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('property', $name);
		$el->setAttribute('content', $content);
	}
}
