<template>
    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
        <v-flex>  
          <v-layout row align-center>
            <v-btn color="primary" :to="`/admin/laporan/pendapatan`">Pendapatan</v-btn>
            <v-btn color="primary" :to="`/admin/laporan/pendapatan-cabang`">Pendapatan Cabang</v-btn>
            <v-btn color="primary" :to="`/admin/laporan/pengeluaran`">Pengeluaran</v-btn>
            <v-btn color="primary" :to="`/admin/laporan/jasa`">Penjualan Jasa</v-btn>
            <v-btn color="primary" :to="`/admin/laporan/sparepart`">Penjualan Sparepart</v-btn>
            <v-btn color="primary" :to="`/admin/laporan/stok`">Sisa Stok</v-btn>
            </v-layout>
      </v-flex>

    </v-layout>

</template>

<script>

export default {
    
  data: () => ({

    isLoggedIn: localStorage.getItem('jwt') != null,

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },
        
    search: '',

  }),

  computed: {
     
  },

  watch: {
      },

  created () {
    this.initialize()
  },

  methods: {

    
    initialize() {
      
    },

        
  }
}
</script>
