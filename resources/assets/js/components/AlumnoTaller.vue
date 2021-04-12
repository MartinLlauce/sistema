<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="container row course-items-area">
				<!-- course -->
                <div class="col-md-12">
                    <h2>Listado de Talleres</h2>
                </div>
				<div class="col-md-4 card mx-1" data-toggle="modal" data-target="#modalEscuela" style="cursor: pointer;" @click="detalle(taller)" v-bind:class="taller.agroup" v-for="taller in arrayTaller" :key="taller.idTaller">
                    <div class="card-header">
                        <h5>{{taller.nombreTaller}}</h5>
                    </div>
                    <div class="card-body">
						<div class="course-thumb" v-bind:style="{ backgroundImage: 'url('+'/img/' + taller.foto + ')' }"></div>
                        <p>Hora: {{taller.hora}}</p>
                        <p>Detalle Temporal del curso</p>
                        <div class="students" style="color:#043263;"> {{usemoment(taller.fecha)}}</div>
                        <p>Ponente:{{taller.nombrePonente}}</p>
                    </div>
				</div>
				<!-- course -->
			</div>
            <div class="modal fade" tabindex="-1" id="modalEscuela" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titleTaller"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-6 mb-1">
                                    <figure class="align-items-center" style="display:flex !important; justify-content:center !important; width: 100%;">
                                        <img alt="" :src="extension + imagenMiniatura" class="nel img-fluid">
                                    </figure>
                                    <p>Ponente: {{ponenteTaller}}</p>
                                    <p>Fecha: {{fechaTaller}}</p>
                                    <p>Hora: {{horaTaller}}</p>
                                </div>
                                <div class="col-md-6 mb-1 ">
                                    <p>Descripción</p>
                                    <span v-html="detalleTaller"></span>
                                </div>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="inscribirAlumno()">Inscribir</button>
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
            arrayTaller : [],
            taller : [],
            /* Finde las nuevas Variables */
            tipoAccion : 1,
            tituloModal : 'Registro de Escuela',            
            nombreEscuela : '',
            siglas: '',
            arrayEscuela: [],        
            errors : [],            
            idEscuela : '',
            titleTaller : '',
            horaTaller : '',
            fechaTaller : '',
            detalleTaller : '',
            ponenteTaller : '',
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
        detalle(data){
            this.idTaller = data['idTaller'];
            this.titleTaller = data['nombreTaller'];
            this.horaTaller = data['hora'];
            this.fechaTaller = this.usemoment(data['fecha']);
            this.ponenteTaller = data['nombrePonente'];
            this.imagenMiniatura = '/img/'+data['foto'];
            this.detalleTaller = data['descripcion'];
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
        inscribirAlumno(){
            axios.post('Taller/incripcion',{
                'idTaller' : this.idTaller
            }).then((response)=>{
                toastr.success('Gracias por inscribirte al Taller');
                $('#modalEscuela').modal('hide');
                this.getPonencias();
            }).catch((error)=>{
                console.log(error);
            })
        },
        getPonencias(){
            var url = '/Taller/getTaller';
            axios.get(url).then((response)=>{
                this.arrayTaller = response.data;
            }).catch((error)=>{
                console.log(error);
            })
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
        this.getPonencias();
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
    .course-thumb{
        min-height: 150px;
        width: 100%;
    }
</style>