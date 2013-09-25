<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mind\SiteBundle\Form\Handler;

use Mind\SiteBundle\Entity\DomaineRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfileFormHandler
{
    protected $request;
    protected $RepositoryDomaine;
    protected $form;

    public function __construct(FormInterface $form, Request $request, DomaineRepository $RepositoryDomaine)
    {
        $this->form = $form;
        $this->request = $request;
        $this->RepositoryDomaine = $RepositoryDomaine;
    }

    public function process(UserInterface $user)
    {
        $this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($user);

                return true;
            }

            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
            $this->RepositoryDomaine->reloadUser($user);
        }

        return false;
    }

    protected function onSuccess(UserInterface $user)
    {
        $this->RepositoryDomaine->updateUser($user);
    }
}
