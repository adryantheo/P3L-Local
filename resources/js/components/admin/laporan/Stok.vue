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
                  <v-select :items="types" prepend-icon="person" v-model="type" label="Tipe" :rules="[rules.required]" ></v-select>
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
              <span class="headline">Laporan Sisa Stok {{this.type}} {{this.year}}</span>
            </v-card-title>
            <v-card-text>
              <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Sisa Stok</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>{{data.Sisa? data.Sisa:0}}</td>
                        </tr>
                      </template>
                    </table> 
                   <v-btn color="primary" @click="printMe">Print</v-btn>
            </v-card-text>
          </v-card>
          </v-dialog>
        </v-layout>

<!-- print -->

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
            <p class="title">LAPORAN SISA STOK</p>
             <div style="text-align: left">                  
                 <p>Tahun: {{this.year}}</p>
                 <p>Tipe: {{this.type}} </p>
              </div>                                  
        </div>
            <br>
            <div class="text-xs-center">
               <table style="width:100%" border="bold">
                      <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Sisa Stok</th>
                      </tr>
                      <template v-for="(data, i) in cek">
                        <tr :key="i">
                          <td>{{i}}</td>
                          <td>{{bulan[i]}}</td>
                          <td>{{data.Sisa? data.Sisa:0}}</td>
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
      Sisa: [],
      cek: [],
      year: "",
      type: "",
      bulan: ['bulan','Jan','Feb','Mar','Apr','May','June','July','Aug','Sep','Oct','Nov','Des'],
       types:['Roda',
      'Kelistrikan',
      'Mesin',
      'Kelistrikan',
      'Rem',
      'Copling',
      'CVT',
      ],
           
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
        printMe(){
            this.$htmlToPaper('printMe');
        },
        cari(){
            this.dialog = true;
            axios.get('/8786/api/laporan/stok/'+ this.year + '/' + this.type)
            .then(response =>{
              this.Sisa = response.data
              this.cek = this.Sisa.Sisa
              console.log(this.cek);
              })
  
        },
        
    }
  }
</script>