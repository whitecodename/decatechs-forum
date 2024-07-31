<?php

namespace App\Form;

use Symfony\Component\Form\Event\PostSubmitEvent;

class FormListenerFactory
{
    public function timestamps(): callable
    {
        return function(PostSubmitEvent $event) {
            $data = $event->getData();

            $data->setUpdatedAt(new \DateTimeImmutable());
            if(!$data->getId())
            {
                $data->setCreatedAt(new \DateTimeImmutable());
            }
        };
    }
}