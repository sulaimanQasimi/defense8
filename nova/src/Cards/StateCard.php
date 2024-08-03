<?php

namespace Laravel\Nova\Cards;

use Laravel\Nova\Card;

class StateCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';



    // public $links =;
    public function addVideoLinks(array $links)
    {
        return $this->withMeta([
            'links' => $links
        ]);
    }

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'state-card';
    }
}
