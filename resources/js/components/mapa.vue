
<template>
  <div>
    <div class="flex flex-wrap -mx-3 mb-2">
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
          for="grid-state"
        >Departamento</label>
        <div class="relative">
          <select
            v-model="selectedCategory"
            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="grid-state"
          >
            <option value>TODOS</option>
            <option v-for="(d) in arrayDepartamento" :key="d.DptoId" :value="d.DptoId">{{d.DptoNom}}</option>
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
          >
            <svg
              class="fill-current h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
          for="grid-state"
        >Programa</label>
        <div class="relative">
          <select
            v-model="selectedProgram"
            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="grid-state"
          >
            <option value>TODOS</option>
            <option v-for="(p) in arrayProgramas" :key="p.id" :value="p.name">{{p.name}}</option>
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
          >
            <svg
              class="fill-current h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
          for="grid-state"
        >Estado</label>
        <div class="relative">
          <select
            v-model="selectedEstado"
            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="grid-state"
          >
            <option value>TODOS</option>
            <option v-for="(e) in arrayEstados" :key="e.id" :value="e.name">{{e.name}}</option>
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
          >
            <svg
              class="fill-current h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
          for="grid-state"
        >Sat/Empresa</label>
        <div class="relative">
          <select
            v-model="selectedSat"
            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="grid-state"
          >
            <option value>TODOS</option>
            <option v-for="(s) in arraySat" :key="s.id" :value="s.name">{{s.name}}</option>
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
          >
            <svg
              class="fill-current h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
          </div>
        </div>
      </div>
      <!--  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
          for="grid-city"
        >Sat/Empresa</label>
        <input
          v-model="inputSat"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          id="grid-city"
          type="text"
          placeholder="Ingrese Sat/Empresa"
        />
      </div>-->
    </div>

    <GmapMap
      :center="{lat:-23.5152472, lng:-58.4218982}"
      :zoom="7"
      map-type-id="terrain"
      style="width: 100%; height: 800px"
    >
      <gmap-info-window
        :options="infoOptions"
        :position="infoPosition"
        :opened="infoOpened"
        @closeclick="infoOpened=false"
      >
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
            <div v-if="gallery.length > 0">
                <div id="demo" class="carousel slide" data-ride="carousel">


                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item" :class="{ 'active': index === 0 }" v-for="(fruit, index) in gallery" :key="fruit.id">
                    <img class="" :src="'/media/'+fruit.id+'/'+fruit.file_name" style="width:100%;">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
                </div>
                <!--<div class="slideshow-container">

                    <div class="mySlides fade" v-for="fruit in gallery" :key="fruit.id">
                    <img :src="'/media/'+fruit.id+'/'+fruit.file_name" style="width:100%">
                    <div class="text">Caption Text</div>
                    </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

                </div> -->
               <!-- <img
                class="object-cover h-40 w-full px-2"
                v-for="fruit in gallery"
                :key="fruit.id"
                :src="'/media/'+fruit.id+'/'+fruit.file_name"
                alt=""> -->
            </div>
          <img v-else
            class="object-cover h-40 w-full px-5"
            src="/img/MUVH-fACHADA.jpeg"
            alt="Sunset in the mountains"
          />
          <div class="px-5 py-1">
            <div class="font-bold text-xl mb-2 text-center">{{infoContent}}</div>
            <br />
            <p class="text-gray-700 text-base">

            <div>
              <strong>Departamento:</strong>
              {{infoDepartamento}}
            </div>
              <br />
            <div>
              <strong>Distrito:</strong>
              {{infoDistrito}}
            </div>
              <br />
              <div>
              <strong>Programa:</strong>
              {{infoProgram}}
            </div>
              <br />
              <div>
              <strong>Constructora:</strong>
              {{infoConstructora}}
            </div>
              <br />
              <div>
              <strong>Sat:</strong>
              {{infoSat}}
            </div>
              <br />
            <div>
              <strong>Total Viviendas:</strong>
              {{infoCasas}}
            </div>
              <br />

              <div>
              <strong>Monto Total Subsidio:</strong>
              {{ infoMonto }} Gs.
            </div>
              <br />
              <div>
              <strong>Nro. Resolucion:</strong>
              {{infoResolucion}}
            </div>
              <br />
              <div v-if="infoFresolucion=='01/01/1753'">
              <strong>Fecha Resolucion:</strong>

            </div>
            <div v-else>
              <strong>Fecha Resolucion:</strong>
              {{infoFresolucion}}
            </div>
              <br />
              <div>
              <strong>Llamado / Licitación:</strong>
              {{infoLictiacion}}
            </div>
              <br />
              <div>
              <strong>Avance:</strong>
              {{infoAvance}} %
            </div>
              <br />
              <div>
              <strong>Estado:</strong>
              {{infoEstado}}
            </div>
              <br />
              <div v-if="infoFrecepcion=='01/01/1753'"><strong>Recepción Definitiva:</strong>
              </div>
              <div v-else><strong>Recepción Definitiva:</strong>
                {{infoFrecepcion}}
              </div>



            </p>
          </div>
          <!-- <div class="px-6 py-4">
            <span
              class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
            >#photography</span>
            <span
              class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
            >#travel</span>
            <span
              class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700"
            >#winter</span>
          </div>-->
        </div>
        <p></p>
      </gmap-info-window>
      <!--<gmap-custom-marker
       :key="m.id"
       v-for="(m) in filteredProducts"
       :marker="getPosition(m)"
       :clickable="true"
       @click.native="toggleInfo(m,m.id)">
        <img
        src="img/house.svg"
        alt="triangle with all three sides equal"
        height="30"
        width="30" />

    </gmap-custom-marker> -->
      <GmapMarker
        :key="m.id"
        v-for="(m) in filteredProducts"
        :position="getPosition(m)"
        :clickable="true"
        @click="toggleInfo(m,m.id)"
      />
    </GmapMap>
  </div>
