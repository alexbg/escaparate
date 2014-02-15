<?php

class Comment extends Eloquent {
    
     public static $rules = array(
         'comment' => 'required',
     );
     
     protected $fillable = array(
         'comment',
     );
     
     protected $guarded = array(
         'id_phone',
         'id_user',
     );
     
     /**
      * Una marca tiene mas de un telefono
      * @return type
      */
     public function phone(){
         
         return $this->belongsTo('Phone','id_phone');
     }
     
     public function user(){
         
         return $this->belongsTo('User','id_user');
         
     }
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';
    
}
?>
