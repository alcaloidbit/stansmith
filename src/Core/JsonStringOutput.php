<?php

namespace Stansmith\Core;

use \Stansmith\Core\OutputInterface;

class JsonStringOutput implements OutputInterface
{
    public function load()
    {
        return json_encode($data);
    }
}
