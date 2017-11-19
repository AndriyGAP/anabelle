<?php

declare(strict_types=1);

namespace Ublaboo\Anabelle\Generator;

use MatthiasMullie\Minify\CSS;
use Ublaboo\Anabelle\Generator\Exception\DocuGeneratorException;
use Ublaboo\Anabelle\Markdown\Parser;

final class Assets
{

	/**
	 * @var string
	 */
	private $layoutFile;

	/**
	 * @var string
	 */
	private $layoutStylesPath;

	/**
	 * @var string|null
	 */
	private $layoutStyles;

	/**
	 * @var string
	 */
	private $sectionFile;

	/**
	 * @var string
	 */
	private $sectionStylesPath;

	/**
	 * @var string|null
	 */
	private $sectionStyles;


	public function __construct()
	{
		$this->layoutFile = __DIR__ . '/../assets/layout.php';
		$this->layoutStylesPath = __DIR__ . '/../assets/layout.css';

		$this->sectionFile = __DIR__ . '/../assets/section.php';
		$this->sectionStylesPath = __DIR__ . '/../assets/section.css';
	}


	public function saveFile(string $content, string $outputFile, bool $isLayout): void
	{
		if ($isLayout) {
			$this->saveLayout($content, $outputFile);
		} else {
			$this->saveSection($content, $outputFile);
		}
	}


	private function saveLayout(string $content, string $outputFile): void
	{
		$template = file_get_contents($this->layoutFile);

		$this->replaceTitle($template, $content);
		$this->replaceContent($template, $content);

		$template = str_replace('{styles}', $this->getLayoutStyles(), $template);

		file_put_contents($outputFile, $this->minifyHtml($template));
	}


	private function saveSection(string $content, string $outputFile): void
	{
		$template = file_get_contents($this->sectionFile);

		$this->replaceTitle($template, $content);
		$this->replaceContent($template, $content);

		$template = str_replace('{styles}', $this->getSectionStyles(), $template);

		file_put_contents($outputFile, $this->minifyHtml($template));
	}


	private function replaceTitle(& $template, $content): void // Intentionally &
	{
		if (preg_match('/<h1>(.+)<\/h1>/', $content, $matches)) {
			$template = str_replace('{title}', $matches[1], $template);
		} else {
			$template = str_replace('{title}', 'Docu', $template);
		}
	}


	private function replaceContent(& $template, $content): void // Intentionally &
	{
		$template = str_replace('{content}', $content, $template);
	}


	private function getLayoutStyles(): string
	{
		if ($this->layoutStyles === null) {
			$minifier = new CSS($this->layoutStylesPath);
			$this->layoutStyles = $minifier->minify();
		}

		return $this->layoutStyles;
	}


	private function getSectionStyles(): string
	{
		if ($this->sectionStyles === null) {
			$minifier = new CSS($this->sectionStylesPath);
			$this->sectionStyles = $minifier->minify();
		}

		return $this->sectionStyles;
	}


	private function minifyHtml(string $html): string
	{
		return preg_replace(
			'#(?ix)(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))#',
			' ',
			$html
		);
	}
}
