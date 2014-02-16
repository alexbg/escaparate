//$('.ajax').hide();
$('.ajax-gif').hide();


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
    $('#ajax-gif').show();
    // Inicio la peticion ajax
    $.ajax('showPhones',{
        type:'GET',
        data:{id:$(this).attr('id')},
        dataType:'html',
        success:function(data){
            $('#ajax-gif').hide();
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
                    });
                    // si type es de tipo email entonces entra en el if
                    if(data.type == 'email'){
                        // modifico la informacion del email del perfil
                        $('#email').html(data.data)
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
            $('.ajax').attr('class','alert alert-danger ajax');
            break;
        case 'success':
            $('.ajax').attr('class','alert alert-success ajax');
            break;
        case 'warning':
            $('.ajax').attr('class','alert alert-warning ajax');
            break;
        case 'info':
            $('.ajax').attr('class','alert alert-info ajax');
            break;
    };
    $('.ajax').show(500).delay(3000).hide(500);
};


