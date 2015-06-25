<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';
    protected $visible = ['id', 'number', 'digit'];
    protected $appends = ['digit'];
    public $digit;
    
    public function getDigitAttribute() {
        return $this->digit;
    }
}
