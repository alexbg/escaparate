//$('.ajax').hide();
$('.ajax-gif').hide();

// FUNCIONES A CARGAR
//edit();


// VARIABLES GLOBALES
var value = [];
// alamcena el valor optenido en el data.data del ajax del edit input
var temp = null;

//***SHOWPHONES***

// Maneja el menu de categorias en showPhones. 
// Cada vez que se da a una marca, se envia una peticion ajax
// y obtiene la vista con los nuevos telefonos y cambia el atributo class
// del item anterior con el active y con el nuevo item que debe de tenerlo
$('.category').click(function(event){
    // Evito que haga su funcion principal
    event.preventDefault();
    // Guardo el elemento al que se ha echo click
    var element = $(this);
    // Muestro una imagen en movimiento
    $('.ajax-gif').show();
    // Inicio la peticion ajax
    $.ajax('showPhones',{
        type:'GET',
        data:{id:$(this).attr('id')},
        dataType:'html',
        success:function(data){
            $('.ajax-gif').hide();
            // meto la informacion obtenida en html dentro del div con el id phones
            $('#phones').html(data);
            // quito el active del item que lo tenia antes
            $('.active').attr('class','list-group-item category');
            // cambio la class del item nuevo que tiene que estar activado
            element.attr('class','list-group-item active category');
        },
        error:function(jqXHR,status,errorThrown){
            $('.ajax-gif').hide();
            switch(status){
                case 'error':
                    message($('#message'),'No se puede acceder al servidor','info');
                    break;
            }
        }
    });
    //alert('funciona');
});


/*** FORMULARIOS DE PERFIL ***/
/**
 * Permite hacer submit de cualquier formulario que crees, en este caso esta adaptado para los perfiles
 * pero con pocas modificaciones puedes adaptarlo apra lo que quieras
 * Todos los formularios, deberan tener un div con class ajax-gif con una imagen gif
 * para mostrar 
 * Ejemplo(Laravel): <div class='ajax-gif'>{{ HTML::image('assets/img/ajax-loader.gif','Cargando') }}</div>
 * Basicamente envia una peticion post a la url del action con la informacion de todos los inputs
 * del formulario al que has echo click en el boton submit
 * Esa informacion es enviada en forma json
 * EL FORATO APRA EL RETURN DE PHP POR AHORA ES ESTE.
 * * SOLO SAVE ES OBLIGATORIO
    * save: sirve para indicar si hay algun erro o no
    * message: sirve para enviar un mensaje con alguna informacion
    * type: sirve para indicar el tipo de informacion que usas o estas modificando(password,email,etc)
    *  y de esta forma personalizar mas el resultado de ajax
    * data: datos a enviar. Puede ser un array o lo que quieras

 * return array(
        'save'=>false,
        'data'=>
            array(
                'error'=>$pass->messages()->toArray()
            ),
        'message'=>'Hay algun dato mal'
        );
    RECUERDA QUE SAVE ES EL UNICO OBLIGATORIO
 */
