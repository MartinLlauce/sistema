<style>
.container1 {
    overflow: hidden;
}

.filterDiv {
    display: none;
    /* Hidden by default */
}

.show {
    display: block;
}
</style>
<template>
    <div>
        <div id="preloder">
        <div class="loader"></div>
	</div>
	<header class="header-section">
		<div class="container">
			<div class="d-flex flex-wrap justify-content-sm-center justify-content-lg-around">
				<div class="mt-4 mx-4">
					<h2 style="color:#043263;">FEMEC</h2>
				</div>
				<div class="mt-4 mx-4">
					<a href="http://femec.scairpgroup.com/login"  class="site-btn header-btn" style="background:#043263;display:block!important;">Inicio Sesión</a>
				</div>
			</div>
		</div>
	</header>
	<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Registro de Estudiantes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			</div>
		</div>
	</div>
	
	<section class="hero-section set-bg" data-setbg="/img/bg.jpg">
		<div class="container">
			<div class="hero-text text-white mb-4">
				<span style="font-weight: bold; font-size: 60px">Círculo de estudios <strong style="color: #043263;">FEMEC 81</strong></span>
			</div>
		
		</div>
	</section>
	<section class="categories-section spad">
		<div class="container">
			<div class="section-title">
				<h2>Escuelas Profesionales en FEMEC</h2>
			    <p style="font-size:20px;">Estás son las escuelas que conforman nuestro círculo de estudios FEMEC 81</p>
			</div>
			<div class="row">
				<!-- categorie -->
				<div class="col-lg-4 col-md-6" v-for="escuela in arrayEscuelas" :key="escuela.id">
					<div class="categorie-item">
						<div class="ci-thumb set-bg" v-bind:style="{ backgroundImage: 'url('+'/img/' + escuela.foto + ')' }"></div>
						<div class="ci-text">
							<h5>{{escuela.nombreEscuela}}</h5>
							<p>{{escuela.descripcion}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="course-section spad">
		<div class="container">
			<div class="section-title mb-0">
				<h2>Cursos Destacados</h2>
				<p style="font-size:20px;">Échale un vistazo a nuestro catálogo de talleres destacados que tenemos para ti y así poder amplíar tus conocimientos en las diversas tecnologías que tenemos a disposición para ti.</p>
			</div>
		</div>

		<div class="course-warp">
			<div class="course-filter controls" id="myBtnContainer">
				<li class="control btn active" style="font-size:22px!important;" @click="filterSelection('all')">All</li>
				<li class="control btn" style="font-size:22px!important;" @click="filterSelection(escuela.id)" v-for="escuela in arrayEscuelas" :key="escuela.id" :data-filter='escuela.id'>{{escuela.siglas}}</li>
			</div>
			<div class="container1 row course-items-area">
				<!-- course -->
				<div class="mix col-lg-3 col-md-4 col-sm-6 filterDiv show" onclick="" v-bind:class="taller.agroup" v-for="taller in arrayTaller" :key="taller.idTaller">
					<div class="course-item">
						<div class="course-thumb" v-bind:style="{ backgroundImage: 'url('+'/img/' + taller.foto + ')' }">
							<div class="price" style="background:#043263;">{{taller.hora}}</div>
						</div>
						<div class="course-info">
							<div class="course-text">
								<h5>{{taller.nombreTaller}}</h5>
								<p>Lorem ipsum dolor sit amet, consectetur</p>
								<div class="students" style="color:#043263;"> {{taller.fecha}}</div>
							</div>
							<div class="course-author">
								<p>{{taller.nombrePonente}}</p>
							</div>
						</div>
					</div>
				</div>
				<!-- course -->
			</div>
		</div>
	</section>

		<div class="p-4 m-0" style="background-color:#1C0D02;">
			<div class="footer-top">
				<div class="footer-warp">
					<div class="row">
						<div class="widget-item col-lg-4">
							<h4 style="color:white;">Contactos</h4>
							<ul class="contact-list">
								<li>Presidente: 922614996</li>
								<li>Dirección Académica: 925800750</li>
								<li>Correo: femec81_facfym@unprg.edu.pe</li>
							</ul>
						</div>
						<div class="widget-item col-lg-4">
							<h4 style="color:white;">Redes Sociales</h4>
							<ul>
								<li><a href="https://web.facebook.com/Femec81" target="_blank">Facebook</a></li>
								<li><a href="https://discord.gg/ENfvX9" target="_blank">Discord</a></li>								
								<li><a href="#" target="_blank">WhatsApp</a></li>
							</ul>
						</div>
						<div class="widget-item col-lg-4">
							<h4 style="color:white;">Escuelas</h4>
							<ul>
								<li><a href="">Ing. en Computación e Informática</a></li>
								<li><a href="">Ing. Electrónica</a></li>
								<li><a href="">Estadística</a></li>
								<li><a href="">Física</a></li>
								<li><a href="">Matemática</a></li>
							</ul>
						</div>												
					</div>
				</div>
			</div>
		</div>

    </div>
</template>
<script>
    export default {
        data() {
            return {
				arrayEscuelas : [],
				arrayTaller : [],
				nombreCompleto : '',
				apellidos : '',
				escuela : [],
				correo : '', 
				contra : ''
            }
		},
		methods : {
			getEscuela(){
				var url = '/escuelas/public';
				axios.get(url).then((response)=>{
					this.arrayEscuelas = response.data;
					$('.set-bg').each(function() {
						var bg = $(this).data('setbg');
						$(this).css('background-image', 'url(' + bg + ')');
					});
				}).catch((error)=>{
					console.log(error);
				})
			},
			getPonencias(){
				var url = '/talleres/public';
				axios.get(url).then((response)=>{
					this.arrayTaller = response.data;
				}).catch((error)=>{
					console.log(error);
				})
			},

			filterSelection(c) {
			var x, i;
			x = document.getElementsByClassName("filterDiv");
			if (c == "all") c = "";
			// Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
				for (i = 0; i < x.length; i++) {
					this.w3RemoveClass(x[i], "show");
					if (x[i].className.indexOf(c) > -1) this.w3AddClass(x[i], "show");
				}
			},

			// Show filtered elements
			w3AddClass(element, name) {
			var i, arr1, arr2;
			arr1 = element.className.split(" ");
			arr2 = name.split(" ");
				for (i = 0; i < arr2.length; i++) {
					if (arr1.indexOf(arr2[i]) == -1) {
					element.className += " " + arr2[i];
					}
				}
			},

			// Hide elements that are not selected
			w3RemoveClass(element, name) {
			var i, arr1, arr2;
			arr1 = element.className.split(" ");
			arr2 = name.split(" ");
				for (i = 0; i < arr2.length; i++) {
					while (arr1.indexOf(arr2[i]) > -1) {
					arr1.splice(arr1.indexOf(arr2[i]), 1);
					}
				}
			element.className = arr1.join(" ");
			},
		
			
		},
        mounted() {
			this.getEscuela();
			this.getPonencias();
		    // Add active class to the current control button (highlight it)
			var btnContainer = document.getElementById("myBtnContainer");
			var btns = btnContainer.getElementsByClassName("btn");
			for (var i = 0; i < btns.length; i++) {
				btns[i].addEventListener("click", function() {
					var current = document.getElementsByClassName("active");
					current[0].className = current[0].className.replace(" active", "");
					this.className += " active";
				});
			}    	

			this.filterSelection("all")
		}
    }
</script>