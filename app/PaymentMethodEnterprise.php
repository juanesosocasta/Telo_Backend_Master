<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodEnterprise extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'cash', 'debit_card', 'credit_card', 'establishment_id' ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods_enterprises';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function establishments()
    {
        return $this->hasMany(Establishment::class);
    }
}
