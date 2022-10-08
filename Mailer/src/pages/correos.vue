<template>
  <q-page class="row">
    <div class="col-12 q-pa-md">
      <q-table
        title="Correos"
        dense
        :data="rows"
        :columns="columns"
        row-key="name"
      >
      <template v-slot:top>
        <span><b>Correos</b></span>
        <q-space />
        <q-btn
          round
          dense
          color="primary"
          icon="add"
          @click.prevent="abrirModal()"
        >
          <q-tooltip>Enviar correo</q-tooltip>
        </q-btn>
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
          @submit="enviar()"
          class="q-gutter-md"
        >
          <q-card-section class="bg-primary">
            <div class="text-h6 text-white">
              Enviar Correo
            </div>
          </q-card-section>
          <div class="row">
            <div class="col-6 q-px-md">
              <q-input
                v-model="formData.asunto"
                dense
                label="Asunto"
                lazy-rules
                :rules="[ val => val && val.length > 0 && val.length < 20 || 'El asunto es necesario y puede tener hasta 20 caracteres']"
              />
            </div>
            <div class="col-6 q-px-md">
              <q-input
                dense
                v-model="formData.destinatario"
                label="Destinatario"
                type="email"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'El destinatario es necesario']"
              />
            </div>
            <div class="col-12 q-px-md">
              <q-input
                dense
                autogrow
                v-model="formData.cuerpo"
                label="Cuerpo del Correo"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'El cuerpo del correo es necesario']"
              />
            </div>
          </div>
          <div class="row justify-end">
            <q-btn
              type="submit"
              icon="save"
              label="Enviar"
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
  </q-page>
</template>
<script>
  import moment from 'moment'
  export default {
    name: 'GestionUsuario',
    data () {
      return {
        columns: [
          { name: 'asunto', required: true, label: 'Asunto', align: 'left', field: row => row.asunto },
          { name: 'destinatario', label: 'destinatario', field: 'destinatario' },
          { name: 'estado', label: 'Estado', field: 'estado' }
        ],
        formData: {
          asunto: '',
          destinatario: '',
          cuerpo: '',
          user_id: '',
          estado: ''
        },
        rows: [],
        dialogo: false,
      }
    },
    created () {
      this.loadData()
    },
    methods:  {
      async loadData () {
          this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
          if(localStorage.getItem('rol') == 1){
            await this.$axios
            .get('/api/correo')
            .then(response => {
              this.rows = response.data.datos
            })
          } else {
            await this.$axios
            .post('/api/correo', {campo: 'user_id', valor: localStorage.getItem('usuario')})
            .then(response => {
              this.rows = response.data.datos
            })
          }

        },
        cancelar () {
          this.dialogo = false
        },
        abrirModal () {
            this.resetData()
            this.dialogo = true
        },
        resetData () {
          this.formData.asunto = '',
          this.formData.destinatario = '',
          this.formData.cuerpo = ''
        },
        cerrarModal () {
          this.dialogo = false
        },
        async enviar () {
          this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
          this.formData.user_id = localStorage.getItem('usuario')
          this.formData.estado = 'No enviado'
          await this.$axios
            .post('/api/enviar', this.formData)
            .then(response => {
              this.rows.push(this.formData)
              this.cerrarModal()
            })
        },
    }
  }
  </script>