$('form').submit(function(event){
    // Evito que ejecute su funcion principal, es decir que no haga submit
    // Si el formulario tiene el atributo data-stop, entonces no se ejecutara la peticion ajax
    if(!$(this).data("stop")){
        // paro el evento principal
        event.preventDefault();
        // serializo la informacion de los formularios, pasandolos aun json de clave valor
        var element = $(this).serializeArray();
        // Muestro el gif para indicar que la peticion va a empezar
        $('.ajax-gif').show();
        // ejecuto la peticion mediante ajax
        $.ajax($(this).attr('action'),{
            type:'POST',
            data: element,
            dataType:'json',
            success:function(data){
                // Si la peticion ha sido enviada y ha recibido respuesta
                // escondo el gif
                $('.ajax-gif').hide();
                // de la informacion que ha sido enviada, compruebo si save es true
                // o false
                if(data.save){
                    // ESTA PARTE ES LA QUE SE PUDE MODIFICAR
                    if(data.redirect){
                        
                        window.location.href = data.redirect
                    }
                    // Si es true, es que se ha podido guardar(if($user->save(){return ....save=>true}))

                    // Recorro todos los input que hay
                    $('input').each(function(key,value){
                        // value: devuelve el elemento input en formato HTML no en jquery
                        // key: devuelve la posicion en un array de ese elemento:0,1,2,3,...

                        // Si el input que esta analizando, tiene como type submit, 
                        // no va a modificar nada,
                        // pero si no tiene submit, entra en el if.
                       if($(value).attr('type') != 'submit'){
                           // si type es de tipo email, entonces no cambiara el valor
                           // del input
                           if(data.type != 'email'){
                               // quito cualquier string que tenga el input
                               $(value).val('');
                           }
                       }
                       //console.log(data.type);
                    });
                    
                    // Si hay algun textarea, la informacion sera eliminada
                    $('textArea').each(function(key,value){
                        if($(value).attr('type') != 'submit'){
                           // si type es de tipo email, entonces no cambiara el valor
                           // del input
                           if(data.type != 'email'){
                               // quito cualquier string que tenga el input
                               $(value).val('');
                           }
                       }
                    })
                    
                    // Recorro los errors, para quitar los mensajes de errores generados
                    // anteriormente
                    $('.error').each(function(key,value){
                        // cada div mostrara su mensaje correspondiente, para eso tiene que tener
                        // Como algun error anterior ha podido ser eliminado
                        // pongo cada error primero vacio.
                        $(value).html('');
                    })
                    
                    // si type es de tipo email entonces entra en el if
                    if(data.type == 'email'){
                        // modifico la informacion del email del perfil
                        $('#email').html(data.data)
                    }
                    // Si la respuesta es de un comentario, entonces genero el panel
                    // que lo contendra y lo escondo para poder mostrarlo despues con ua animacion
                    if(data.type == 'comment'){
                        // Genero el panel
                        var comment = $('<div class="panel panel-primary">\n\
                            <div class="panel-heading">\n\
                            <strong>User: </strong>'+data.data.user+'\n\
                            <strong>Date:</strong>'+data.data.created.date+'\n\
                            </div>\n\
                            <div class="panel-body">\n\
                            '+data.data.comment+'\n\
                            </div>'
                        ).hide();
                        
                        // prepend lo coloca al principio del elemento
                        $('#add-comment').prepend(comment);
                        
                        // muestro el comentario
                        comment.show(500);
                    }

                    /*if(data.type = 'language'){
                        $('#language').html(data.data)
                    }*/
                    // Muestro una alerta durante 3 segundos(delay(3000))
                    // y tarda en mostrarla y en eliminarla 0,500 segundos
                    message($('#message'),data.message,'success');
                    // TERMINA MODIFICACION
                    
                }
                else{
                    // ESTA PARTE ES LA QUE SE PUDE MODIFICAR

                    // SI save es false , es que no se ha podido guardar, entonces
                    // muestro los errores pasados en el div cuya clase es error
                    // Los errores tienen que ser un array(diccionario) de clave=>valor
                    $('.error').each(function(key,value){
                        // cada div mostrara su mensaje correspondiente, para eso tiene que tener
                        // Como algun error anterior ha podido ser eliminado
                        // pongo cada error primero vacio.
                        $(value).html('');
                        // Despues pongo el error nuevo si lo tiene
                        // una etiqueta name, que coincida con el nombre del error
                        $(value).html(data.data.error[$(value).attr('name')]);
                    })
                    message($('#message'),data.message,'warning');
                    // TERMINA MODIFICACION
                }
                        },
            error:function(jqXHR,status,errorThrown){
                $('.ajax-gif').hide();
                switch(status){
                    case 'error':
                        message($('#message'),'No se puede acceder al servidor','info');
                        break;
                }
            }
        })
    } 
});


/*** AJAX MENU ***/

