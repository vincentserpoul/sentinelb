<?php
// Model:'PaymentType' - Database Table: 'PaymentType'

Class PaymentType extends Eloquent
{

    protected $visible = array('id', 'label');
    protected $table='payment_type';

    public function payment()
    {
        return hasMany('Payment');
    }
}
