<template>

    <v-layout align-space-around justify-center fill-height>
    <v-flex> 
    <v-toolbar flat color="white">
        <v-toolbar-title>Transaksi</v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
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
          
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Nama_Kustomer" label="Nama Kustomer"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Alamat_Kustomer" label="Alamat Kustomer"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Telepon_Kustomer" label="Contact Kustomer"></v-text-field>
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
      <v-data-table
        :headers="headers"
        :items="kustomer"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
         
          <td >{{ props.item.Nama_Kustomer }}</td>
          <td >{{ props.item.Alamat_Kustomer }}</td>
          <td >{{ props.item.Telepon_Kustomer }}</td>
          <td >{{ props.item.updated_at }}</td>
         
         
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
    headers: [
      
      { text: 'Nama Kustomer', value: 'Nama_Kustomer', sortable: true },
      { text: 'Alamat Kustomer', value: 'Alamat_Kustomer', sortable: false },
      { text: 'Kontak', value: 'Telepon_Kustomer', sortable: false },       
      { text: 'Tanggal Transaksi', value: 'updated_at', sortable: true }, 
      
    ],
    kustomer: [],
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
    
    fetchkustomer() {
      axios.get('/8786/api/kustomer')
      .then(response => this.kustomer = response.data)
    },
    
    initialize() {
      this.fetchkustomer();
    },

   

    
     
  }
}
</script>