/*$('.menu-link').click(function(event){

    if(!$(this).data("stop")){
        // paro el evento principal
        event.preventDefault();
        // Muestro el gif para indicar que la peticion va a empezar
        $('.ajax-gif').show();
        // ejecuto la peticion mediante ajax
        $.ajax($(this).attr('href'),{
            type:'GET',
            dataType:'html',
            success:function(data){
                $('.ajax-gif').hide();
                $('#content').html(data);
            },
            error:function(jqXHR,status,errorThrown){
                $('.ajax-gif').hide();
                switch(status){
                    case 'error':
                        message($('#message'),'No se puede acceder al servidor','info');
                        break;
                }
            }
        })
    } 

});*/
    
    
    
/*** LOGIN ***/





/*** message boostrap ***/
/**
 * Recuerda que esto es solo para boostrap, y tiene qye haber un div como este:
 * <div class="alert alert-success">
        <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>-->
        <div id='message'>AQUI VA EL MENSAJE</div>
    </div>
    El div del alert, debe tener la clase .ajax, algo como esto class='alert alert-danger ajax'
 * @param {html} element: el elemento al que le quieras poner el mensaje
 * @param {string} message: el mensaje que quieras poner
 * @param {string} type: el tipo de mensaje
 * @returns {undefined}
 */
function message(element,message,type){
    element.html(message);
    switch(type){
        case 'dange':
            $('.ajax').attr('class','alert alert-danger ajax affix');
            break;
        case 'success':
            $('.ajax').attr('class','alert alert-success ajax affix');
            break;
        case 'warning':
            $('.ajax').attr('class','alert alert-warning ajax affix');
            break;
        case 'info':
            $('.ajax').attr('class','alert alert-info ajax affix');
            break;
    };
    $('.ajax').show(500).delay(3000).hide(500);
};


/***INPUT EDIT***/

/**
 * 
 * @param {type} event
 * @param {type} element
 * @returns {undefined}
 */
function edit(event,element){
    
    
// Si la clase tiene el atributo class como edit
// entra en el if



    // Guardo la informacion de la direccion del enlace
    var url = element.attr('href');

    // guardo la informacion del name del link
    var name = element.attr('name');

    

    // genero el formulario
    
    // Si la peticion es para un comentario, escogera la informacion de diferentes sitios
    if(name != 'comment'){
        
        // guardo el texto del elemento
        var cache =  $.trim(element.prev().text());
        
        // genero el formulario
        var formulario = $("<form action='"+url+"' role='form' class='form-inline'>\n\
                                <div class='form-group'>\n\
                                   <input type='text' class='form-control' value='"+cache+"' name='"+name+"'/>\n\
                                   <div class='error' name='"+name+"'></div>\n\
                                </div>\n\
                                   <input type='submit' value='send' class='btn btn-default'>\n\
                            </form>");
        
        // inserto el formulario

        element.prev().html(formulario);
        }
    else{
        
        // guardo el texto del elemento
        var cache =  $.trim(element.parent().prev().text());
        
        // genero el formulario
        var formulario = $("<form action='"+url+"' role='form'>\n\
                                    <div class='form-group'>\n\
                                 <textarea class='form-control' rows='3' name='"+name+"'>"+cache+"</textarea>\n\
                                  <div class='error' name='"+name+"'></div>\n\
                                  </div>\n\
                                \n\
                                   </form>");
        // inserto el formulario

        element.parent().prev().html(formulario);
    }
    
    // le pongo el atributo id con al longitud que tiene el array en ese momento
    // el di sirve para saber donde esta almacenador el valor del span antes
    // de poner el formulario
    element.attr('id',value.length);

    // inserto el elemento en el array que almacena los valores
    value.push(cache);

    // a este elemento le elimino el evento click que tenia
    element.off('click');

    // le añado uno nuevo para que la proxima vez, ejecute el opened
    element.on('click',function(event){

            // evito que funcione como un link

            event.preventDefault();

            // si hay algun cambio se ejecuta la funcion send() dentro de la funcion change
            // en caso contrario, dejare todo como estaba
            // Si es un comentario, escogera la informacion de diferentes sitios
            if(name != 'comment'){
                var input = $(this).prev().find('input');
            }
            else{
                var input = $(this).parent().prev().find('textarea');
            }
            if(!changed($(this),input)){

                 // le paso el evento y el elemento que tiene el evento

                opened(event,$(this));

            }
            else{
               // si ha cambiado algun dato, ejecuto la funcion send
               // que permite hacer una peticion ajax
               // le paso el elmento del click, el evento y el padre
               // del input
               if(name != 'comment'){
                   send(input.parent(),element,event);
               }
               else{
                   send(input.parent().parent(),element,event);
               }
               

            }

    });

};

