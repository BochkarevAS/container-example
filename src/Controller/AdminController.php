<?php

namespace Example\Controller;

use Example\Core\Controller;
use Example\Core\Request;
use Example\Repository\AdminRepository;

class AdminController extends Controller {

    public function showAction($sort) {
        $adminRepository = $this->container->make(AdminRepository::class);
        $list = $adminRepository->showAction($sort);

        return $this->render('user/admin', [
            'list' => $list
        ]);
    }

    public function updateAction(Request $request) {
        $message = $request->post('message');
        $id = $request->post('id');

        $adminRepository = $this->container->make(AdminRepository::class);
        $adminRepository->updateAction($message, $id);

        header('Location: /admin/show/1');
    }

    public function deleteAction($id) {
        $adminRepository = $this->container->make(AdminRepository::class);
        $adminRepository->deleteAction($id);

        header('Location: /admin/show/1');
    }

    public function addImageAction($id) {
        $adminRepository = $this->container->make(AdminRepository::class);
        $adminRepository->addImageAction($id);

        header('Location: /admin/show/1');
    }

    public function isAdminAction(Request $request) {
        $id = $request->post('id');

        $adminRepository = $this->container->make(AdminRepository::class);
        $adminRepository->isAdminAction($id);

        header('Location: /admin/show/1');
    }
}