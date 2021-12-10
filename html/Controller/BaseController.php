<?php

namespace Html\Controller;

use http\Exception\RuntimeException;

abstract class BaseController
{
    protected array $params;
    protected string $template = __DIR__ . './../views/template.php';
    protected string $viewsDir = __DIR__ . './../views/';

    /**
     * @param string $action
     * @param array $params
     */
    protected function __construct(string $action, array $params = [])
    {
        $this->params = $params;

        $method = 'execute' . ucfirst($action);
        if (!is_callable([$this, $method])) {
            throw new RuntimeException('L\'action "' . $method . ' "n\'est pas définie sur ce module');
        }
        $this->$method();
    }

    /**
     * @param string $title
     * @param array $vars
     * @param string $view
     * @return mixed
     */
    public function render(string $title, array $vars, string $view) {
        $view = $this->viewsDir . $view;
        ob_start();
        require $view;
        $content = ob_get_clean();
        return require $this->template;
    }
}