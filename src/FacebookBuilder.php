<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

/**
 * Class FacebookBuilder
 */
class FacebookBuilder extends AbstractBuilder
{
	/**
	 * @inheritdoc
	 */
	protected function init(): void
	{
		$this
			->addRule('fb:admins', [$this, 'ruleCommon'], true)
			->addRule('fb:app_id', [$this, 'ruleCommon'], true);
	}

	protected function ruleCommon(string $content, string $name): void
	{
		$el = $this->createElement('meta');

		$el->setAttribute('name', $name);
		$el->setAttribute('content', $content);
	}
}
