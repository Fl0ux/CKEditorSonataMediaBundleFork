<?php

declare(strict_types=1);

/*
 * This file is part of the CKEditorSonataMediaBundlefork package.
 *
 * (c) La Coopérative des Tilleuls <contact@les-tilleuls.coop>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TWorks\Bundle\CKEditorSonataMediaBundlefork\Tests\DependencyInjection;

use TWorks\Bundle\CKEditorSonataMediaBundlefork\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testOptions()
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), []);

        $this->assertArrayHasKey('templates', $config);
        $this->assertArrayHasKey('layout', $config['templates']);
        $this->assertArrayHasKey('browser', $config['templates']);
        $this->assertArrayHasKey('upload', $config['templates']);

        $this->assertEquals('@TWorksCKEditorSonataMedia/layout.html.twig', $config['templates']['layout']);
        $this->assertEquals('@TWorksCKEditorSonataMedia/MediaAdmin/browser.html.twig', $config['templates']['browser']);
        $this->assertEquals('@TWorksCKEditorSonataMedia/MediaAdmin/upload.html.twig', $config['templates']['upload']);
    }
}
