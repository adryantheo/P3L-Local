<template>
    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
        <v-flex>  
          <v-layout row align-center>
                <v-btn fab dark color="primary" to="/admin/pesan">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
                <div class="ml-4">
                    <div class="headline font-weight-bold mb-1">Detail Transaksi</div>
                    <v-btn color="primary" dark class="mb-2" @click="printOrders">Cetak SPB</v-btn>

                    
                    <!-- <v-btn color="primary" dark class="mb-2" @click="printNota">Cetak Nota</v-btn> -->
                </div>
            </v-layout>
             
        <v-dialog v-model="dialogSparepart" max-width="500px">
          <template v-slot:activator="{ on }">
        <v-spacer></v-spacer>
            <v-btn color="primary" dark class="mb-2" v-on="on">New Pengadaan</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-select :items="sparepart" item-text="Nama" item-value="id" v-model="editedItem.sparepart_id" label="ID Sparepart" ></v-select>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-select :items="sparepart" item-text="Nama" v-model="editedItem.Nama_Barang" label="Nama_Barang" ></v-select>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Jumlah_Pesan" label="Jumlah Pesan"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Jumlah_Diterima" label="Jumlah Diterima"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Harga_Beli" label="Harga_Beli"></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click="dialogSparepart = false">Cancel</v-btn>
              <v-btn color="blue darken-1" flat @click="saveSparepart">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-data-table
            :headers="headerSparepart"
            :items="TSparepart"
            :search="search"
            class="elevation-1"
            >
            <template v-slot:items="props">
            
                <td>{{ props.item.Nama_Barang }}</td>
                <td> {{ props.item.Jumlah_Pesan }}</td>
                <td>Rp. {{ props.item.Harga_Beli }}</td>
                <td> {{ props.item.Jumlah_Diterima }}</td>
                <td>Rp. {{ props.item.Total_Harga_Beli }}</td>
                <td class=" layout px-0">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItemSparepart(props.item)"
                >
                    edit
                </v-icon>
                <v-icon
                    small
                    @click="deleteItemSparepart(props.item)"
                >
                    delete
                </v-icon>
                </td>
            </template>
        </v-data-table>

            <div v-show="false" id="printMe">
      <div class="ma-3">              
        <div >                  
            <p align="center" class="headline">ATMA AUTO</p>
            <p align="center" class="" >MOTORCYCLE SPAREPARTS AND SERVICES</p>
            <p align="center" class="">Jl. Babarsari No. 43 Yogyakarta 552181</p>
            <p align="center" class="">Telp. (0274)487711</p>
            <p align="center" class="">http://www.atmaauto.com</p>
            <hr>
            <br>
            <p align="center" class="title">SURAT PENGADAAN BARANG</p>
             <div class="text-xs-right">
                <p align="right">No: {{this.detailTransaksi.id}}</p>                  
                 <p align="right">Tanggal: {{this.detailTransaksi.created_at}}</p>
              </div>
              <div class="text-xs-left">
                 <p align="left">Kepada Yth:</p>
                 <p align="left" >{{this.detailTransaksi.sales.Nama_Supplier}}</p>
                 <p align="left">{{this.detailTransaksi.sales.Alamat_Sales}}</p>
                 <p align="left">{{this.detailTransaksi.sales.Nomor_Telphone_Sales}}</p>
                 <br>
                 <p align="left">Mohon untuk disediakan barang-barang berikut:</p> 
              </div>                                       
        </div>
            <br><br>
            <div class="text-xs-center">
              <table style="width:100%" border="bold">
              <tr>
                <th>No</th>
                <th>Nama Barang</th> 
                <th>Merk</th>
                <th>Tipe Barang</th>
                <th>Satuan</th>
                <th>Jumlah</th>
              </tr>
              <template v-for="(data, i) in TSparepart">
                <tr :key="i">
                  <td>{{data.id}}</td>
                  <td>{{data.Nama_Barang}}</td>
                  <td>{{data.spareparts.Merk}}</td>
                  <td>{{data.spareparts.Tipe}}</td>
                  <td>Rp. {{data.Harga_Beli}}</td>
                  <td>{{data.Jumlah_Pesan}}</td>                  
                </tr>
              </template>
            </table>
            </div>
      </div>
    </div>


      </v-flex>

      <!-- Print -->





    </v-layout>

    

