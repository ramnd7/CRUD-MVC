<?php

class Controller
{
    public function view($view, $data = [])
    {
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);
        require $viewFile;
    }

    public function model($model)
    {
        $modelFile = __DIR__ . '/../models/' . $model . '.php';

        if (!is_file($modelFile)) {
            throw new RuntimeException('Model not found: ' . $model);
        }

        require_once $modelFile;
        return new $model();
    }
}
