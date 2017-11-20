<?php
/**
 * SaaSy Cumulus Demo Application
 * User: jason
 * Date: 11/18/17
 * Time: 6:05 PM
 * License: Public Domain
 */
namespace App\Model\Core\Entities;

use App\Model\RootModel;

class Contact extends RootModel
{
    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     *  Whitelist of create array attributes
     * @var array
     */
    protected $fillable = ['personalEmail', 'workEmail', 'facebookProfile', 'linkedinProfile', 'twitterProfile' ];

    /**
     * One to one inverse relationship to Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo('App\Model\Core\Entities\Person');
    }

    /**
     * PM many to many relationship to Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes(){
        return $this->morphMany('App\Model\Core\Entities\Note', 'noteable');
    }

    /**
     * @return $this
     */
    public function mailingAddress(){
        return $this->belongsTo('App\Model\Core\Entities\Address', 'mailing_address_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function billingAddress(){
        return $this->belongsTo('App\Model\Core\Address', 'billing_address_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function residenceAddress(){
        return $this->belongsTo('App\Model\Core\Address', 'residence_address_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function workAddress(){
        return $this->belongsTo('App\Model\Core\Address', 'work_address_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function cellPhone(){
        return $this->belongsTo('App\Model\Core\PhoneNumber', 'cell_phone_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function homePhone(){
        return $this->belongsTo('App\Model\Core\PhoneNumber', 'home_phone_id', 'id')->withDefault();
    }

    /**
     * @return $this
     */
    public function workPhone(){
        return $this->belongsTo('App\Model\Core\PhoneNumber', 'work_phone_id', 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function profileImages(){
        return $this->morphToMany('App\Model\Core\ImageGroup', 'image_groupables');
    }
}
