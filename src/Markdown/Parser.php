<?php

declare(strict_types=1);

namespace Ublaboo\Anabelle\Markdown;

use Ublaboo\Anabelle\Console\Utils\Logger;
use Ublaboo\Anabelle\Generator\Assets;
use Ublaboo\Anabelle\Generator\Exception\DocuGeneratorException;
use Ublaboo\Anabelle\Markdown\Macros\MacroInclude;
use Ublaboo\Anabelle\Markdown\Macros\MacroSection;
use Ublaboo\Anabelle\Parsedown\CustomParsedown;

final class Parser
{

	/**
	 * @var Logger
	 */
	private $logger;

	/**
	 * @var CustomParsedown
	 */
	private $parsedown;

	/**
	 * @var IMacro[]
	 */
	private $macros = [];

	/**
	 * @var Assets
	 */
	private $assets;


	public function __construct(bool $enableSections, Logger $logger)
	{
		$this->logger = $logger;

		$this->parsedown = new CustomParsedown;
		$this->assets = new Assets;

		$this->setupMacros($enableSections);
	}


	/**
	 * @throws DocuGeneratorException
	 */
	public function parseFile(string $inputFile, string $outputFile, bool $isLayout): void
	{
		$this->logger->logProcessingFile($inputFile);

		if (!file_exists($inputFile)) {
			throw new DocuGeneratorException("Missing file [$inputFile]");
		}

		$content = file_get_contents($inputFile);

		foreach ($this->macros as $macro) {
			$macro->runMacro(dirname($inputFile), dirname($outputFile), $content);
		}

		if (!file_exists(dirname($outputFile))) {
			mkdir(dirname($outputFile), 0777, true);
		}

		$this->assets->saveFile(
			$this->parsedown->text($content),
			$outputFile,
			$isLayout
		);
	}


	private function setupMacros(bool $enableSections): void
	{
		$this->macros[] = new MacroInclude;

		if ($enableSections) {
			$this->macros[] = new MacroSection($this->logger);
		}
	}
}
