<?php

namespace Mind\BootstrapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MindBootstrapBundle extends Bundle
{
    public function getParent() {
        return 'BcBootstrapBundle';
    }
}
