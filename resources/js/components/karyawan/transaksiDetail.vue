<template>
    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
        <v-flex>  
          <v-layout row align-center>
                <v-btn fab dark color="primary" to="/karyawan/transaksi">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
                <div class="ml-4">
                    <div class="headline font-weight-bold mb-1">Detail Transaksi</div>
                    <v-btn color="primary" dark class="mb-2" @click="printOrders">Cetak SPK</v-btn>

                    <v-dialog v-model="dialogPay" persistent max-width="600px">
                        <template v-slot:activator="{ on }">
                          <v-btn color="primary" dark v-on="on">Bayar</v-btn>
                        </template>
                        <v-card>
                          <v-card-title>
                            <span class="headline">Pembayaran</span>
                          </v-card-title>
                          <v-card-text>
                            <v-container grid-list-md>
                              <v-layout wrap>
                                <v-flex xs12 >
                                  <p>ID Transaksi : {{this.transaksi}}</p>
                                </v-flex>
                                <v-flex xs12 >
                                  <p>Customer : {{this.detailTransaksi.kustomer.Nama_Kustomer}}</p>
                                </v-flex>
                                <v-flex xs12 >
                                  <p>Total Service : Rp. {{this.detailTransaksi.Total_Service}}</p>
                                </v-flex>
                                <v-flex xs12 >
                                  <p>Total Sparepart : Rp. {{this.detailTransaksi.Total_Pembelian}}</p>
                                </v-flex>
                                <v-flex xs12 >
                                  <p>Total Harga : Rp. {{this.detailTransaksi.Total_Seluruh}}</p>
                                </v-flex>
                              </v-layout>
                            </v-container>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="dialogPay = false">Close</v-btn>
                            <v-btn color="blue darken-1" flat @click="PayItem">Bayar</v-btn>
                          </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <!-- <v-btn color="primary" dark class="mb-2" @click="printNota">Cetak Nota</v-btn> -->
                </div>
            </v-layout>
            
            <v-dialog v-model="dialogService" max-width="500px">
                      <template v-slot:activator="{ on }">
                    <v-spacer></v-spacer>
                        <v-btn color="primary" dark class="mb-2" v-on="on">New Service</v-btn>
                      </template>
                      <v-card>
                        <v-card-title>
                          <span class="headline">{{ formTitle }}</span>
                        </v-card-title>
                        <v-card-text>
                          <v-container grid-list-md>
                            <v-layout wrap>
                              <v-flex xs12 sm6 md4>
                                <v-select :items="kendaraan" item-text="Tipe" item-value="id" v-model="editedItem.kendaraan_id" label="ID Kendaraan" ></v-select>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-select :items="service" item-text="Nama_Service" item-value="id" v-model="editedItem.service_id" label="Service ID" ></v-select>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-text-field v-model="editedItem.Jumlah_Service" label="Jumlah_Service"></v-text-field>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-select :items="items" v-model="editedItem.StatusService" label="Status" ></v-select>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-select :items="pegawai" item-text="Nama" item-value="id" v-model="editedItem.user_id" label="Nama Montir" ></v-select>
                              </v-flex>
                            </v-layout>
                          </v-container>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                          <v-btn color="blue darken-1" flat @click="saveService">Save</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
        

        <v-data-table
            :headers="headerService"
            :items="TService"
            :search="search"
            class="elevation-1">
         <template v-slot:items="props">
        
            <td>{{ props.item.services.Nama_Service }}</td>
            <td> {{ props.item.pegawai.Nama }}</td>
            <td>{{ props.item.kendaraans.Plat_kendaraan }}</td>
            <td> {{ props.item.Status }}</td>
            <td> {{ props.item.Jumlah_Service }}</td>
            <td>Rp. {{ props.item.Total_Biaya }}</td>
            
            <td class=" layout px-0">
                <v-icon
                small
                class="mr-2"
                @click="editItemService(props.item)"
                >
                edit
                </v-icon>
                <v-icon
                small
                @click="deleteItemService(props.item)"
                >
                delete
                </v-icon>
            </td>
         </template>       
        </v-data-table>

        <br>

        <v-dialog v-model="dialogSparepart" max-width="500px">
          <template v-slot:activator="{ on }">
        <v-spacer></v-spacer>
            <v-btn color="primary" dark class="mb-2" v-on="on">New Sparepart</v-btn>
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
                    <v-select :items="pegawai" item-text="Nama" item-value="id"  v-model="editedItem.user_id" label="Nama Pegawai" ></v-select>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Jumlah_Dibeli" label="Jumlah Items"></v-text-field>
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
            
                <td>{{ props.item.spareparts.Nama }}</td>
                <td> {{ props.item.Jumlah_Dibeli }}</td>
                <td>Rp. {{ props.item.Subtotal }}</td>
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

      


      </v-flex>

  <!-- Print SPK -->

    <div v-show="false" id="printMe">
      <div class="ma-3">              
        <div style="text-align: center">                  
            <p class="headline">ATMA AUTO</p>
            <p class="" >MOTORCYCLE SPAREPARTS AND SERVICES</p>
            <p class="">Jl. Babarsari No. 43 Yogyakarta 552181</p>
            <p class="">Telp. (0274)487711</p>
            <p class="">http://www.atmaauto.com</p>
            <hr>
            <br>
            <p class="title">SURAT PERINTAH KERJA</p>
             <div style="text-align: right">                  
                 <p>{{this.detailTransaksi.created_at}}</p>
                 <p>CS: {{this.dataPegawai.Nama}}</p>
                 <p>Montir: {{this.dataPegawai.Nama}}</p>
              </div>
              <div style="text-align: left">
                 <p>No: {{this.detailTransaksi.id}}</p>
                 <p>Cust: {{this.dataKustomer.Nama_Kustomer}}</p>
                 <p>Telepon: {{this.dataKustomer.Telepon_Kustomer}}</p> 
              </div>                                       
        </div>
            <br><br>
            <div style="text-align: center">
              <p class="headline">SERVICE</p>
              <table style="width:100%" border="bold">
              <tr>
                <th>No</th>
                <th>Nama</th> 
                <th>Jumlah</th>
              </tr>
              <template v-for="(data, i) in TService">
                <tr :key="i">
                  <td>{{data.id}}</td>
                  <td>{{data.services.Nama_Service}}</td>
                  <td>{{data.Jumlah_Service}}</td>
                </tr>
              </template>
            </table>
            </div>
            <br>
            <div style="text-align: center">
              <p class="headline">SPAREPARTS</p>
              <table style="width:100%" border="bold">
              <tr>
                <th>No</th>
                <th>Nama</th> 
                <th>Merk</th>
                <th>Rak</th>
                <th>Jumlah</th>
              </tr>
              <template v-for="(data, i) in TSparepart">
                <tr :key="i">
                  <td>{{data.id}}</td>
                  <td>{{data.spareparts.Nama}}</td>
                  <td>{{data.spareparts.Merk}}</td>
                  <td>{{data.spareparts.Letak}}</td>
                  <td>{{data.Jumlah_Dibeli}}</td>
                </tr>
              </template>
            </table>
          </div>
      </div>
    </div>

  <!-- Print Nota -->

          <div v-show="false" id="printNot">
             <div class="ma-3">              
                <div style="text-align: center">                  
                    <p class="headline">ATMA AUTO</p>
                    <p class="" >MOTORCYCLE SPAREPARTS AND SERVICES</p>
                    <p class="">Jl. Babarsari No. 43 Yogyakarta 552181</p>
                    <p class="">Telp. (0274)487711</p>
                    <p class="">http://www.atmaauto.com</p>
                    <hr>
                    <br>
                    <p class="title">NOTA LUNAS</p>
                      <div style="text-align: right">                  
                        <p>{{this.detailTransaksi.created_at}}</p>
                        <p>CS: {{this.dataPegawai.Nama}}</p>
                        <p>Montir: {{this.dataPegawai.Nama}}</p>
                      </div>
                      <div style="text-align: left">
                        <p>No: {{this.detailTransaksi.id}}</p>
                        <p>Cust: {{this.dataKustomer.Nama_Kustomer}}</p>
                        <p>Telepon: {{this.dataKustomer.Telepon_Kustomer}}</p> 
                      </div>                                                
                </div>
                    <br><br>
                    <div style="text-align: center">
                      <p class="headline">SERVICE</p>
                      <table style="width:100%" border="bold">
                      <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                      </tr>
                      <template v-for="(data, i) in TService">
                        <tr :key="i">
                          <td>{{data.id}}</td>
                          <td>{{data.services.Nama_Service}}</td>
                           <td>{{data.services.Tarif}}</td>
                          <td>{{data.Jumlah_Service}}</td>
                          <td>Rp. {{data.Total_Biaya}}</td>
                        </tr>
                      </template>
                    </table>
                    </div>
                    <br>
                    <div style="text-align: center">
                      <p class="headline">SPAREPARTS</p>
                      <table style="width:100%" border="bold">
                      <tr>
                        <th>Kode</th>
                        <th>Nama</th> 
                        <th>Merk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                      </tr>
                      <template v-for="(data, i) in TSparepart">
                        <tr :key="i">
                          <td>{{data.spareparts.Kode_Sparepart}}</td>
                          <td>{{data.spareparts.Nama}}</td>
                          <td>{{data.spareparts.Merk}}</td>
                          <td>Rp. {{data.spareparts.Harga_Jual}}</td>
                          <td>{{data.Jumlah_Dibeli}}</td>
                          <td>Rp. {{data.Subtotal}}</td>
                        </tr>
                      </template>
                    </table>
                  </div>
             </div>
            </div>


    </v-layout>

