<?php

namespace Idsign\Kaleyra;

use Illuminate\Support\Facades\Facade;

class KaleyraFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kaleyra';
    }
}
