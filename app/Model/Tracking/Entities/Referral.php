<?php

namespace App\Model\Tracking\Entities;

use App\Model\RootModel;

class Referral extends RootModel
{
    protected $table = 'referral';

    protected $fillable = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sessionRequest(){
        return $this->belongsTo('\App\Model\Tracking\Entities\SessionRequest');
    }
}
