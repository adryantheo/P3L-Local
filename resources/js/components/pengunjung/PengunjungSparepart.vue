<template>

    <v-layout align-space-around justify-center fill-height >
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>
          Sparepart
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
        :items="sparepart"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
         
          <td >{{ props.item.Kode_Sparepart }}</td>
          <td >{{ props.item.Nama }}</td>
          <td >{{ props.item.Tipe }}</td>
          <td >{{ props.item.Merk }}</td>
          <td >{{ props.item.Jenis_Motor }}</td>
          <td ><v-img :src="props.item.Gambar"></v-img></td>
          <td >Rp. {{ props.item.Harga_Jual }}</td>
          <td >{{ props.item.Stok }}</td>
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
      
      { text: 'Kode Sparepart', value: 'Kode_Sparepart', sortable: false },
      { text: 'Nama', value: 'Nama', sortable: false },
      { text: 'Tipe', value: 'Tipe', sortable: false },
      { text: 'Merk', value: 'Merk', sortable: false },
      { text: 'Jenis Motor', value: 'Jenis_Motor', sortable: false },
      { text: 'Gambar', value: 'Gambar', sortable: false },
      { text: 'Harga', value: 'Harga_Jual', sortable: true },
      { text: 'Stok', value: 'Stok', sortable: true },    

    ],
    sparepart: [],
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
      axios.get('/8786/api/sparepart')
      .then(response => this.sparepart = response.data)
    },
    
    initialize() {
      this.fetchsparepart();
    },

  }
}
</script>