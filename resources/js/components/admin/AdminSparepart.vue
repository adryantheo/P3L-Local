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
            <v-btn color="primary" dark class="mb-2" v-on="on">New sparepart</v-btn>
          </template>
          
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Kode_Sparepart" label="Kode Sparepart" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Nama" label="Nama" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-select :items="types" v-model="editedItem.Tipe" label="Tipe" :rules="[rules.required]"></v-select>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Merk" label="Merk" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Jenis_Motor" label="Jenis Motor" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <!-- <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Harga_Beli" label="Harga Beli"></v-text-field>
                  </v-flex> -->
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Harga_Jual" label="Harga Jual" :rules="[rules.required, rules.notZero, rules.tooMuch]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Letak" label="Letak" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Stok" label="Stok" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="editedItem.Stok_Min" label="Stok Min" :rules="[rules.required]"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                     <v-btn color="primary" flat @click="pickFile">
                    Upload Gambar
                </v-btn>
                <v-img class="sparepart-img"
                    v-if="!!fileUrl"
                    :src="fileUrl"
                    max-height="200px"
                    contain
                ></v-img>
                <input type="file"
                    ref="file"
                    name="thumbnail"
                    @change="onFileChange(
                        $event.target.name, $event.target.files)"
                    style="display:none">
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
          <td >{{ props.item.Letak }}</td>
          <td >{{ props.item.Stok }}</td>
          <td >{{ props.item.Stok_Min }}</td>
         
          <td>
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

    rules: {
        email: v => (v || '').match(/@/) || 'Format Email Salah',
        length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
        password: v => (v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) || 'password must contain an upper case letter, a numeric character, and a special character',
        required: v => !!v || 'Tidak Boleh Kosong',
        number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
        notZero: v => v > 0 || 'Tidak boleh 0',
        tooMuch: v => v < 999999999 || 'Nilai terlalu besar!',
      },

    types:['Roda',
      'Kelistrikan',
      'Mesin',
      'Kelistrikan',
      'Rem',
      'Copling',
      'CVT',
      ],

    isLoggedIn: localStorage.getItem('jwt') != null,

    beforeMount(){
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },


    dialog: false,
    search: '',
    fileUrl: '',
    fileBin: '',
    Kode_Sparepart: null,
    Nama: null,
    Tipe: null,
    Merk: null,
    Jenis_Motor: null,
    // Harga_Beli: null,
    Harga_Jual: null,
    Letak: null,
    Stok: null,
    Stok_Min: null,
    headers: [
      
      { text: 'Kode Sparepart', value: 'Kode_Sparepart', sortable: true },
      { text: 'Nama', value: 'Nama', sortable: true },
      { text: 'Tipe', value: 'Tipe', sortable: true },
      { text: 'Merk', value: 'Merk', sortable: true },
      { text: 'Jenis Motor', value: 'Jenis_Motor', sortable: true },
       { text: 'Gambar', value: 'Gambar', sortable: false },
     
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
    pickFile(){
            this.$refs.file.click();
        },
        onFileChange(fieldName, file) {
            const { maxSize } = this;
            console.log(fieldName);
            
            let imageFile = file[0]
            if (file.length > 0) {
                let size = imageFile.size / maxSize / maxSize
                if (!imageFile.type.match('image.*')) {
                    this.errorText = 'File harus berupa gambar!';
                } else if (size>1) {
                    // check whether the size is greater than the size limit
                    this.errorText = 'Ukuran file harus dibawah 1 MB!'
                } else {
                    this.errorText = '';
                    
                    this.fileUrl = URL.createObjectURL(imageFile);
                    this.fileBin = imageFile;
                    
                }
            }
        },
    
    fetchsparepart() {
      axios.get('/8786/api/sparepart')
      .then(response => this.sparepart = response.data)
    },
    
    initialize() {
      this.fetchsparepart();
    },

    editItem (item) {
      this.editedIndex = this.sparepart.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.sparepart.indexOf(item)
      confirm('Are you sure you want to delete this item?') && this.sparepart.splice(index, 1)
      console.log('deleted data');

      axios.delete('/8786/api/sparepart/'+item.id)
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

        this.Kode_Sparepart=this.editedItem.Kode_Sparepart,
        this.Nama=this.editedItem.Nama,
        this.Tipe=this.editedItem.Tipe,
        this.Merk=this.editedItem.Merk,
        this.Jenis_Motor=this.editedItem.Jenis_Motor,
        // this.Harga_Beli=this.editedItem.Harga_Beli,
        this.Harga_Jual=this.editedItem.Harga_Jual,
        this.Letak=this.editedItem.Letak,
        this.Stok=this.editedItem.Stok,
        this.Stok_Min=this.editedItem.Stok_Min
        console.log('created Data');
        const data = new FormData();
        data.append(`Kode_Sparepart`, this.Kode_Sparepart);
        data.append(`Nama`, this.Nama);
        data.append(`Tipe`, this.Tipe);
        data.append(`Merk`, this.Merk);
        data.append(`Jenis_Motor`, this.Jenis_Motor);
        data.append(`Gambar`, this.fileBin);
        // data.append(`Harga_Beli`, this.Harga_Beli);
        data.append(`Harga_Jual`, this.Harga_Jual);
        data.append(`Letak`, this.Letak);
        data.append(`Stok`, this.Stok);
        data.append(`Stok_Min`, this.Stok_Min);
       axios.post('/8786/api/sparepart/'+this.editedItem.id,data,{
         headers: {
              'Content-Type': 'multipart/form-data'
          }
       })
        .then(response => {
          console.log(response);
        })
       
        Object.assign(this.sparepart[this.editedIndex], this.editedItem)
        
      } else {
        this.Kode_Sparepart=this.editedItem.Kode_Sparepart,
        this.Nama=this.editedItem.Nama,
        this.Tipe=this.editedItem.Tipe,
        this.Merk=this.editedItem.Merk,
        this.Jenis_Motor=this.editedItem.Jenis_Motor,
        // this.Harga_Beli=this.editedItem.Harga_Beli,
        this.Harga_Jual=this.editedItem.Harga_Jual,
        this.Letak=this.editedItem.Letak,
        this.Stok=this.editedItem.Stok,
        this.Stok_Min=this.editedItem.Stok_Min
        console.log('created Data');
        const data = new FormData();
        data.append(`Kode_Sparepart`, this.Kode_Sparepart);
        data.append(`Nama`, this.Nama);
        data.append(`Tipe`, this.Tipe);
        data.append(`Merk`, this.Merk);
        data.append(`Jenis_Motor`, this.Jenis_Motor);
        data.append(`Gambar`, this.fileBin);
        // data.append(`Harga_Beli`, this.Harga_Beli);
        data.append(`Harga_Jual`, this.Harga_Jual);
        data.append(`Letak`, this.Letak);
        data.append(`Stok`, this.Stok);
        data.append(`Stok_Min`, this.Stok_Min);
        axios.post('/8786/api/sparepart', data
          , {
          headers: {
              'Content-Type': 'multipart/form-data'
                            }
        }
        
          )
        .then(response => {
          console.log(response);
        })
        this.sparepart.push(this.editedItem)
      }
      this.close()
    }
  }
}
</script>