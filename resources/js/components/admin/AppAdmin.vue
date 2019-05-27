<template>

<div id="app">
    <v-app id="inspire" >

      <v-snackbar  right v-model="snackbar" :color="color" :multi-line="mode === 'multi-line'" :timeout="timeout" :vertical="mode === 'vertical'" >
        {{ text }}
        <v-btn
          dark
          flat
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </v-snackbar>

      <v-navigation-drawer fixed v-model="drawer" app >
    
      <v-list dense v-if="isLoggedIn">
        <v-list-tile dark color="primary" flat v-for="menu in menus" :key="menu.text" router :to="menu.route" >
          <v-list-tile-action>            
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title> {{menu.text}}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>      
        </v-list>
    </v-navigation-drawer>

      

        <v-toolbar  color="white" app  @stok_kurang="snackbar = true">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <img src="/8786/Logo.png" alt="" >
            <v-toolbar-title>Admin Atma Auto</v-toolbar-title>
            
            <v-spacer></v-spacer>
            <v-btn dark color="white" v-if="!isLoggedIn">
              <router-link :to="{ name: 'login' }" class="nav-link" >Login</router-link>
            </v-btn>
            <v-btn dark color="white" v-if="!isLoggedIn">
              <router-link :to="{ name: 'register' }" class="nav-link" >Register</router-link>
            </v-btn>
             
            <v-btn v-if="isLoggedIn"  @click="logout">
               Logout
            </v-btn>
            
            <v-toolbar-items class="hidden-sm-and-down">           
            </v-toolbar-items>
        </v-toolbar>
        <v-content>

          <v-container fluid fill-height>

            <router-view @loggedIn="change"></router-view>
            
            
              
          </v-container>

        </v-content>
        
        <v-footer height="auto" color="indigo">
          <v-flex
          indigo
          py-3
          text-xs-center
          white--text
          xs12
          >
          &copy;2019 — <strong>Atma Auto</strong>
          </v-flex>
      </v-footer>

    </v-app>
</div>
</template>

<script>
export default {
    
  data: () => ({
    
      snackbar: false,
      color: '',
      mode: '',
      timeout: 0,
      text: 'Stok Kurang Dari Stok Minimal',
     

    isLoggedIn: localStorage.getItem('jwt') != null,


    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
       
        },
  
    drawer:null,

    menus: [
     
      {
        text: 'Kelola Pegawai',
        route: '/admin/pegawai'
      },
      
      {
        text: ' Jasa Service',
        route: '/admin/jasa-service'
      },

      {
        text: ' Sparepart',
        route: '/admin/sparepart'
      },
      {
        id: 'btn-sales',
        text: 'Supplier',
        route: '/admin/sales'
      },
      {
        text: 'Pesan Barang',
        route: '/admin/pesan'
      },

      {
        text: 'Laporan',
        route: '/admin/laporan'
      },

    ],

     

    
    
  }),
  created () {
    this.initialize()
  },

  methods:{
     fetchsparepart() {
      axios.get('/8786/api/sparepart/all')
      .then(response => this.sparepart = response.data)
      if(this.sparepart != null){
        this.snackbar = 1;  
      }
          
    },
    
    
    initialize() {
      this.fetchsparepart();
    },
    setDefaults() {
                if (this.isLoggedIn) {
                    let user = JSON.parse(localStorage.getItem('user'))
                    
                }
            },
            change() {
                this.isLoggedIn = localStorage.getItem('jwt') != null
                this.setDefaults()
            },
            logout(){
                localStorage.removeItem('jwt')
                localStorage.removeItem('user')
                this.change()
                this.$router.push('/')
            },
            
  }
}

</script>
