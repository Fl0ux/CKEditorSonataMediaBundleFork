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

namespace TWorks\Bundle\CKEditorSonataMediaBundlefork\Admin;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * Adds browser and upload routes to the Admin.
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class MediaAdminExtension extends AbstractAdminExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureRoutes(AdminInterface $admin, RouteCollectionInterface $collection): void
    {
        $collection->add('browser', 'browser');
        $collection->add('upload', 'upload');
    }
}
