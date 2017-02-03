<?php

class View
{
    private $file;
    private $data;

    public function __construct($file)
    {
        $this->file = 'view/' . $file;
    }

    public function render($data = null)
    {
        $this->data = $data;

        ob_start();

        include($this->file);

        ob_end_flush();
    }

    public function fetch($data)
    {
        ob_start();

        $this->render($data);

        return ob_get_clean();
    }
}