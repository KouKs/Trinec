<?php
/**
 * model tabulky kategorie
 *
 * @author Pavel
 */
namespace Application\Model;

class Kategorie {
    
    public $id;
    public $nazev;
    public $level;
    public $parent;
    public $aktivni;

    public function exchangeArray($data)
    {
        $this->id     = @$data['id'];
        $this->nazev  = @$data['nazev'];
        $this->level  = @$data['level'];
        $this->parent = @$data['parent'];
        $this->aktivni= @$data['aktivni'];
    }
}
