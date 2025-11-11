<?php

namespace app\components\SzamlazzHU\document;

use \app\components\SzamlazzHU\document\invoice\Invoice;
use \app\components\SzamlazzHU\header\DeliveryNoteHeader;

/**
 * Szállítólevél segédosztály
 *
 * @package szamlaagent\document
 */
class DeliveryNote extends Invoice {

    /**
     * Szállítólevél kiállítása
     *
     * @throws \Exception
     */
    function __construct() {
        parent::__construct(null);
        // Alapértelmezett fejléc adatok hozzáadása
        $this->setHeader(new DeliveryNoteHeader());
    }
 }