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

namespace TWorks\Bundle\CKEditorSonataMediaBundlefork\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\FormView;
use Sonata\ClassificationBundle\Model\CategoryManagerInterface;
use Sonata\ClassificationBundle\Model\ContextManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Adds browser and upload actions.
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class MediaAdminController extends CRUDController
{
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedServices(): array
    {
        return [
                'sonata.media.pool' => Pool::class,
                'sonata.media.manager.category' => '?'.CategoryManagerInterface::class,
                'sonata.media.manager.context' => '?'.ContextManagerInterface::class,
            ] + parent::getSubscribedServices();
    }
    /**
     * Gets a template.
     *
     * @param string $name
     *
     * @return string
     */
    private function getTemplate($name)
    {
        $templates = $this->container->getParameter('tworks_ck_editor_sonata_media.configuration.templates');

        if (isset($templates[$name])) {
            return $templates[$name];
        }

        return null;
    }

    /**
     * Returns the response object associated with the browser action.
     *
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function browserAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $datagrid->setValue('context', null, $this->admin->getPersistentParameter('context'));
        $datagrid->setValue('providerName', null, $this->admin->getPersistentParameter('provider'));

        // Store formats
        $formats = [];
        foreach ($datagrid->getResults() as $media) {
            $formats[$media->getId()] = $this->container->get('sonata.media.pool')->getFormatNamesByContext($media->getContext());
        }

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->setFormTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->getTemplate('browser'), [
            'action' => 'browser',
            'form' => $formView,
            'datagrid' => $datagrid,
            'formats' => $formats,
            'base_template' => $this->getTemplate('layout'),
        ]);
    }

    /**
     * Returns the response object associated with the upload action.
     *
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function uploadAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $mediaManager = $this->container->get('sonata.media.manager.media');

        $request = $this->requestStack->getCurrentRequest();
        $provider = $request->get('provider');
        $file = $request->files->get('upload');

        if (!$request->isMethod('POST') || !$provider || null === $file) {
            throw $this->createNotFoundException();
        }

        $context = $request->get('context', $this->container->get('sonata.media.pool')->getDefaultContext());

        $media = $mediaManager->create();
        $media->setBinaryContent($file);

        $mediaManager->save($media, $context, $provider);
        $this->admin->createObjectSecurity($media);

        return $this->render($this->getTemplate('upload'), [
            'action' => 'list',
            'object' => $media,
        ]);
    }

}
