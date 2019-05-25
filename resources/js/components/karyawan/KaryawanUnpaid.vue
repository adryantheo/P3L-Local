<template>
  <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
    <v-flex>  
      <v-toolbar flat color="white">
        <v-toolbar-title>
          <v-btn color="primary" :to="`/karyawan/transaksi`">Semua Transaksi</v-btn> 
          <v-btn :to="`/karyawan/unpaid`">Belum Dibayar</v-btn> 
          </v-toolbar-title>
          <v-divider
            class="mx-2"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
        <v-dialog v-model="dialog" fullscreen>
            <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="search"
                  append-icon="search"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
            <v-spacer></v-spacer>
              <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Transaksi</v-btn>  
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                      <v-select :items="kustomer" item-text="Nama_Kustomer" item-value="id" v-model="editedItem.kustomer_id" label="Nama Kustomer"></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                      <v-select :items="items" v-model="editedItem.Status" label="Status"></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                      <v-select :items="pegawai" item-text="Nama" item-value="id" v-model="editedItem.user_id" label="Nama CS"></v-select>
                    </v-flex> 
                  </v-layout>
                </v-container>
              </v-card-text>  
              <v-card-actions>
                <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>        
        </v-dialog>
      </v-toolbar>
    <v-divider class="my-4"></v-divider>      
    <v-layout row wrap>
      <v-flex xs12 md6 xl4 v-for="(item, id) in transaksi" :key="`transaksi-${id}`" :search="search">
        <v-card class="rounded" width="350px" :search="search">
          <v-card-title>
            <span> ID Transaksi : {{item.id}} </span> 
          </v-card-title>          
          <v-card-text>
            Customer: {{item.kustomer.Nama_Kustomer}}
          <br>
            Status:  {{item.Status}}
          <br>
            Tanggal: {{item.created_at}}
          </v-card-text>
          <v-card-actions>
              <v-btn color="primary" @click="deleteItem(item)">Hapus</v-btn>
              <v-btn color="primary"  :to="`/karyawan/transaksi/${item.id}`">Detail Pesanan</v-btn>
             
          </v-card-actions>
        </v-card>
      <v-divider class="my-2"></v-divider>  
      </v-flex>
    </v-layout>

    </v-flex>
  </v-layout>
</template>

<script>

export default {
    
  data: () => ({

    items:['Sedang Dikerjakan','Sudah Selesai'],

    isLoggedIn: localStorage.getItem('jwt') != null,

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },        
    dialog: false,
    search: '',
    transaksi: [],
    kustomer: [],
    pegawai: [],
    pickedItem: null,
    Total_Harga_Beli: 0,
    editedIndex: -1,
    editedItem: {},
    defaultItem: {}
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    getTotalHarga(){
      
      var hargaBeli = parseFloat(this.dataSparepart.Harga_Beli)
      this.Total_Harga_Beli = this.hargaBeli
    }  
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
    "editedItem.sparepart_id"(val){
      console.log(val);      
    },
    "editedItem.sales_id"(val){
      console.log(val);
    },  
  },

  created () {
    this.initialize()
  },

  methods: {
    openDialogDetail(item){
      console.log(item);
      this.pickedItem = item;
      this.dialog = true;
    },

    getHargaBeli(){
       parseFloat(this.dataSparepart.Harga_Beli);
    },

    fetchkustomer(){
      axios.get('/8786/api/kustomer')
      .then(response => this.kustomer = response.data)
    },

    fetchtransaksi() {
      axios.get('/8786/api/transaksi/unpaid')
      .then(response => this.transaksi = response.data)  
    },
    
    fetchpegawai(){
      axios.get('/8786/api/pegawai')
      .then(response => this.pegawai = response.data)
    },


    initialize() {
      this.fetchkustomer();
      this.fetchtransaksi();
      this.fetchpegawai();
    },

    editItem (item) {
      this.editedIndex = this.transaksi.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },



    deleteItem (item) {
      const index = this.transaksi.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.transaksi.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/transaksi/'+item.id)
        .then(response => {
          console.log(response);
        })
    },
   

    close () {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    save () {
      console.log('created Data');
      axios.post('/8786/api/transaksi',{
          cabang_id:1,
          nama_cs:"hehe",
          Total_Pembelian: 0,
          Total_Service: 0,
          Total_Seluruh: 0,
          Diskon: 0,
          Status: this.editedItem.Status,           
          kustomer_id: this.editedItem.kustomer_id,
          user_id: this.editedItem.user_id,

           })
        .then(response => {
          console.log(response);
        })
        this.close();
    },    
  }
}
</script>
