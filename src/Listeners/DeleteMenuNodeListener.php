<?php

namespace Grilar\Menu\Listeners;

use Grilar\Base\Events\DeletedContentEvent;
use Grilar\Menu\Facades\Menu;
use Grilar\Menu\Models\MenuNode;

class DeleteMenuNodeListener
{
    public function handle(DeletedContentEvent $event): void
    {
        if (! in_array(get_class($event->data), Menu::getMenuOptionModels())) {
            return;
        }

        MenuNode::query()
            ->where([
                'reference_id' => $event->data->getKey(),
                'reference_type' => get_class($event->data),
            ])
            ->delete();
    }
}
