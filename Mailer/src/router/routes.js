
import login from 'pages/login.vue'
import usuario from 'pages/usuario.vue'
import usuarios from 'pages/usuarios.vue'
import correos from 'pages/correos.vue'

const routes = [
  {
    path: '/',
    component: () => import('layouts/loginLayout.vue'),
    children: [
      { path: '', component: login, name: 'login' },
    ]
  },
  {
    path: '/Sitio',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '/usuarios', component: usuarios, name: 'usuarios' },
      { path: '/usuario', component: usuario, name: 'usuario' },
      { path: '/correos', component: correos, name: 'correos' }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
