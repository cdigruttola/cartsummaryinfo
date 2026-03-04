<?php

declare(strict_types=1);

namespace cdigruttola\Module\CartSummaryInfo\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartSummaryInfoController extends FrameworkBundleAdminController
{
    /**
     * @var array
     */
    private $languages;

    public function __construct($languages)
    {
        parent::__construct();
        $this->languages = $languages;
    }

    public function index(): Response
    {
        $configurationForm = $this->get('cdigruttola.module.cartsummaryinfo.configuration.form_handler')->getForm();

        return $this->render('@Modules/cartsummaryinfo/views/templates/admin/index.html.twig', [
            'configurationForm' => $configurationForm->createView(),
            'help_link' => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function saveConfiguration(Request $request): Response
    {
        $redirectResponse = $this->redirectToRoute('cartsummaryinfo_controller');

        $form = $this->get('cdigruttola.module.cartsummaryinfo.configuration.form_handler')->getForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $redirectResponse;
        }

        if ($form->isValid()) {
            $data = $form->getData();
            $saveErrors = $this->get('cdigruttola.module.cartsummaryinfo.configuration.form_handler')->save($data);

            if (0 === count($saveErrors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $redirectResponse;
            }
        }

        $formErrors = [];

        foreach ($form->getErrors(true) as $error) {
            $formErrors[] = $error->getMessage();
        }

        $this->flashErrors($formErrors);

        return $redirectResponse;
    }
}
