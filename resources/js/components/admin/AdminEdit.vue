<template>

    <v-layout align-space-around justify-center fill-height v-if="isLoggedIn">
    <v-flex>
    
  
    <v-toolbar flat color="white">
        <v-toolbar-title>Data Pegawai</v-toolbar-title>
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
          <v-btn color="primary" dark class="mb-2" v-on="on">New Pegawai</v-btn>
          </template>
          
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field prepend-icon="person" v-model="editedItem.Nama" label="Nama" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field prepend-icon="person" v-model="editedItem.email" label="Email" :rules="[rules.required, rules.email]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field prepend-icon="person" v-model="editedItem.Alamat" label="Alamat" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field prepend-icon="person" v-model="editedItem.Gaji" label="Gaji" :rules="[rules.required, rules.number, rules.notZero, rules.tooMuch]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-select  prepend-icon="person" v-model="editedItem.Role"  :items="items"  label="Role"  :rules="[rules.required]" ></v-select>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field prepend-icon="lock" v-model="editedItem.password" label="Password" type="password" :rules="[rules.required, rules.password]"></v-text-field>
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
        :items="pegawai"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td >{{ props.item.Nama }}</td>
          <td >{{ props.item.email }}</td>
          <td >{{ props.item.Alamat }}</td>
          <td >Rp. {{ props.item.Gaji }}</td>
          <td >{{ props.item.Role }}</td>
          <td class="layout px-0">
            <v-icon
              small
              class="mr-2"
              @click="editItem(props.item)"
            >
              edit
            </v-icon>
            <v-icon
              small
              @click="deleteItem(props.item)"
            >
              delete
            </v-icon>
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

    items:['CS', 'Kasir', 'Montir'],

     rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong',
        number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
        notZero: v => v > 0 || 'Tidak boleh kurang dari 1',
        tooMuch: v => v < 999999999 || 'Nilai terlalu besar!',
      },

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },

    dialog: false,
    search: '',
    headers: [
      { text: 'Nama', value: 'Nama', sortable: true },
      { text: 'Email', value: 'Email', sortable: false },
      { text: 'Alamat', value: 'Alamat', sortable: false },
      { text: 'Gaji', value: 'Gaji', sortable: true },
      { text: 'Role', value: 'Role', sortable: false },
      { text: 'Actions', value: 'id', sortable: false }
    ],
    pegawai: [],
    editedIndex: -1,
    editedItem: {
      
    },
    defaultItem: {
      
    }
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Pegawai' : 'Edit Pegawai'
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
    
    fetchpegawai() {
      axios.get('/8786/api/pegawai')
      .then(response => this.pegawai = response.data)
    },

    initialize () {
      this.fetchpegawai();
    },

    editItem (item) {
      this.editedIndex = this.pegawai.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.pegawai.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.pegawai.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/pegawai/'+item.id)
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
      if (this.editedIndex > -1) {
        console.log('Edited Data');
        Object.assign(this.pegawai[this.editedIndex], this.editedItem)

        axios.post('/8786/api/pegawai/'+this.editedItem.id,{
          Nama:this.editedItem.Nama,
          email:this.editedItem.email,
          Alamat:this.editedItem.Alamat,
          Gaji:this.editedItem.Gaji,
          Role:this.editedItem.Role,
          password:this.editedItem.password,
          
           })
        .then(response => {
          console.log(response);
        })

      } else {
        this.pegawai.push(this.editedItem)

        axios.post('/8786/api/register',{
          Nama:this.editedItem.Nama,
          email:this.editedItem.email,
          Alamat:this.editedItem.Alamat,
          Gaji:this.editedItem.Gaji,
          Role:this.editedItem.Role,
          password:this.editedItem.password,
          
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