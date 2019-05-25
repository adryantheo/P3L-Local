<template>  
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Tahun</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" v-model="year" label="Tahun" type="text" :rules="[rules.required]" ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="cari">Cari</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
          <v-dialog v-model="dialog" max-width="800px">
            <template v-slot:activator="{ on }">
            </template>
           <v-card>
            <v-card-title>
              <span class="headline">Laporan Penjualan Jasa {{this.year}}</span>
            </v-card-title>
            <v-card-text>
              <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Nama Service</th>
                        <th>Jumlah Penjualan</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>{{!!data.Nama_Service? data.Nama_Service:"-"}}</td>
                           <td>{{!!data.Count? data.Count:0}}</td>
                        </tr>
                      </template>
                    </table> 
                  <v-btn color="primary" @click="printMe">Print</v-btn>
            </v-card-text>
            <div>
              <apexchart width="500" type="bar" :options="chartOptions" :series="series"></apexchart>
            </div>
          </v-card>
          </v-dialog>
        </v-layout>

        <!-- print -->

        <div v-show="false" id="printMe">
      <div class="ma-3">              
        <div class="text-xs-center">                
            <p align="center" class="headline">ATMA AUTO</p>
            <p align="center" class="" >MOTORCYCLE SPAREPARTS AND SERVICES</p>
            <p align="center" class="">Jl. Babarsari No. 43 Yogyakarta 552181</p>
            <p align="center" class="">Telp. (0274)487711</p>
            <p align="center" class="">http://www.atmaauto.com</p>
            <hr>
            <br>
            <p align="center" class="title">LAPORAN PENJUALAN JASA</p>
             <div class="text-xs-left">                  
                 <p align="left">Tahun: {{this.year}}</p>
              </div>                                  
        </div>
            <br>
            <div class="text-xs-center">
              <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Nama Service</th>
                        <th>Jumlah Penjualan</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>{{!!data.Nama_Service? data.Nama_Service:"-"}}</td>
                           <td>{{!!data.Count? data.Count:0}}</td>
                        </tr>
                      </template>
                </table> 
          </div>
      </div>
    </div>


      </v-container>
    
</template>


<script>

  export default {
    props: ['nextUrl'],
    data: () => ({
      
      chartOptions: {
        chart: {
            id: 'vuechart-example'
          },
          xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','June','July','Aug','Sep','Oct','Nov','Des']
          }
      },

      series: [{
        name: 'series-1',
          data: []

      }],

      Best_Seller: [],
      BS: [],
      cek: [],
      cek2: [],
      year: "",
      bulan: ['bulan','Jan','Feb','Mar','Apr','May','June','July','Aug','Sep','Oct','Nov','Des'],
           
      rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong'
      },
      dialog: false,
      editedItem: {  
    },
    }),
    computed: {
        formTitle () {
      return this.editedIndex === -1 ? 'Data User' : 'Data Tidak Ditemukan'
    }
    },
    methods:{
      
      convert(){

        let listOfObjects = Object.keys(this.cek.Count).map((key) =>{
          return this.cek.Count[key]
        })

        console.log(this.listOfObjects);

      },
            
       printMe(){
            this.$htmlToPaper('printMe');
        },
        cari(){
          var Convert = [];
            this.dialog = true;
            axios.get('/8786/api/laporan/most/'+ this.year)
            .then(response =>{
              this.Best_Seller = response.data
              this.cek = this.Best_Seller.Best_Seller
              this.Convert =JSON.parse(JSON.stringify(this.cek))
              console.log(this.Convert);
              })

            axios.get('/8786/api/laporan/most-number/'+ this.year)
            .then(response =>{
              let counter = new Array();
              this.BS = response.data
              if(this.BS){
                this.BS.forEach(element=>{
                  counter.push(element.Best_Seller);
                });
              }
              console.log(counter);
              // this.cek2 = this.BS.Best_Seller
              // this.Convert =JSON.parse(JSON.stringify(this.cek2))
              // this.data = this.Convert;
              // console.log(this.Convert);
              })
  
        },
        
    }
  }
</script>