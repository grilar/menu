<?php

namespace Grilar\Menu\Listeners;

use Grilar\Menu\Facades\Menu;
use Grilar\Menu\Models\MenuNode;
use Grilar\Slug\Events\UpdatedSlugEvent;
use Exception;

class UpdateMenuNodeUrlListener
{
    public function handle(UpdatedSlugEvent $event): void
    {
        if (! in_array(get_class($event->data), Menu::getMenuOptionModels())) {
            return;
        }

        try {
            $nodes = MenuNode::query()
                ->where([
                    'reference_id' => $event->data->getKey(),
                    'reference_type' => get_class($event->data),
                ])
                ->get();

            foreach ($nodes as $node) {
                $newUrl = str_replace(url(''), '', $node->reference->url);
                if ($node->url != $newUrl) {
                    $node->url = $newUrl;
                    $node->save();
                }
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
