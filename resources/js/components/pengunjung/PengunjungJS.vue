<template>

    <v-layout align-space-around justify-center fill-height >
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>
          Jasa Service
          </v-toolbar-title>
               
        <v-spacer></v-spacer>
         <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-data-table
        :headers="headers"
        :items="JS"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
         
           <td >{{ props.item.Nama_Service }}</td>
          <td >Rp. {{ props.item.Tarif }}</td>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
         <v-alert v-slot:no-results :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
          </v-alert>
      </v-data-table>

    </v-flex>
    </v-layout>
</template>

<script>
export default {
    
  data: () => ({

    dialog: false,
    search: '',
    fileUrl: '',
    fileBin: '',
    Kode_Sparepart: null,
    Nama: null,
    Tipe: null,
    Merk: null,
    Jenis_Motor: null,
    Harga_Jual: null,
    Letak: null,
    Stok: null,
    Stok_Min: null,
    headers: [
      
       { text: 'Nama Service', value: 'Nama_Service', sortable: true },
      { text: 'Harga', value: 'Tarif', sortable: true },

    ],
    JS: [],
    editedIndex: -1,
    editedItem: {
     
    },
    defaultItem: {
      
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    }
  },

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  created () {
    this.initialize()
  },

  methods: {
   
    fetchsparepart() {
      axios.get('/8786/api/service')
      .then(response => this.JS = response.data)
    },
    
    initialize() {
      this.fetchsparepart();
    },

  }
}
</script>