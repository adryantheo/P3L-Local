<template>

    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>
          <router-link :to="{ name: 'AdminSparepart' }" class="nav-link" >Sparepart</router-link>
          </v-toolbar-title>
        
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <v-toolbar-title>
          <router-link :to="{ name: 'AdminKurangSparepart' }" class="nav-link" >Stok Kurang</router-link>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
              <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
           
          </template>
          
          
        </v-dialog>
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
              <!-- <td >{{ props.item.Harga_Beli }}</td> -->
              <td >{{ props.item.Harga_Jual }}</td>
              <td >{{ props.item.Letak }}</td>
              <td >{{ props.item.Stok }}</td>
              <td >{{ props.item.Stok_Min }}</td>          
              <td>
                <v-btn>
                  <router-link :to="{ name: 'AdminPesan' }" class="nav-link" >Pesan Sekarang</router-link>
                </v-btn>
              </td>
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
    

    isLoggedIn: localStorage.getItem('jwt') != null,

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },


    dialog: false,
    search: '',
    
    
    headers: [
      
      { text: 'Kode Sparepart', value: 'Kode_Sparepart', sortable: true },
      { text: 'Nama', value: 'Nama', sortable: true },
      { text: 'Tipe', value: 'Tipe', sortable: true },
      { text: 'Merk', value: 'Merk', sortable: true },
      { text: 'Jenis Motor', value: 'Jenis_Motor', sortable: true },
       { text: 'Gambar', value: 'Gambar', sortable: false },
      // { text: 'Harga Beli', value: 'Harga_Beli', sortable: true },
      { text: 'Harga Jual', value: 'Harga_Jual', sortable: true },
      { text: 'Letak', value: 'Letak', sortable: false },
      { text: 'Stok', value: 'Stok', sortable: true },    
      { text: 'Stok Min', value: 'Stok_Min', sortable: true },      
      { text: 'Actions', value: 'id', sortable: false }
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
   async fetchsparepart() {
     const res = await axios.get('/8786/api/sparepart/all').then(response => this.sparepart = response.data);

    },
    
    initialize() {
      this.fetchsparepart();
    },

  }
}
</script>