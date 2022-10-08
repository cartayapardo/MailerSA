<template>
  <q-card class="login-form-card shadow-20">
    <q-card-section>
      <q-form @submit="login" class="text-primary row">
        <div class="text-h6 col-12 q-my-md text-center">Iniciar sesión</div>
        <div class="col-12 column items-cemter q-mb-md">
          <q-input
            label="Correo:"
            v-model="formulario.credencial"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El correo es necesario']"
          />
        </div>
        <div class="col-12 column items-cemter q-mb-lg">
          <q-input
            label="Contraseña:"
            v-model="formulario.contraseña"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El contraseña es necesaria']"
            :type="isPwd ? 'password' : 'text'"
          >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </div>
        <div class="col-12 column">
          <q-btn
            class="q-px-md"
            type="submit"
            color="primary"
            dense
            label="Entrar"
          />
        </div>
      </q-form>
    </q-card-section>
  </q-card>
</template>
<script>
export default {
  name: 'login-form',
  data () {
    return {
      isPwd: true,
      formulario: { credencial: '', contraseña: '' }
    }
  },
  methods: {
    async login () {
        this.$axios
          .post('/api/autenticacion', this.formulario)
          .then(response => {
            localStorage.setItem('usuario', response.data.datos.usuario.id)
            localStorage.setItem('rol', response.data.datos.usuario.rol_id)
            localStorage.setItem('token', response.data.datos.token)
            if (response.data.logrado == true) {
              if(response.data.datos.usuario.rol_id == 1){
                this.$router.push({ name: 'usuarios' })
              } else {
                this.$router.push({ name: 'usuario' })
              }

            }
          })
    }
  }
}
</script>
