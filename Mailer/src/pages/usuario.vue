<template>
  <q-page class="q-pa-md flex flex-center">
    <div class="row justify-center">
      <div class="col-6">
        <q-card class="my-card" flat bordered>
      <q-item>
        <q-item-section>
          <q-item-label class="text-overline">{{datosUsuario.nombre}}</q-item-label>
          <q-item-label caption>
            {{datosUsuario.email}}
          </q-item-label>
        </q-item-section>
      </q-item>

      <q-separator />

      <q-card-section>
        <q-card-section>
          <div class="row">
            <div class="col-12 q-pb-md">
             <span class="text-weight-bold">Cédula: </span>  {{ datosUsuario.cedula }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">Rol en el sistema: </span> {{ datosUsuario.rol }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">Celular: </span>{{ datosUsuario.celular }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">Fecha de Nacimiento: </span>{{ datosUsuario.fechaNacimiento }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">País: </span>{{ datosUsuario.pais }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">Estado: </span>{{ datosUsuario.estado }}
            </div>
            <div class="col-12 q-pb-md">
              <span class="text-weight-bold">Ciudad: </span>{{ datosUsuario.ciudad }}
            </div>
            <div class="col-12">
              <span class="text-weight-bold">Código de la Ciudad: </span>{{ datosUsuario.codigoCiudad }}
            </div>
          </div>
        </q-card-section>
      </q-card-section>
    </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'
export default defineComponent({
  name: 'VerPerfil',
  data () {
    return {
      datosUsuario: {
        email: '',
        nombre: '',
        celular: '',
        cedula: '',
        fechaNacimiento: '',
        codigoCiudad: '',
        rol: '',
        pais: '',
        estado: '',
        ciudad: ''
      },
    }
  },
  created () {
    this.loadData()
  },
  methods: {
    async loadData () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/user', { campo:'id', valor: localStorage.getItem('usuario')})
          .then(response => {
            let usuario = response.data.datos
            this.datosUsuario.email = usuario[0].email,
            this.datosUsuario.nombre = usuario[0].nombre,
            this.datosUsuario.celular = usuario[0].celular,
            this.datosUsuario.cedula = usuario[0].cedula,
            this.datosUsuario.fechaNacimiento = usuario[0].fechaNacimiento
            this.datosUsuario.codigoCiudad = usuario[0].codigoCiudad,
            this.datosUsuario.rol = usuario[0].rol.nombre,
            this.datosUsuario.pais = usuario[0].ciudad.estado.pais.nombre,
            this.datosUsuario.estado = usuario[0].ciudad.estado.nombre,
            this.datosUsuario.ciudad = usuario[0].ciudad.nombre
          })
      },
  }
})
</script>
