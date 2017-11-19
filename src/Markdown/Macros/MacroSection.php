<?php

declare(strict_types=1);

namespace Ublaboo\Anabelle\Markdown\Macros;

use Ublaboo\Anabelle\Generator\Exception\DocuGeneratorException;
use Ublaboo\Anabelle\Markdown\Parser;

final class MacroSection
{

	/**
	 * @var Parser
	 */
	private $parser;


	public function __construct()
	{
		$this->parser = new Parser(false);
	}


	/**
	 * @throws DocuGeneratorException
	 */
	public function runMacro(
		string $inputDirectory,
		string $outputDirectory,
		string & $content
	): void // Intentionally &
	{
		/**
		 * Substitute "#include" macros with actual files
		 */
		$content = preg_replace_callback(
			'/^@ (.+[^:]):(.+\.md)/m',
			function(array $input) use ($inputDirectory, $outputDirectory): string {
				$inputFile = $inputDirectory . '/' . dirname($input[2]) . '/' . basename($input[2]);

				/**
				 * Output file is .php
				 */
				$outputFile = preg_replace('/md$/', 'php', $inputFile);

				/**
				 * Substitute input dir for output dir
				 */
				$outputFile = str_replace($inputDirectory, $outputDirectory, $outputFile);

				$this->parser->parseFile($inputFile, $outputFile, false);

				return preg_replace('/md$/', 'php', $input[0]);
			},
			$content
		);
	}
}
