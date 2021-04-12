<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Talleres</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalEscuela" @click="initial()">
                                Nuevo Taller
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
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Vigencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="taller in arrayTaller" :key="taller.idTaller">
                                        <td>
                                            <button type="button" @click="llenarDatos(taller)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalEscuela">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                            <button v-if="!taller.vigencia_taller" type="button" @click="activarTaller(taller.idTaller)" class="btn btn-sm btn-success"><i style="font-size: 15px;" class="feather  icon-check-circle"></i></button>
                                            <button v-else type="button" @click="desactivarTaller(taller.idTaller)" class="btn btn-sm btn-danger"><i style="font-size: 15px;" class="feather icon-x-circle"></i></button>
                                        </td>
                                        <td v-text="taller.nombreTaller"></td>
                                        <td v-text="taller.siglas"></td>                                        
                                        <td v-text="usemoment(taller.fecha)"></td>                                        
                                        <td v-text="taller.hora"></td>   
                                        <td>
                                            <span class="badge badge-pill badge-success" v-if="taller.vigencia_taller">Habilitado</span>
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
                                <div class="col-md-12 mb-1">
                                    <p class="p-text">Nombre del Taller</p>
                                    <input type="text" class="form-control" v-model="nombreTaller">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="p-text">Escuela</p>
                                    <v-select label="nombreEscuela" @input="cambioEstado" :clearable="false" :options="arrayEscuela" v-model="escuela" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró la Escuela.</span>
                                    </v-select>
                                    <small v-if="errors.idEscuela" class="text-danger" v-text="errors.idEscuela[0]"></small>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="p-text">Ponente</p>
                                    <input type="text" class="form-control" v-model="nombrePonente">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <p class="p-text">Fecha</p>
                                    <date-picker v-model="fecha"  :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                    <small v-if="errors.fecha" class="text-danger" v-text="errors.fecha[0]"></small>
                                </div> 
                                <div class="col-md-3 mb-1">
                                    <p class="p-text">Hora</p>
                                    <date-picker v-model="hora" format="hh:mm a" :clearable = "false" value-type="format" type="time" placeholder="hh:mm a"></date-picker>
                                </div>
                                <div class="col-md-8">
                                    <p class="p-text">Descripción</p>
                                    <vue-editor v-model="descripcion" />
                                </div>
                                <div class="col-md-4 mb-1 d-flex  align-items-center flex-column">
                                    <label for="file" style="background: #7367F0;padding: 15px;border-radius: 10px;color: white;font-size: 14px;font-weight: 900;cursor: pointer;">Seleccione Imágen</label>
                                    <input style="display: none;" id="file" type="file" @change="obtenerImagen" accept=".png, .jpg, .jpeg" />
                                    <figure class="mt-5" style="display:flex !important; justify-content:center !important;">
                                        <img alt="" :src="extension + imagenMiniatura" class="nel img-fluid">
                                    </figure>
                                </div>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarTaller()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarEscuela()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
const today = new Date();
today.setHours(0, 0, 0, 0);
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import vSelect from 'vue-select';
import moment from 'moment';
import 'vue-select/dist/vue-select.css';
import VueNumeric from 'vue-numeric';
import Vue2Editor from "vue2-editor";
export default {
    components : {
        DatePicker,
        vSelect,
        VueNumeric,
        Vue2Editor
    },
    data(){
        return {
            extension : '',
            imagenMiniatura : '',
            nombreTaller : '',
            nombrePonente : '',
            idEscuela : '',
            descripcion : '',
            duracion : '',
            fecha : '',
            hora : '',
            foto : '',
            vigencia_taller: '',
            escuela : '',
            tipoAccion : 1,
            tituloModal : 'Registro de Talleres',            
            arrayTaller: [],        
            errors : [],            
            arrayEscuela : [],
            idTaller : '',
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
            me.obtenerTalleres(page);
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
        llenarDatos(data){
            this.tituloModal = 'Actualizar Taller';
            this.idTaller = data['idTaller'];
            this.tipoAccion = 2;
            this.nombreEscuela = data['nombreEscuela'];            
            this.siglas = data['siglas'];
            this.extension = '/img/';
            this.nombreTaller = data['nombreTaller'];
            this.imagenMiniatura = data['foto'];
            this.fecha = this.usemoment(data['fecha']);
            this.hora = data['hora'];
            this.nombrePonente = data['nombrePonente'];
            this.descripcion = data['descripcion'];
            this.escuela = {'id' : data['idEscuela'], 'nombreEscuela' : data['nombreEscuela']}
        },
         cambioEstado(){
            if(!this.escuela){
                this.idEscuela = 0;
            }else{
                this.idEscuela = this.escuela.idEscuela;
            }
        }, 
        actualizarEscuela() {            
            let me = this;
            axios
                .put("/Taller/update", {
                    'idTaller' : this.idTaller,
                    'nombreTaller' : this.nombreTaller,
                    'nombrePonente' : this.nombrePonente,
                    'idEscuela' : this.escuela.id,
                    'descripcion' : this.descripcion,
                    'fecha' : this.savemoment(this.fecha),
                    'hora' : this.hora,
                    'foto' : this.imagenMiniatura,                
                })
                .then(function(response) {
                    toastr.success("Escuela Actualizada");
                    me.cerrarModal();
                    me.obtenerTalleres(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerEscuela(){
            let me = this;
            var url = '/Escuela/selectEscuela';
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayEscuela = respuesta.escuela;
            })
            .catch(function(error){
            });
        },
        obtenerTalleres(page){
            let me = this;
            var url = '/Taller?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayTaller = respuesta.taller.data;
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
        registrarTaller(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/Taller/store',{                
                'nombreTaller' : this.nombreTaller,
                'nombrePonente' : this.nombrePonente,
                'idEscuela' : this.escuela.id,
                'descripcion' : this.descripcion,
                'fecha' : this.savemoment(this.fecha),
                'hora' : this.hora,
                'foto' : this.imagenMiniatura,
            }).then((response)=>{
                me.initial();
                toastr.success('Escuela registrada.');
                me.obtenerTalleres(1);
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
            this.tituloModal = 'Registrar Talleres';
            this.nombrePonente = '';
            this.nombreTaller = '';
            this.descripcion = '';
            this.hora = '';
            this.fecha = '';
            this.imagenMiniatura = '';
            this.extension = '';
        },
        desactivarTaller(idTaller) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de deshabilitar el Taller?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Taller/disabled", {
                        'id': idTaller
                    }).then(function(response) {
                        me.obtenerTalleres(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Deshabilitado",
                        "El Taller fue deshabilitado exitosamente.",
                        "success"
                    );
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        },
        activarTaller(idTaller){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de habilitar el Taller?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Taller/enabled", {
                        'id': idTaller
                    }).then(function(response) {
                        me.obtenerTalleres(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Habilitado",
                        "El Taller fue habilitado exitosamente.",
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
        this.obtenerEscuela();
        this.obtenerTalleres(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
    .mx-datepicker{
        width: none;
    }
</style>