</template>
<script>
import { gmapApi } from "vue2-google-maps";
import GmapCustomMarker from 'vue2-gmap-custom-marker';

export default {
  props: ["data", "datasat", "estados", "departamento", "programas"],
  components: {
      'gmap-custom-marker': GmapCustomMarker
  },
  data() {
    return {
      arrayProyecto: this.data,
      arraySat: this.datasat,
      arrayEstados: this.estados,
      arrayDepartamento: this.departamento,
      arrayProgramas: this.programas,
      arrayFiltrado: [],
      filtros: {},
      marker: {
        lat: 50.60229509638775,
        lng: 3.0247059387528408
      },
      infoPosition: null,
      infoContent: null,
      infoProgram: null,
      infoConstructora: null,
      infoResolucion: null,
      infoFresolucion: null,
      infoLictiacion: null,
      infoDepartamento: null,
      infoDistrito: null,
      infoSat: null,
      infoCasas: null,
      infoAvance: null,
      infoFrecepcion: null,
      infoEstado: null,
      infoMonto: null,
      infoOpened: false,
      infoCurrentKey: null,
      gallery: [],
      selectedCategory: "",
      selectedProgram: "",
      selectedEstado: "",
      selectedSat: "",
      inputSat: "",
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35,
        },
      },
    };
  },
  methods: {
    getPosition: function (marker) {
      return {
        lat: parseFloat(marker.lat),
        lng: parseFloat(marker.lng),
      };
    },
    toggleInfo: function (marker, key) {
      this.infoPosition = this.getPosition(marker);
      this.infoContent = marker.proyecto;
      this.infoProgram = marker.programa;
      this.infoConstructora = marker.constructora;
      this.infoResolucion = marker.resolucion;
      this.infoFresolucion = marker.fresolucion;
      this.infoLictiacion = marker.llamado;
      this.infoDepartamento = marker.departamento;
      this.infoDistrito = marker.distrito;
      this.infoSat = marker.sat;
      this.infoCasas = marker.cantidad_viviendas;
      this.infoAvance = marker.avance;
      this.infoFrecepcion = marker.frecepcion;
      this.infoMonto = marker.monto_total;
      this.infoEstado = marker.estado;
      this.gallery = marker.gallery

      if (this.infoCurrentKey == key) {
        this.infoOpened = !this.infoOpened;
      } else {
        this.infoOpened = true;
        this.infoCurrentKey = key;
      }
    },
  },
  computed: {
    google: gmapApi,
    filteredProducts() {
      const getValue = (value) =>
        typeof value === "string" ? value.toUpperCase() : value;
      const getSat = (value) =>
        typeof value === "string" ? value.toUpperCase() : value;
      this.arrayFiltrado = this.arrayProyecto;

      if (this.selectedCategory !== "") {
        this.filtros.departamento_id = [this.selectedCategory];
      } else {
        delete this.filtros.departamento_id;
      }

      if (this.selectedProgram !== "") {
        this.filtros.programa = [this.selectedProgram];
      } else {
        delete this.filtros.programa;
      }

      if (this.selectedEstado !== "") {
        this.filtros.estado = [this.selectedEstado];
      } else {
        delete this.filtros.estado;
      }

      if (this.selectedSat !== "") {
        this.filtros.sat = [this.selectedSat];
      } else {
        delete this.filtros.sat;
      }

      /*if (this.inputSat !== "") {
        this.filtros.sat = [this.inputSat];
      } else {
        delete this.filtros.sat;
      }*/

      function filterPlainArray(array, filters) {
        const filterKeys = Object.keys(filters);
        //console.log(filterKeys);
        return array.filter((item) => {
          return filterKeys.every((key) => {
            if (!filters[key].length) return true;
            if (key === "satold") {
              return filters[key].find(
                (filter) => getValue(item[key]).indexOf(getValue(filter)) >= 1
              );
            } //find(filter => getValue(filter).includes(getValue(item[key])));}
            else {
              return filters[key].find(
                (filter) => getValue(filter) === getValue(item[key])
              );
            } // === getValue(item[key]));
          });
        });
      }

      return filterPlainArray(this.arrayFiltrado, this.filtros);
    },
  },
};
</script>
<style>
.imgmapa {
  border-radius: 2px;
  box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.5);
  transition: width 1s;
}
</style>
