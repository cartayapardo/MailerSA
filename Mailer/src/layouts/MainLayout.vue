<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
          <span>Mailer.SA</span>
        </q-toolbar-title>

        <q-btn
          round
          dense
          flat
          @click="cerrarSesion"
          color="white"
          icon="person"
        >
          <q-tooltip class="bg-indigo" :offset="[10, 10]">
            Cerrar Sesión
          </q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          <span>Navegación</span>
        </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.texto"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

const linksData = [
{
    texto: 'Usuarios',
    subtitulo: 'gestión de usuarios',
    icon: 'groups',
    link: 'usuarios'
  },
  {
    texto: 'Perfil',
    subtitulo: 'Informción personal',
    icon: 'person',
    link: 'usuario'
  },
  {
    texto: 'Correos',
    subtitulo: 'Información de correos',
    icon: 'mail',
    link: 'correos'
  }
]

export default {
  name: 'MainLayout',
  components: {
    EssentialLink
  },
  data () {
    return {
      leftDrawerOpen: false,
      essentialLinks: linksData
    }
  },
  methods: {
    async cerrarSesion () {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      await this.$axios
          .post('/api/cerrar')
          .then(response => {
            localStorage.setItem('usuario', null)
            localStorage.setItem('token', null)
            this.$router.push({ name: 'login' })
          })
    }
  }
}
</script>
