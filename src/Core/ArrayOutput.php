<?php

namespace Stansmith\Core;

use \StanSmith\Core\OutputInterface;

class JsonStringOutput implements OutputInterface
{
    public function load()
    {
        return json_encode($data);
    }
}
