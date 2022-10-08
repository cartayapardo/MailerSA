<template>
  <q-page class="row">
    <div class="col-12 q-pa-md">
      <q-table
        title="Usuario"
        dense
        :filter="filtro"
        :pagination.sync="pagination"
        @request="loadData"
        :data="rows"
        :columns="columns"
        row-key="name"
      >
      <template v-slot:top>
        <span><b>Usuarios</b></span>
        <q-space />
        <q-input v-model="filtro" label="filtro">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
        <q-space />
        <q-btn
          round
          dense
          color="primary"
          icon="add"
          @click.prevent="abrirModal('adicionar')"
        >
          <q-tooltip>Adicionar</q-tooltip>
        </q-btn>
      </template>
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="email" :props="props">
            {{ props.row.email }}
          </q-td>
          <q-td key="nombre" :props="props">
            {{ props.row.nombre }}
          </q-td>
          <q-td key="celular" :props="props">
            {{ props.row.celular }}
          </q-td>
          <q-td key="cedula" :props="props">
            {{ props.row.cedula }}
          </q-td>
          <q-td key="edad" :props="props">
            {{ props.row.edad }}
          </q-td>
          <q-td key="codigoCiudad" :props="props">
            {{ props.row.codigoCiudad }}
          </q-td>
          <q-td key="acciones" :props="props">
            <q-btn
              round
              key="updated"
              flat
              color="primary"
              icon="edit"
              @click.prevent="abrirModal('actualizar', props.row)"
            >
              <q-tooltip>Actualizar</q-tooltip>
            </q-btn>
            <q-btn
              round
              key="delete"
              flat
              color="red"
              icon="delete"
              @click.prevent="abrirDialogoEliminar(props.row)"
            >
              <q-tooltip>Eliminar</q-tooltip>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
      </q-table>
    </div>
    <q-dialog
      v-model="dialogo"
      persistent
      transition-show="scale"
      transition-hide="scale"
    >
      <q-card>
        <q-form
          @submit="accion === 'adicionar' ? guardar(): actualizar()"
          class="q-gutter-md"
        >
          <q-card-section class="bg-primary">
            <div class="text-h6 text-white">
              {{accion === 'adicionar' ? 'Adicionar Usuario': 'Editar Usuario'}}
            </div>
          </q-card-section>
          <div class="row">
            <div class="col-6 q-px-md">
              <q-input
                v-model="formData.nombre"
                dense
                label="Nombre"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val.length < 101 || 'El nombre es necesario y tiene que tener hasta 100 caracteres']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                v-model="formData.email"
                label="Correo"
                type="email"
                :disable="accion == 'actualizar'"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'El correo es necesario']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                v-model="formData.cedula"
                label="Cédula"
                :disable="accion == 'actualizar'"
                lazy-rules
                :rules="[ val => val && val.length == 11 || 'La cédula es necesaria y debe contener 11 caracteres']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                v-model="formData.celular"
                label="Celular"
                mask="##########"
                lazy-rules
                :rules="[ val => val && val.length == 10 || val.length == 0 || 'El celular debe tener 10 dígitos']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                type="number"
                v-model="formData.codigoCiudad"
                label="Código de Ciudad"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'El correo es necesario']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input dense v-model="formData.fechaNacimiento" label="Fecha Nacimiento" mask="date" :rules="[val => val && val.length > 0 || 'La fecha es necesaria']">
                <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-date v-model="formData.fechaNacimiento" :options="opciones" :locale="idioma">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Cerrar" color="primary" flat />
                        </div>
                      </q-date>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-6 q-px-md">
              <q-select
                label="Rol"
                v-model="formData.rol_id"
                input-debounce="0"
                :options="roles"
                :rules="[reglaSelector]"
                emit-value
                map-options
                options-dense
                dense
                option-label="nombre"
                option-value="id"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-select
                label="País"
                v-model="pais"
                input-debounce="0"
                :options="paises"
                :rules="[reglaSelector]"
                emit-value
                map-options
                options-dense
                dense
                option-label="nombre"
                option-value="id"
              />
            </div>
            <div class="col-6 q-px-md" v-if="pais!=null">
              <q-select
                label="Estado"
                v-model="estado"
                input-debounce="0"
                :options="estados"
                emit-value
                :rules="[reglaSelector]"
                map-options
                options-dense
                dense
                option-label="nombre"
                option-value="id"
              />
            </div>
            <div class="col-6 q-px-md" v-if="estado!=null">
              <q-select
                label="Ciudad"
                v-model="formData.ciudad_id"
                input-debounce="0"
                :options="ciudades"
                :rules="[reglaSelector]"
                emit-value
                map-options
                options-dense
                dense
                option-label="nombre"
                option-value="id"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                v-model="formData.contraseña"
                label="Contraseña"
                :type="isPwd ? 'password' : 'text'"
                lazy-rules
                :rules="[reglaContraseña]"
              >
                <template v-slot:append>
                  <q-icon
                    :name="isPwd ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isPwd = !isPwd"
                  />
                </template>
              </q-input>
            </div>
            <div class="col-6 q-px-md" v-if="formData.contraseña != ''">
              <q-input
                dense
                v-model="confirmarContraseña"
                label="Confirmar Contraseña"
                :type="isPwdR ? 'password' : 'text'"
                lazy-rules
                :rules="[
                  val => (val && val === formData.contraseña) || 'La contraseña no coincide',
                ]"
              >
                <template v-slot:append>
                  <q-icon
                    :name="isPwdR ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isPwdR = !isPwdR"
                  />
                </template>
              </q-input>
            </div>
          </div>
          <div class="row justify-end">
            <q-btn
              type="submit"
              icon="save"
              label="Guardar"
              color="primary"
              flat
            />
            <q-btn
              type="button"
              icon="close"
              @click="cancelar"
              label="Cancelar"
              color="negative"
              flat
            />
          </div>
        </q-form>
      </q-card>
    </q-dialog>
    <q-dialog
      v-model="dialogoEliminar"
      persistent
      transition-show="scale"
      transition-hide="scale"
    >
      <q-card>
        <q-card-section class="q-pa-lg">
          <span>¿Desea eliminar el usuario </span>{{ usuarioEliminar && usuarioEliminar.email
          }}<span>?</span>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn
            type="button"
            icon="done"
            @click="eliminar()"
            label="Aceptar"
            color="primary"
            flat
          />
          <q-btn
            type="button"
            icon="close"
            @click="cerrarModal()"
            label="Cancelar"
            color="negative"
            flat
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
import moment from 'moment'
export default {
  name: 'GestionUsuario',
  data () {
    return {
      columns: [
        { name: 'email', required: true, label: 'Correo', align: 'left', field: row => row.email },
        { name: 'nombre', label: 'Nombre', field: 'nombre' },
        { name: 'celular', label: 'Celular', field: 'celular' },
        { name: 'cedula', label: 'Cédula', field: 'cedula' },
        { name: 'edad', label: 'Edad', field: 'edad' },
        { name: 'codigoCiudad', label: 'Código Ciudad', field: 'codigoCiudad' },
        { name: 'acciones', label: 'Acciones', field: 'acciones' }
      ],
      formData: {
        id: '',
        email: '',
        nombre: '',
        celular: '',
        cedula: '',
        fechaNacimiento: '',
        codigoCiudad: '',
        rol_id: '',
        contraseña: '',
        ciudad_id: ''
      },
      pagination: {
        sortBy: 'desc',
        descending: false,
        page: 1,
        rowsPerPage: 3,
        rowsNumber: 10
      },
      rows: [],
      dialogo: false,
      dialogoEliminar: false,
      accion: '',
      filtro: '',
      arregloAuxiliar: [],
      usuarioEliminar: null,
      roles: [],
      usuario: null,
      paises: [],
      pais: null,
      estados: [],
      estado: null,
      ciudades: [],
      isPwd: true,
      isPwdR: true,
      confirmarContraseña: '',
      actualizado: false,
      idioma: {
        /* La semana empieza por el domingo */
        days: 'Domingo_Lunes_Martes_Miércoles_Jueves_Viernes_Sábado'.split('_'),
        daysShort: 'Dom_Lun_Mar_Mié_Jue_Vie_Sáb'.split('_'),
        months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
        monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
        firstDayOfWeek: 1,
        format24h: true,
        pluralDay: 'dias'
      }
    }
  },
  watch: {
    filtro(){
      this.filtrado()
    },
    pais() {
      if(!this.actualizado){
        this.estado=null
      }
      this.loadEstados()
    },
    estado(){
      if(!this.actualizado){
        this.formData.ciudad_id=null
      }
      this.loadCiudades()
      this.actualizado = false
    }
  },
  created () {
    this.loadData(this.pagination)
    this.loadRoles()
    this.loadPaises()
  },
  methods:  {
    async loadData (pagination) {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/paginado', pagination)
          .then(response => {
            this.pagination.page = response.data.datos.current_page
            this.pagination.rowsPerPage = response.data.datos.per_page
            this.rows = response.data.datos.data
            this.rows.forEach(usuario => {
              usuario.edad = this.calcularEdad(usuario.fechaNacimiento)
            });
          })
      },
      opciones (fecha) {
        let fechaMinima = new Date()
        fechaMinima.setFullYear(fechaMinima.getFullYear() - 18 )
        let fechaMinimaFormato = moment(fechaMinima).format('YYYY/MM/DD')
        console.log(fechaMinimaFormato)
        return fecha < fechaMinimaFormato
      },
      calcularEdad (fecha) {
        let hoy = new Date()
        let fechaNacimiento = new Date(fecha)
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
        let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
        if ( diferenciaMeses < 0 || (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
          edad--
        }
        return edad
      },
      reglaSelector (val) {
        console.log(val)
        if (val === '' || val === null) {
          return 'Debe seleccionar una opción'
        }
      },
      reglaContraseña (val) {
        if (val.match(/.[A-Z]+.|.[A-Z]+|[A-Z]+./g) == null){
          return 'La contraseña debe tener al menos una mayúscula'
        }
        if (val.match(/.[0-9]+.|.[0-9]+|[0-9]+./g) == null){
          return 'La contraseña debe tener al menos un número'
        }
        if (val.length < 8){
          return 'La contraseña debe tener al menos 8 caracteres'
        }
        if (val.match(/.[#$%^&*()+-/_]+.|.[#$%^&*()+-/_]+|[#$%^&*()+-/_]+./g) == null){
          return 'La contraseña debe tener al menos un caracter especial'
        }
      },
      cancelar () {
        this.dialogo = false
      },
      abrirModal (accion, data) {
        this.accion = accion
        if (accion === 'adicionar') {
          this.resetData()
          this.dialogo = true
        } else {
            this.setData(data)
            this.dialogo = true
          }
      },
      abrirDialogoEliminar (usuario) {
        this.dialogoEliminar = true
        this.usuarioEliminar = usuario
        console.log(usuario)
      },
      resetData () {
        this.formData.id = '',
        this.formData.email = '',
        this.formData.nombre = '',
        this.formData.celular = '',
        this.formData.cedula = '',
        this.formData.fechaNacimiento = '',
        this.formData.codigoCiudad = '',
        this.formData.rol_id = '',
        this.formData.contraseña = '',
        this.pais = null,
        this.estado = null,
        this.formData.ciudad_id = ''
      },
      setData (data) {
        this.actualizado = true
        this.formData.id = data.id,
        this.formData.email = data.email,
        this.formData.nombre = data.nombre,
        this.formData.celular = data.celular,
        this.formData.cedula = data.cedula,
        this.formData.fechaNacimiento = data.fechaNacimiento,
        this.formData.codigoCiudad = data.codigoCiudad,
        this.formData.rol_id = data.rol_id,
        this.formData.contraseña = data.contraseña,
        this.pais = data.ciudad.estado.pais_id,
        this.estado = data.ciudad.estado_id,
        this.formData.ciudad_id = data.ciudad_id
      },
      cerrarModal () {
        this.dialogo = false
        this.dialogoEliminar = false
      },
      async loadRoles () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .get('/api/roles')
          .then(response => {
            this.roles = response.data.datos
          })
      },
      async loadPaises () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .get('/api/pais')
          .then(response => {
            this.paises = response.data.datos
          })
      },
      async loadEstados () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/estado', { campo:'pais_id', valor: this.pais})
          .then(response => {
            this.estados = response.data.datos
          })
      },
      async loadCiudades () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/ciudad', { campo:'estado_id', valor: this.estado})
          .then(response => {
            this.ciudades = response.data.datos
          })
      },
      async guardar () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        this.formData.identificador = Math.floor(Math.random() * (1000))
        await this.$axios
          .post('/api/userGuardar', this.formData)
          .then(response => {
            this.formData.edad = this.calcularEdad(this.formData.fechaNacimiento)
            this.rows.push(this.formData)
            this.cerrarModal()
          })
      },
      async actualizar () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/userActualizar', this.formData)
          .then(response => {
            this.cerrarModal()
            this.rows.forEach(usuario => {
              if(usuario.id == this.formData.id){
                console.log(this.formData)
                usuario.id =this.formData.id,
                usuario.email = this.formData.email,
                usuario.nombre = this.formData.nombre,
                usuario.celular = this.formData.celular,
                usuario.cedula = this.formData.cedula,
                usuario.fechaNacimiento = this.formData.fechaNacimiento
                usuario.codigoCiudad = this.formData.codigoCiudad,
                usuario.rol_id = this.formData.rol_id,
                usuario.ciudad.estado.pais_id = this.pais,
                usuario.ciudad.estado_id = this.estado,
                usuario.ciudad_id = this.formData.ciudad_id
              }
            });
          })
      },
      async eliminar() {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/userEliminar', {id: this.usuarioEliminar.id})
          .then(response => {
            console.log(this.usuarioEliminar.id)
            console.log(this.rows[0].id)
            this.rows.filter(item => item.id != this.usuarioEliminar.id)
          })
          this.cerrarModal()
      }
  }
}
</script>
