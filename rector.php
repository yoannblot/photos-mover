<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Rector\Removing\Rector\Class_\RemoveTraitUseRector;
use Rector\Removing\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Removing\Rector\FuncCall\RemoveFuncCallRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withFileExtensions(['php'])
    ->withComposerBased(phpunit: true)
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withPhpSets(php84: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ])
    ->withImportNames()
    ->withRules([
        ArgumentRemoverRector::class,
        RemoveFuncCallArgRector::class,
        RemoveFuncCallRector::class,
        RemoveInterfacesRector::class,
        RemoveTraitUseRector::class,
    ])->withSkip([
        RenamePropertyToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
    ]);
