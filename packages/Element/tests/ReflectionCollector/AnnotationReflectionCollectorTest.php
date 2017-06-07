<?php declare(strict_types=1);

namespace ApiGen\Element\Tests\ReflectionCollector;

use ApiGen\Annotation\AnnotationList;
use ApiGen\Configuration\Configuration;
use ApiGen\Element\ReflectionCollector\AnnotationReflectionCollector;
use ApiGen\ModularConfiguration\Option\AnnotationGroupsOption;
use ApiGen\ModularConfiguration\Option\DestinationOption;
use ApiGen\ModularConfiguration\Option\SourceOption;
use ApiGen\Reflection\Parser;
use ApiGen\Tests\AbstractContainerAwareTestCase;

final class AnnotationReflectionCollectorTest extends AbstractContainerAwareTestCase
{
    /**
     * @var AnnotationReflectionCollector
     */
    private $annotationReflectionCollector;

    protected function setUp(): void
    {
        /** @var Configuration $configuration */
        $configuration = $this->container->getByType(Configuration::class);
        $configuration->resolveOptions([
           SourceOption::NAME => [__DIR__],
           DestinationOption::NAME => TEMP_DIR,
           AnnotationGroupsOption::NAME => [AnnotationList::DEPRECATED]
        ]);

        /** @var Parser $parser */
        $parser = $this->container->getByType(Parser::class);
        $parser->parseDirectories([__DIR__ . '/Source']);

        $this->annotationReflectionCollector = $this->container->getByType(AnnotationReflectionCollector::class);
    }

    public function test(): void
    {
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getClassReflections(AnnotationList::DEPRECATED)
        );
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getInterfaceReflections(AnnotationList::DEPRECATED)
        );
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getTraitReflections(AnnotationList::DEPRECATED)
        );
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getFunctionReflections(AnnotationList::DEPRECATED)
        );
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getClassOrTraitMethodReflections(AnnotationList::DEPRECATED)
        );
        $this->assertCount(
            1,
            $this->annotationReflectionCollector->getClassOrTraitPropertyReflections(AnnotationList::DEPRECATED)
        );
        // @todo 1
        $this->assertCount(
            0,
            $this->annotationReflectionCollector->getClassOrInterfaceConstantReflections(AnnotationList::DEPRECATED)
        );
    }
}