</template>

<script>

export default {

  props:{
      transaksi: {
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
    dialogService: false,
    dialogPay:false,
    search: '',
    headerService: [
      { text: 'ID Service', value: '', sortable: true },
      { text: 'Pegawai', value: '', sortable: false },
      { text: 'Kendaraan', value: '', sortable: false },
      { text: 'Status', value: '', sortable: false },
      { text: 'Jumlah Service', value: '', sortable: true },
      { text: 'Total Biaya', value: '', sortable: true },   
      { text: 'Actions', value: 'id', sortable: false }
    ],
    headerSparepart: [
      { text: 'ID Sparepart', value: '', sortable: true },
      { text: 'Jumlah Beli', value: '', sortable: false },
      { text: 'Subtotal', value: '', sortable: false },   
      { text: 'Actions', value: 'id', sortable: false }
    ],   
    sparepart: [],
    TService: [],
    TSparepart:[],
    dataKustomer:[],
    dataPegawai:[],
    service: [],
    kustomer: [],
    kendaraan: [], 
    detailTransaksi: [],
    pegawai: [],
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

    PayItem(){
      axios.patch(`/8786/api/transaksi-paid/${this.transaksi}`);
      axios.patch(`/8786/api/transaksi/${this.transaksi}`,{
        Status: "Sudah Selesai",
      });
      this.printNota();
        this.dialogPay = false;

    },

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

    fetchkustomer(){
      axios.get('/8786/api/kustomer')
      .then(response => this.kustomer = response.data)

    },

    fetchkendaraan(){
      axios.get('/8786/api/kendaraan')
      .then(response => this.kendaraan = response.data)

    },

   
    fetchTransaksiDetail() {
      axios.get(`/8786/api/transaksi/${this.transaksi}`)
       .then(response => {
         this.detailTransaksi = response.data
         console.log(response.data)
         this.TService = this.detailTransaksi.transaksi_service;
         this.TSparepart = this.detailTransaksi.transaksi_sparepart;
         this.dataKustomer = this.detailTransaksi.kustomer;
         this.dataPegawai = this.detailTransaksi.pegawai;
         })
      
    },

    fetchservice(){
      axios.get('/8786/api/service')
      .then(response => this.service = response.data)
      
    },
    fetchpegawai(){
      axios.get('/8786/api/pegawai')
      .then(response => this.pegawai = response.data)
    },
    
    fetchsparepart(){
      axios.get('/8786/api/sparepart')
      .then(response => this.sparepart = response.data)
    },

    initialize() {
      this.fetchkustomer();
      this.fetchkendaraan();
      this.fetchservice();
      this.fetchpegawai();
      this.fetchsparepart()
      this.fetchTransaksiDetail();
    },

    editItem (item) {
      this.editedIndex = this.transaksi.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    editItemService (item) {
      this.editedIndex = this.TService.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogService = true
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

     deleteItemService (item) {
      const index = this.TService.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.TService.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/transaksi-service/'+item.id)
        .then(response => {
          console.log(response);
        })
    },

    deleteItemSparepart (item) {
      const index = this.TSparepart.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.TSparepart.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/transaksi-sparepart/'+item.id)
        .then(response => {
          console.log(response);
        })
    },

    close () {
      this.dialog = false
      this.dialogSparepart = false
      this.dialogService = false
      this.dialogPay = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    
    saveService () {

      
      if (this.editedIndex > -1) {
        console.log('Edited Data');
        axios.patch('/8786/api/transaksi-service/'+this.editedItem.id,{
          Total_Biaya: this.editedItem.Jumlah_Service,
          Jumlah_Service: this.editedItem.Jumlah_Service,
          Status: this.editedItem.StatusService,
          service_id: this.editedItem.service_id,
          kendaraan_id: this.editedItem.kendaraan_id,           
          transaksi_id: `${this.transaksi}`,
          user_id: this.editedItem.user_id,
           })
        .then(response => {
          console.log(response);
        })
       
        Object.assign(this.TService[this.editedIndex], this.editedItem)
      }else{
        console.log('created Data');
        axios.post('/8786/api/transaksi-service',{
          Total_Biaya: this.editedItem.Jumlah_Service,
          Jumlah_Service: this.editedItem.Jumlah_Service,
          Status: this.editedItem.StatusService,
          service_id: this.editedItem.service_id,
          kendaraan_id: this.editedItem.kendaraan_id,           
          transaksi_id: `${this.transaksi}`,
          user_id: this.editedItem.user_id,
           })
        .then(response => {
          console.log(response);
        })
      }
        this.close()
    },
    saveSparepart () {

      if (this.editedIndex > -1) {
        console.log('Edited Data');
        axios.patch('/8786/api/transaksi-sparepart/'+this.editedItem.id,{
          Jumlah_Dibeli:this.editedItem.Jumlah_Dibeli,
          Subtotal: this.editedItem.Jumlah_Dibeli*2000,
          Sisa_Stok: 0,
          transaksi_id: `${this.transaksi}`,
          sparepart_id: this.editedItem.sparepart_id,
          user_id: this.editedItem.user_id,
           })
        .then(response => {
          console.log(response);
        })
      }else{
        console.log('created Data');
        axios.post('/8786/api/transaksi-sparepart',{
          Jumlah_Dibeli:this.editedItem.Jumlah_Dibeli,
          Subtotal: this.editedItem.Jumlah_Dibeli,
          Sisa_Stok: 0,
          transaksi_id: `${this.transaksi}`,
          sparepart_id: this.editedItem.sparepart_id,
          user_id: this.editedItem.user_id,       
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
