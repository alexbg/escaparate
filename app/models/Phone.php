<?php

class Phone extends Eloquent {
    
    public static $rules = array(
        'name' => 'sometimes|required|unique:phones',
        'id_brand' => 'sometimes|required',
        'image' => 'required',
        'cpu' => 'required',
        'so' => 'required',
        'ram' => 'required',
        'camera' => 'required',
    );
    
    /*public static $rulesUpdate = array(
        'id_brand' => 'required',
        'image' => 'required',
        'cpu' => 'required',
        'so' => 'required',
        'ram' => 'required',
        'camera' => 'required',
    );*/
    
    public function brand(){
        // EL BELONGSTO HACE REFERENCIA A LA CLAVE AJENA DE LA PROPIA TABLA PHONE
        return $this->belongsTo('Brand','id_brand');
        
    }
    
    public function comment(){
        
        return $this->hasMany('Comment','id_phone');
        
    }
    // Obtiene la relaccion con los comentarios pero ordenados de forma
    // Descendente
    public function commentDesc(){
        
        return $this->hasMany('Comment','id_phone')->orderBy('created_at','DESC');
        
    }
    /**
     * SCOPE
     */
    // Obtiene los telefonos en orden descendente
    public function scopeOrderAsc($query){
        
        return $query->orderBy('created_at','DESC');
        
    }
    
    /**
     * SCOPE
     */
       // Busca los telefonos segun la marca y los ordena en orden descendente
    public function scopeFindPhonesOrderAsc($query,$id){
        return $query->where('id_brand','=',$id)->orderBy('created_at','DESC');
    }
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phones';
    
    
    protected $fillable = array(
        'name',
        'id_brand',
        'image',
        'so',
        'cpu',
        'ram',
        'camera',
        'id_brand');
    
}

?>