/**
 * Cierra el formulario y vuelve a colocar todo como estaba
 * event: informacion sobre el elemento lanzado
 * element: elemento al que le afecta el click que en este caso es el link 
 * @param {type} event
 * @param {type} element
 * @returns {undefined}
 */
function opened(event,element){
    
    // si el temp que es la variable donde se guarda la informacion devuelta
    // por la peticion ajax, es null, entonces significa que no ha cambiado nada
    // y lo deja cmo estaba antes
    
    var name = element.attr('name');
    
    
    if(temp == null){
        // obtengo el id del link para obtener el valor que tiene en el array value
        var id = element.attr('id');
        
        // optengo el valor del array value
        var cache = value[id];
        
        if(name != 'comment'){
             // devuelvo al span como estaba antes
            element.prev().html(cache);
        }
        else{
            // devuelvo al span como estaba antes
            element.parent().prev().html(cache);
        } 
    }
    else{
        
        if(name != 'comment'){
            // meto el valor del temp en el span
            element.prev().html(temp);
        }
        else{
            // meto el valor del temp en el span
            element.parent().prev().html(temp);
        }
        // dejo el temp a null para la siguiente peticion
        
        temp = null;
    }
    
    // quito el vento click que tenia el elemento
    element.off('click');

    // le añado un nuevo evento click
    element.on('click',function(event){
        // dentego la ejecucion principal
        event.preventDefault();
        // le adjunto la funcion edit
        edit(event,$(this));
    });
    
};

// Comprueba si ha habido algun cambio
/**
 * Devuelve true si se ha modificado la informacion del input del formulario
 * En caso contrario, devuelve false
 * element: el elemento que tiene el id en este caso el link
 * input: el input del formulario ha validar
 * @param {type} element
 * @param {type} input
 * @returns {Boolean}
 */
function changed(element,input){
    
    var change = false;
    
    if(value[element.attr('id')] != $.trim(input.val())){
        
        change = true
    }
    
    return change;
    
};


/**
 * Permite guardar mediante ajax, la informacion de los formularios de los 
 * INPUT EDIT
 * form: el formulario de donde voy a serializar los datos y a enviarlos
 * click: el elemento donde hice click
 * event: informacion sobre el evento click
 * @param {type} form
 * @param {type} click
 * @param {type} event
 * @returns {undefined}
 */
function send(form,click,event){
    
    if(!form.data("stop")){
        
        
        // serializo la informacion de los formularios, pasandolos aun json de clave valor
        var element = form.serializeArray();
        // Muestro el gif para indicar que la peticion va a empezar
        $('.ajax-gif').show();
        
        console.log(form);
        
        // ejecuto la peticion mediante ajax
        $.ajax(form.attr('action'),{
            type:'POST',
            data: element,
            dataType:'json',
            success:function(data){
                // Si la peticion ha sido enviada y ha recibido respuesta
                // escondo el gif
                $('.ajax-gif').hide();
                // de la informacion que ha sido enviada, compruebo si save es true
                // o false
                if(data.save){
                    // ESTA PARTE ES LA QUE SE PUDE MODIFICAR
                    
                    
                    
                    message($('#message'),data.message,'success');
                    temp = data.data;
                    // TERMINA MODIFICACION
                    opened(event,click);
                    
                    
                }
                else{
                    // ESTA PARTE ES LA QUE SE PUDE MODIFICAR

                    message($('#message'),data.message,'warning');
                    // TERMINA MODIFICACION
                    
                }
                        },
            error:function(jqXHR,status,errorThrown){
                $('.ajax-gif').hide();
                switch(status){
                    case 'error':
                        message($('#message'),'No se puede acceder al servidor','info');
                        break;
                }
            }
        })
    } 
    
    
}


