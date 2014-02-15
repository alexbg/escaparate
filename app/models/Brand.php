<?php

class Brand extends Eloquent {
    
     public static $rules = array(
            'name' => 'required|unique:brands',
        );
     
     /**
      * Una marca tiene mas de un telefono
      * @return type
      */
     public function phones(){
         
         return $this->hasMany('Phone','id_brand');
     }
     
    public function comment(){

        return $this->hasMany('Comments','id_brand');

    }
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brands';
    
}

?>
