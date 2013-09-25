<?php

namespace Mind\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MindUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
