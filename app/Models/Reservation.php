<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\VideoChatManager;

class Reservation extends Model
{
    protected $table = 'reservations';

    use HasFactory;

    public static function createReservation(){
        $record = new Reservation();
        $record->pear_id_a = VideoChatManager::generatePeerId();
        $record->pear_id_b = VideoChatManager::generatePeerId();
        $record->save();

        return $record;
    }
}
