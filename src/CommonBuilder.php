<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class CommonBuilder
 */
class CommonBuilder extends AbstractBuilder
{
	/** @var bool Whether robots are set to noindex */
	private $noindex = false;

	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this
			->addRule('title', [$this, 'ruleTitle'], true)
			->addRule('description', [$this, 'ruleCommon'], true)
			->addRule('robots', [$this, 'ruleRobots'], true)
			->addRule('canonical', [$this, 'ruleCanonical'], true)
			->addRule('prev', [$this, 'ruleLink'], true)
			->addRule('next', [$this, 'ruleLink'], true)
			->addRule('alternate', [$this, 'ruleLink'])
			->addRule('rss', [$this, 'ruleRss'])
			->addRule('viewport', [$this, 'ruleCommon'], true)
			->addRule('content-language', [$this, 'ruleHTTPEquiv'], true)
			->addAlias('language', 'content-language')
			->addRule('content-type', [$this, 'ruleHTTPEquiv'])
			->addRule('charset', [$this, 'ruleCharset'], true)
			->addRule('keywords', [$this, 'ruleCommon'], true)
			->addRule('geo.position', [$this, 'ruleCommon'], true)
			->addRule('geo.placename', [$this, 'ruleCommon'], true)
			->addRule('geo.region', [$this, 'ruleCommon'], true);
	}

	protected function ruleTitle(string $value): void
	{
		$el = $this->createElement('title');
		$el->textContent = $value;
	}

	protected function ruleCommon(string $content, string $name): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('name', $name);
		$el->setAttribute('content', $content);
	}

	protected function ruleRobots(string $directives, string $name): void
	{
		$directives = strtolower($directives);
		$this->noindex = (strpos($directives, 'noindex') !== false);

		$this->ruleCommon($directives, $name);
	}

	protected function ruleCharset(string $charset): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('charset', $charset);
	}

	protected function ruleHTTPEquiv(string $content, string $httpEquiv): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('http-equiv', $httpEquiv);
		$el->setAttribute('content', $content);
	}

	protected function ruleCanonical(string $href, string $rel): void
	{
		if ($this->noindex) {
			// Non-indexed pages do not need a canonical
			return;
		}

		$this->ruleLink($href, $rel);
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

	protected function ruleRss(string $href, string $rel): void
	{
		$this->ruleLink($href, $rel, ['type' => 'application/rss+xml']);
	}
}