$( document ).ready(function() {
    $('.edit').on('click',function(event){
      // evito que funcione como un link
      event.preventDefault();
      // le paso el evento y el elemento que tiene el evento
      edit(event,$(this));
    });
});




















/*** EDIT INPUT ***/
/* POR AHORA NO SE DEBERA DE ABRIR MAS DE UN EDIT SI YA ESTA ABIERTO UNO
 * url: sera el href del boton que lanzara el edit(edit-button)
 * name: sera el name del input
 * type(data-type-edit): sera el tipo de formato a validar
 * valor: sera el valor que tiene el campo en ese momento
 * cache: almacena el valor principal, para poder detectar si ha sido modificado o no
 * open: indicara si esta activo o no con true o false 
 * ESTE ES EL FORMATO QUE TENDRA QUE TENER(laravel)
 *  <strong>Fecha de nacimiento: </strong>
       <span id='address' class='edit-span'>
            {{ Auth::user()->address }}
        </span>
    {{ HTML::link('changeInformation','edit',array('class'=>'edit-button', 'name'=>'address')) }}</br>
   LA RESPUESTA ES LA MISMA QUE EL AJAX CREADO ANTERIORMENTE
 */
// Comprueba si el dit ya habia sido pulsado
//var open = false;
//var cache = null;
//var url;
//var name;
//$('.edit-button').click(function(event){
//    // Cierro la funcion principal
//    event.preventDefault();
//    /*Genero el formulario si no esta ya generado*/
//    
//    // si ya habia sido pulsado, entonces entra en el if
//        if(!open){
//                url = $(this).attr('href');
//                // el link debe tener un atributo name, para saber que tipo de datos se va a validar
//                name = $(this).attr('name');
//                // Si el nombre es comment se ejecutara de forma diferente, a causa de las ubicaciones
//                // en el panel, ya que no es lo mismo que antes
//                if(name!='comment'){
//                    // trim elimina todos los espacios en blanco que haya
//                    cache =  $.trim($(this).prev().text());
//                    //$(this).prev().toggle('fast');
//
//                    var formulario = $("<form action='"+url+"' role='form' class='form-inline'>\n\
//                                    <div class='form-group'>\n\
//                                  <input type='text' class='form-control' value='"+cache+"'/>\n\
//                                  <div class='error' name='"+name+"'></div>\n\
//                                   </div>\n\
//                                    </form>");
//                    // inserto el formulario en el span
//                    $(this).prev().html(formulario);
//                    // indico que el formulario esta abierto
//                    open = true; 
//                }
//                else{
//                    //console.log('entra');
//                    // busco en el padre y despues del previo y consigo llegar al texto
//                    // y lo guardo en la cache
//                    cache =  $.trim($(this).parent().prev().text());
//                    // Este formulario es diferente, tiene un texarea
//                    var formulario = $("<form action='"+url+"' role='form' class='form-inline'>\n\
//                                    <div class='form-group'>\n\
//                                  <textarea class='form-control' rows='3'>"+cache+"</textarea>\n\
//                                  <div class='error' name='"+name+"'></div>\n\
//                                   </div>\n\
//                                    </form>");
//                    // inserto el formulario            
//                    $(this).parent().prev().html(formulario);
//                    // Indico que ha sido abierto el formulario
//                    open = true;
//                }
//        }
//        else{
//            // si los nombre son diferentes, significa que no son el mismo link
//            // y solo puedo tener un link abierto, por eso muestro un mensaje y no dejo
//            // pasar a la funcion ajax
//            var value;
//            //var element = $(this).serializeArray();
//            if($(this).attr('name') == name){
//            // si ya esta generado, vuelvo a como estaba antes
//            // trim elimina todos los espacios en blanco que haya
//            // si es un comentario buscara un textarea y en diferente lugar,
//            // si no es un comentario buscara un input
//            if(name!='comment'){
//                value = $.trim($(this).prev().find('input').val());
//            }
//            else{
//                
//                value = $.trim($(this).parent().prev().find('textArea').val());
//                console.log(value);
//            }
//            // guado el elemento que lanza el evento click
//            element = $(this);
//            // si el valor es el mismo, no cambia nada, solo cierra el form
//            // En caso contrario empieza el ajax
//            if(cache != value){
//                // envio la peticion ajax
//                $('.ajax-gif').show();
//                // Inicio la peticion ajax
//                $.ajax(url,{
//                    type:'POST',
//                    dataType:'json',
//                    data:{name:name,value:value},
//                    success:function(data){
//                        // Escondo el gif ya que el ajax ha terminado
//                        $('.ajax-gif').hide();
//                        // Muestro el mensaje que se ha enviado en al respuesta
//                        message($('#message'),data.message,'success');
//                        // Inserto la informacion en su lugar
//                        // si es un comentario, lo insertara en diferente lugar
//                        if(name!='comment'){
//                            element.prev().html(data.data);
//                        }
//                        else{
//                            element.parent().prev().html(data.data);
//                        }
//                        cache = null;
//                        // indico que el el form ya esta cerrado
//                        open = false;
//                    },
//                    error:function(jqXHR,status,errorThrown){
//                        $('.ajax-gif').hide();
//                        switch(status){
//                            case 'error':
//                                message($('#message'),'No se puede acceder al servidor','info');
//                                break;
//                        }
//                    }
//                });
//            }
//            else{
//                //en caso contrario no lo envio
//                // vuelvo a cololcar el valor que tenia antes y quito el form
//                if(name!='comment'){
//                    $(this).prev().html(value);
//                }
//                else{
//                    $(this).parent().prev().html(value);
//                }
//                cache = null;
//                // indico que el el form ya esta cerrado
//                open = false;
//            }
//        }
//        else{
//            message($('#message'),'Debe cerrar el anterior','info');
//        }
//     }
//});


