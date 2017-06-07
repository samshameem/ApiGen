<?php declare(strict_types=1);

namespace ApiGen\Tests\Generator;

use ApiGen\Generator\TraitsGenerator;
use ApiGen\Reflection\Parser;
use ApiGen\Tests\AbstractContainerAwareTestCase;

final class TraitsGeneratorTest extends AbstractContainerAwareTestCase
{
    public function test(): void
    {
        /** @var Parser $parser */
        $parser = $this->container->getByType(Parser::class);
        $parser->parseDirectories([__DIR__ . '/Source']);

        /** @var TraitsGenerator $traitsGenerator */
        $traitsGenerator = $this->container->getByType(TraitsGenerator::class);
        $traitsGenerator->generate();

        $this->assertFileExists(TEMP_DIR . '/traits.html');
    }
}
