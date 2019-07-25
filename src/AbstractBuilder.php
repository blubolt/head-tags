<?php

declare(strict_types=1);

namespace blubolt\HeadTags;

use DOMAttr;
use DOMDocument;
use DOMElement;

/**
 * Class AbstractBuilder
 */
abstract class AbstractBuilder implements BuilderInterface
{
	/** @var DOMDocument */
	protected $document;

	/** @var mixed[] */
	private $values = [];

	/** @var mixed[] */
	private $rules = [];

	/** @var string[] */
	private $aliases = [];

	/**
	 * AbstractBuilder constructor.
	 */
	final public function __construct()
	{
		$this->document = new DOMDocument();
		$this->document->formatOutput = true;

		$this->init();
	}

	/**
	 * @inheritdoc
	 */
	final public function add(string $name, string $value, array $attributes = []): BuilderInterface
	{
		if (array_key_exists($name, $this->aliases)) {
			$name = $this->aliases[$name];
		}

		if (!array_key_exists($name, $this->rules)) {
			return $this;
		}

		[, $unique] = $this->rules[$name];

		if ($unique) {
			$this->values[$name] = [];
		}

		$this->values[$name][] = [$value, $attributes];

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	final public function addIfNotExists(string $name, string $value, array $attributes = []): BuilderInterface
	{
		if (array_key_exists($name, $this->aliases)) {
			$name = $this->aliases[$name];
		}

		if (array_key_exists($name, $this->values)) {
			return $this;
		}

		return $this->add($name, $value, $attributes);
	}

	/**
	 * @inheritdoc
	 */
	final public function build(): string
	{
		foreach ($this->rules as $name => $rule) {
			$entries = $this->values[$name] ?? [];
			foreach ($entries as [$value, $attributes]) {
				[$callable] = $this->rules[$name];
				call_user_func($callable, $value, $name, $attributes);
			}
		}

		return trim((string)$this->document->saveHTML());
	}

	/**
	 * @param string $alias
	 * @param string $name
	 * @return static
	 */
	final protected function addAlias(string $alias, string $name): BuilderInterface
	{
		$this->aliases[$alias] = $name;

		return $this;
	}

	/**
	 * @param string   $name
	 * @param callable $callable
	 * @param bool     $unique
	 * @return static
	 */
	final protected function addRule(string $name, callable $callable, bool $unique = false): BuilderInterface
	{
		$this->rules[$name] = [$callable, $unique];

		return $this;
	}

	/**
	 * Create an element in the built document
	 *
	 * @param string      $name
	 * @return DOMElement
	 */
	final protected function createElement(string $name): DOMElement
	{
		$el = $this->document->createElement($name);
		$this->document->appendChild($el);

		return $el;
	}

	/**
	 * Create an attribute ready to add to an element
	 *
	 * @param string      $name
	 * @param string|null $value
	 * @return DOMAttr
	 */
	final protected function createAttribute(string $name, ?string $value = null): DOMAttr
	{
		$attr = $this->document->createAttribute($name);

		// Allow minimization of attribute if value not set
		if ($value) {
			$attr->value = $value;
		}

		return $attr;
	}

	/**
	 * Init rules and aliases
	 */
	protected function init(): void
	{
	}
}