</template>

<script>

export default {

  props:{
      detailpesanan: {
          type: String,
          required: true,
      },

  },
    
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
    dialogSparepart: false,

    search: '',
    headerSparepart: [
      { text: 'Nama Barang', value: '', sortable: false },
      { text: 'Jumlah Pesan', value: '', sortable: false },
      { text: 'Harga Beli', value: '', sortable: false },
      { text: 'Jumlah Diterima', value: '', sortable: false },
      { text: 'Total Harga', value: '', sortable: false },   
      { text: 'Actions', value: 'id', sortable: false }
    ],   
    sparepart: [],
    TSparepart:[],
    TTSparepart:[],
    EpicSeller:[],
    detailTransaksi: [],
    pickedItem: null,
    idTS: 0,
    editedIndex: -1,
    editedItem: {},
    defaultItem: {}
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    getTotalHarga(){
      
      const hargaBeli = this.detailTransaksi.reduce((acc, item) => acc+(editedItem.Harga_Beli * editedItem.Jumlah_Pesan),0)
      return hargaBeli
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

    printOrders() {
            this.$htmlToPaper('printMe');
        },

    printNota() {
            this.$htmlToPaper('printNot');
        },

    getHargaBeli(){
       parseFloat(this.dataSparepart.Harga_Beli);

    },

   
    fetchTransaksiDetail() {
      axios.get(`/8786/api/pesanbarang/${this.detailpesanan}`)
       .then(response => {
         this.detailTransaksi = response.data
         console.log(response.data)
         this.TSparepart = this.detailTransaksi.detail_pesanans;
         this.TTSparepart = this.TSparepart.spareparts;
         this.EpicSeller = this.TSparepart.sales;
         console.log(this.TTSparepart);
         })
      
    },
    
    fetchsparepart(){
      axios.get('/8786/api/sparepart')
      .then(response => this.sparepart = response.data)
    },

    initialize() {
      this.fetchsparepart()
      this.fetchTransaksiDetail();
    },

    editItem (item) {
      this.editedIndex = this.transaksi.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },


    editItemSparepart (item) {
      this.editedIndex = this.TSparepart.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogSparepart = true
    },

    deleteItem (item) {
      const index = this.transaksi.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.pesanbarang.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/transaksi/'+item.id)
        .then(response => {
          console.log(response);
        })
    },

    deleteItemSparepart (item) {
      const index = this.TSparepart.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.TSparepart.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/detailpesanan/'+item.id)
        .then(response => {
          console.log(response);
        })
    },

    close () {
      this.dialog = false
      this.dialogSparepart = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    saveSparepart () {

      if (this.editedIndex > -1) {
        console.log('Edited Data');
        axios.patch('/8786/api/detailpesanan/'+this.editedItem.id,{
          Nama_Barang:this.editedItem.Nama_Barang,
          Harga_Beli:this.editedItem.Harga_Beli,
          Jumlah_Pesan: this.editedItem.Jumlah_Pesan,
          Jumlah_Diterima: this.editedItem.Jumlah_Diterima,
          pesanan__barang_id: `${this.detailpesanan}`,
          sparepart_id: this.editedItem.sparepart_id,
          Total_Harga_Beli: parseInt(this.editedItem.Jumlah_Pesan) * this.editedItem.Harga_Beli
           })
        .then(response => {
          console.log(response);
        })
      }else{
        console.log('created Data');
        axios.post('/8786/api/detailpesanan',{
          Nama_Barang:this.editedItem.Nama_Barang,
          Harga_Beli:this.editedItem.Harga_Beli,
          Jumlah_Pesan: this.editedItem.Jumlah_Pesan,
          Jumlah_Diterima: this.editedItem.Jumlah_Diterima,
          pesanan__barang_id: `${this.detailpesanan}`,
          sparepart_id: this.editedItem.sparepart_id,
          Total_Harga_Beli: parseInt(this.editedItem.Jumlah_Pesan) * this.editedItem.Harga_Beli       
           })
        .then(response => {
          console.log(response);
        })

      }      
        this.close()
    }
        
  }
}
</script>
