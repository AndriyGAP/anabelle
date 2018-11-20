<?php

declare(strict_types=1);

namespace Ublaboo\Anabelle\Markdown\Macro\Index;

final class IndexTitle extends AbstractIndexSection
{

	/**
	 * @var string
	 */
	protected static $pattern = '/^# .+/';
}
