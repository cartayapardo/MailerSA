<template>
  <q-item
    v-if="texto != 'Usuarios' || rol == 1"
    clickable
    :to="link"
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ texto }}</q-item-label>
      <q-item-label caption>{{ subtitulo }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'EssentialLink',
  props: {
    texto: {
      type: String,
      required: true
    },

    subtitulo: {
      type: String,
      default: ''
    },

    link: {
      type: String,
      default: '#'
    },

    icon: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      rol: '',
    }
  },
  created () {
    this.rol = localStorage.getItem('rol')
  }
})
</script>
