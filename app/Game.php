<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'games';

    public function players() {
        return $this->hasMany('App\Player');
    }
    
    public function setCode() {
        $this->code = sprintf('%03d', $this->id);
        $this->save();
    }
}