/*** PARTE PRINCIPAL DEL EDIT INPUT ***/

//var open = false;
//var cache;
//var url;
//var name;
//$('.edit-button').click(function(event){
//    // Cierro la funcion principal
//    event.preventDefault();
//    /*Genero el formulario si no esta ya generado*/
//    // si ya habia sido pulsado, entonces entra en el if
//    if(!open){
//        url = $(this).attr('href');
//        // el link debe tener un atributo name, para saber que tipo de datos se va a validar
//        name = $(this).attr('name');
//        // trim elimina todos los espacios en blanco que haya
//        cache =  $.trim($(this).prev().text());
//        var formulario = $("<form action='"+url+"' method='PUT' role='form' class='form-inline'>\n\
//                        <div class='form-group'>\n\
//                      <input type='text' class='form-control' value='"+cache+"'/>\n\
//                      <div class='error' name='"+name+"'></div>\n\
//                       </div>\n\
//                        </form>");
//        // inserto el formulario en el span
//        $(this).prev().html(formulario);
//        // indico que el formulario esta abierto
//        open = true;
//    }
//    else{
//        // si ya esta generado, vuelvo a como estaba antes
//        // trim elimina todos los espacios en blanco que haya
//        var value = $.trim($(this).prev().find('input').val());
//        // guado el elemento que lanza el evento click
//        element = $(this);
//        // si el valor es el mismo, no cambia nada, solo cierra el form
//        // En caso contrario empieza el ajax
//        if(cache != value){
//            // envio la peticion ajax
//            $('.ajax-gif').show();
//            // ESTA PARTE ES MODIFICABLE
//            // TERMINA LA MODIFICACION
//        }
//        else{
//            //en caso contrario no lo envio
//            // vuelvo a cololcar el valor que tenia antes y quito el form
//            $(this).prev().html(value);
//            // indico que el el form ya esta cerrado
//            open = false;
//        }
//    }
//})


/** Validara los datos editatos con EDIT INPUT **/
function validate(){
    
}