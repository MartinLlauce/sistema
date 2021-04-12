<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Escuelas</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalEscuela" @click="initial()">
                                Nueva Escuela
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Opciones</th>
                                        <th class="text-center">Nombre</th>                                        
                                        <th class="text-center">Siglas</th>
                                        <th class="text-center">Vigencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="escuela in arrayEscuela" :key="escuela.idEscuela">
                                        <td>
                                            <button type="button" @click="llenarDatos(escuela)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalEscuela">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                            <button v-if="!escuela.vigencia" type="button" @click="activarEscuela(escuela.id)" class="btn btn-sm btn-success"><i style="font-size: 15px;" class="feather  icon-check-circle"></i></button>
                                            <button v-else type="button" @click="desactivarEscuela(escuela.id)" class="btn btn-sm btn-danger"><i style="font-size: 15px;" class="feather icon-x-circle"></i></button>
                                        </td>
                                        <td v-text="escuela.nombreEscuela"></td>
                                        <td v-text="escuela.siglas"></td>    
                                        <td>
                                            <span class="badge badge-pill badge-success" v-if="escuela.vigencia">Habilitado</span>
                                            <span class="badge badge-pill badge-danger" v-else>Deshabilitado</span>
                                        </td>                                    
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="pagination mb-0">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']" >
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modalEscuela" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-8 mb-1">
                                    <p class="p-text">Nombre Escuela</p>
                                    <input type="text" class="form-control" v-model="nombreEscuela">
                                </div>                     
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Siglas</p>
                                    <input type="text" class="form-control" v-model="siglas">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="p-text">Descripción</p>
                                    <textarea class="form-control" rows="8" v-model="descripcion"></textarea>
                                </div>
                                <div class="col-md-6 mb-1 d-flex  align-items-center flex-column">
                                    <label class="p-text" for="file" style="background: #7367F0;padding: 15px;border-radius: 10px;color: white;font-size: 14px;font-weight: 900;cursor: pointer;">Seleccione Imágen</label>
                                    <input style="display: none;" id="file" type="file" @change="obtenerImagen" accept=".png, .jpg, .jpeg" />
                                    <figure style="display:flex !important; justify-content:center !important; width: 50%;">
                                        <img alt="" :src="extension + imagenMiniatura" class="nel img-fluid">
                                    </figure>
                                </div>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarEscuela()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarEscuela()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric';
import moment from 'moment';
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
            /* Nuevas Variables */
            descripcion : '',
            extension : '',
            imagenMiniatura : '',
            /* Finde las nuevas Variables */
            tipoAccion : 1,
            tituloModal : 'Registro de Escuela',            
            nombreEscuela : '',
            siglas: '',
            arrayEscuela: [],        
            errors : [],            
            idEscuela : '',
            pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
            },
            offset : 3
        }
    },
    computed: {
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function(){
            if(!this.pagination.to){
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1){
                from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page){
                to= this.pagination.last_page;
            }
            var pagesArrays = [];
            while(from <= to){
                pagesArrays.push(from);
                from++;          
            }
            return pagesArrays;
        },
    },
    methods: {
        obtenerImagen(e){
            let file = e.target.files[0];
            this.imagen = file;
            this.checkextension(this.imagen);
            this.cargarImagen(file);
        },
        checkextension(img) {
            var file = img;
            if ( /\.(jpe?g|png)$/i.test(file.name) === false ){ 
                toastr.error('Sólo se admiten formatos .jpeg /.png/.jpg');
                this.file_correct = false;
            }else{
                this.file_correct = true;
            }
        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) =>{
                this.extension = '';
                this.imagenMiniatura = e.target.result;
            }
            reader.readAsDataURL(file);  
        },
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.obtenerEscuelas(page);
        },
        numCero:function(lengthCaracter, total){
            var resta = total-lengthCaracter;
            var count = 0;
            var copy = '0';
            var result = '';
            if(resta != 0){
                while (count!=resta) {
                    result = result + copy;
                    count ++;
                }
            }
            return result;
        },
        usemoment: function(date){
            return moment(date).format("DD-MM-YYYY");
        },
        savemoment : function(d){
            if(d == null){  
                return '';
            }else{
                return d.split("-").reverse().join("-");
            }
        },
        llenarDatos(escuela){
            this.tituloModal = 'Actualizar Escuela';
            this.idEscuela = escuela['id'];
            this.tipoAccion = 2;
            this.extension = '/img/'
            this.nombreEscuela = escuela['nombreEscuela'];            
            this.siglas = escuela['siglas'];
            this.descripcion = escuela['descripcion'];
            this.imagenMiniatura = escuela['foto'];
        },
        actualizarEscuela() {            
            let me = this;
            axios
                .put("/Escuela/update", {
                    'id': this.idEscuela,
                    'nombreEscuela': this.nombreEscuela,                                        
                    'siglas': this.siglas,
                    'descripcion' : this.descripcion,
                    'foto' : this.imagenMiniatura
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Escuela Actualizada");
                    me.cerrarModal();
                    me.obtenerEscuelas(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerEscuelas(page){
            let me = this;
            var url = '/Escuela?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayEscuela = respuesta.escuelas.data;
                //revisar xd
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiar(){
            this.nombreEscuela = '';            
            this.siglas = '';            
            this.errors = [];
        },
        registrarEscuela(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/Escuela/store',{                
                'nombreEscuela' : this.nombreEscuela,
                'siglas' : this.siglas,
                'descripcion' : this.descripcion,
                'imagen' : this.imagenMiniatura
            }).then((response)=>{
                me.initial();
                toastr.success('Escuela registrada.');
                me.obtenerEscuelas(1);
                me.cerrarModal();
                me.limpiar();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modalEscuela').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.descripcion = '';
            this.imagenMiniatura = '';
            this.nombreEscuela = '';
            this.siglas = '';
            this.tituloModal = 'Registrar Escuela';
        },
        desactivarEscuela(idEscuela) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de deshabilitar la Escuela?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Escuela/disabled", {
                        'id': idEscuela
                    }).then(function(response) {
                        me.obtenerEscuelas(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Deshabilitado",
                        "La Escuela fue deshabilitada exitosamente.",
                        "success"
                    );
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        },
        activarEscuela(idEscuela){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de habilitar la Escuela?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Escuela/enabled", {
                        'id': idEscuela
                    }).then(function(response) {
                        me.obtenerEscuelas(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Habilitado",
                        "La Escuela fue habilitada exitosamente.",
                        "success"
                    );
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        },
    },
    mounted() {        
        this.obtenerEscuelas(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>