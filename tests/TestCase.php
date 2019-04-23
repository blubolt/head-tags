<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use DOMDocument;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * TestCase Class
 */
class TestCase extends PHPUnitTestCase
{
	/**
	 * Asserts that two HTML documents are equal.
	 *
	 * @param string $expectedFile
	 * @param string $actualHtml
	 * @param string $message
	 *
	 * @throws ExpectationFailedException
	 * @throws InvalidArgumentException
	 * @throws Exception
	 */
	public static function assertHtmlStringEqualsHtmlFile(
		string $expectedFile,
		string $actualHtml,
		string $message = ''
	): void {
		$expected = self::normalizeHtml((string)file_get_contents($expectedFile));
		$actual = self::normalizeHtml($actualHtml);

		static::assertEquals($expected, $actual, $message);
	}

	/**
	 * Get a normalized HTML string
	 *
	 * @param string $html
	 * @return string
	 */
	private static function normalizeHtml(string $html): string
	{
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->loadHTML($html, LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS);

		return (string)$doc->saveHTML();
	}
}
