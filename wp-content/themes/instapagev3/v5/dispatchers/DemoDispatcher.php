<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class DemoDispatcher
{
    public function __construct()
    {
        $model = new \Instapage\Models\EnterpriseDemoRequest();

        View::render('single-column', 'enterprise-demo-request', [
            'response' => $model->handleFormSubmit(),
            'nonceTokenName' => $model->getNonceTokenName(),
        ]);
    }
}
