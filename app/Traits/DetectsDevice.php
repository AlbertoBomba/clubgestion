<?php

namespace App\Traits;

use Detection\MobileDetect;

trait DetectsDevice
{
    /**
     * Comprueba si la petición proviene de un dispositivo móvil o tablet.
     */
    protected function isMobile(): bool
    {
        $detect = new MobileDetect();

        // Si prefieres que las tablets carguen la vista de escritorio, cambia a:
        // return $detect->isMobile() && !$detect->isTablet();

        return $detect->isMobile();
    }
}