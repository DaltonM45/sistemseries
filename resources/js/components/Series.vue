<template>
    <div>
        <div>
            <h3 class="d-flex justify-content-center">Series Favoritas</h3>
        </div>
        <div class="container formulario ">
            <div class="row d-flex" >
              <form class="col-sm-6 ">
                <div class="form-group">
                    <label for="formGroupExampleInput">Nombre</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="name" v-model="nombre">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Descripcion</label>
                   <textarea  id="formGroupExampleInput2" 
                   cols="30" rows="10" 
                   class="form-control descripcionArea" 
                   placeholder="Descripcion" v-model="descripcion"></textarea>
                </div>
                <div class="form-group">
                    <label for="portada"> Portada </label>
                    <input type="file" accept="image/png, image/jpeg" id="Portada" @change="capturarImagen">
                </div>
                <div>
                    <input type="button" value="Guardar Serie" class="btn btn-success" @click="guardarSeries">
                </div>
            </form>  
            <div class="col-sm-6 ">
                <div class="form-group" v-if="portada">
                     <img :src="portada" class="img-responsive" height="350" width="500">
                </div>
            </div>
            </div>
        </div>
        <div class="container">
            <div class="lista">

                <div v-for="serie in arraySerie" :key="serie.id">

                   <div class="card f" style="width: 18rem;">
                    <img class="card-img-top" :src="'images/' + serie.portada" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ serie.nombre}}</h5>
                        <p class="card-text"> {{ serie.descripcion}}</p>
                    
                    </div>
                    <div class="card-header d-flex justify-content-around ">
                       <div>
                           <button class="btn btn-danger" @click="eliminarSerie(serie.id)">Eliminar</button>
                       </div>
                       <div>
                           <button class="btn btn-warning" @click="abrilModal('actualizar', serie)">Actualizar</button>
                       </div>
                    </div>
                   </div> 

                </div>
               

            </div>
            
        </div>
        

        <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}"  role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- a'adiendo titulo, dinamico -->
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                        <!-- <span class="help-block">(*) Ingrese el nombre de la categoría</span> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <textarea  id="formGroupExampleInput2" 
                                        cols="30" rows="10" 
                                        class="form-control descripcionArea" 
                                        placeholder="Descripcion" v-model="descripcion"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Portada</label>
                                    <div class="col-md-9">
                                        <img :src="portada" class="img-responsive" height="350" width="500">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="portada"> Portada </label>
                                    <input type="file" accept="image/png, image/jpeg" id="Portada" @change="capturarImagen">
                                </div>

                                    <!-- <div v-show="errorCategoria" class="form-group div-error" > -->
                                        <!-- <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMjs" :key="error" v-text="error">

                                            </div>
                                        </div> -->
                                    <!-- </div> -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                             <button  type="button" class="btn btn-primary" @click="actualizarSerie">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
    </div>
</template>

<script>



    export default {
       data(){
           return{
               arraySerie: [],
               nombre : '',
               descripcion : '',
               portada: '',
               modal: 0,
               tituloModal:''
           }
       },
       methods : {
           capturarImagen(e){
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();

                reader.onloadend = (e) => {
                    this.portada = reader.result;
                }
                
                reader.readAsDataURL(file);  
           },
            mostrarSeries(){

                let me = this;

               axios.get('/series').then(function (response) {
                    var respuesta = response.data;
                    me.arraySerie = respuesta.series;
                    console.log(me.arraySerie)
               }).catch(function(error){
                   console.log('no se pudo mostrar las series');
               })
                
            },
            guardarSeries(){

                let me = this;
               

                axios.post('/series/guardar', {
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'portada': this.portada
                }).then(function(response) {
                    me.nombre = '';
                    me.descripcion = '';
                    me.portada = '';
                    document.getElementById('Portada').value = null;
                    me.mostrarSeries();
                }).catch(function(error) {
                    console.log('error al subir los datos');
                })
            },
            eliminarSerie(id){

                Swal.fire({
                title: 'Estas seguro de eliminar esta serie de la lista?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText : 'Cancelar'
                }).then((result) => {
                if (result.value) {

                    let url = '/series/' + id;
                    let me = this;

                    axios.post(url).then(function(response){
                         console.log('eliminado');
                         me.mostrarSeries();

                            Swal.fire(
                           'Eliminado',
                            '',
                            'success'
                            )

                    }) 



                   
                }
                })

            },
            actualizarSerie(){



            },
            abrilModal(accion, data=[]){
                  switch(accion){
                    case 'actualizar':
                    {   
                        this.modal=1;
                        console.log(data);
                        this.tituloModal='Actualizar';
                        break;
                        
                    }

                }  
            },
            cerrarModal(){
                 this.tituloModal='';
                 this.modal=0;
            }
       },
       mounted(){
           this.mostrarSeries();
       }
    }
</script>


<style>

.lista{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.lista .f{
    margin-bottom: 26px;}
.formulario {
    margin-bottom: 32px;
}
 .descripcionArea{
     max-height: 125px;
     min-height: 100px;
 }


 .modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a;
}

</style>
