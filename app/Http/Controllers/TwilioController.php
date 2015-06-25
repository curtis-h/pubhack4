<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Aloha\Twilio\Support\Laravel\ServiceProvider;

use Pusher;
use Request;

use App\Game;
use App\Player;

class TwilioController extends BaseController
{
    public function __construct() {
        $this->pusher = new Pusher(env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_ID'));
    }
    
    public function index() {
        $game = Game::orderBy('id', true)->first();
        if(empty($game)) {
            $game = Game::create();
            $game->setCode();
        }
        
        if(count($game->players) >= 4) {
            $game = Game::create();
            $game->setCode();
        }
        
        return view('welcome')->with('game', $game);
    }
    
    public function create() {
        $game = Game::create();
        $game->setCode();
        
        return redirect('/');
    }
    
    public function call() {
        return view('start');
    }
    
    public function code() {
        //error_log(Request::input('Digits'));
        $game = Game::where('code', Request::input('Digits'))->first();
        
        if(empty($game)) {
            return view('start');
        }
        
        if($number = Request::input('From')) {
            $player = Player::where('number', $number)->first();
            if(empty($player)) {
                $player = new Player;
                $player->number = $number;
            }
            
            $player->game_id = $game->id;
            $player->save();
        }
        
        $this->pusher->trigger('my-channel', 'player_joined', $player->toJson());
        
        return view('code');
    }
    
    public function play() {
        $player = Player::where('number', Request::input('From'), '')->first();
        
        if($digit = Request::input('Digits', false)) {
            $player->digit = $digit;
            $this->pusher->trigger('my-channel', 'player_event', $player->toJson());
            /*
             * 
             $player = Player::first();
            $player->digit = 1;
            dd($player->toJson());
            
            switch($digit) {
                case: 1: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 2: $this->pusher->trigger('my-channel', 'my_event', 'you moved up: '.$digit); break;
                case: 3: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 4: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 5: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 6: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 7: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 8: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 9: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                case: 0: $this->pusher->trigger('my-channel', 'my_event', 'you pressed: '.$digit); break;
                
            }
            //*/
        }
        
        return view('play');
    }
    
    public function sms() {
        
    }
}
