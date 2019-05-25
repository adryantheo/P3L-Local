//Vue
import Vue from 'vue'
import VueRouter from 'vue-router'

//View Pengunjung
import AppPengunjung from '../components/pengunjung/AppPengunjung.vue'
import Home from '../components/pengunjung/PengunjungHome.vue'
import JasaService from '../components/pengunjung/PengunjungJS.vue'
import Sparepart from '../components/pengunjung/PengunjungSparepart.vue'
import History from '../components/pengunjung/PengunjungHistory.vue'
import PengunjungPlat from '../components/pengunjung/PengunjungPlat.vue'
import PengunjungCari from '../components/pengunjung/PengunjungHape.vue'

import ContactUs from '../components/pengunjung/PengunjungContact.vue'

//view Admin
import AppAdmin from '../components/admin/AppAdmin.vue'
import AdminLogin from '../components/admin/AdminLogin.vue'
import AdminEdit from '../components/admin/AdminEdit.vue'
import AdminTransaksi from '../components/admin/AdminTransaksi.vue'
import AdminLaporan from '../components/admin/AdminLaporan.vue'
import AdminRegister from '../components/admin/AdminRegister.vue'
import AdminJasaService from '../components/admin/AdminJasaService.vue'
import AdminSparepart from '../components/admin/AdminSparepart.vue'
import AdminKurangSparepart from '../components/admin/AdminKurangSparepart.vue'
import AdminLogout from '../components/admin/AdminLogout.vue'
import AdminGantiPass from '../components/admin/AdminGantiPass.vue'
import AdminSales from '../components/admin/AdminSales.vue'
import AdminPesan from '../components/admin/AdminPesan.vue'
import AdminLJasa from '../components/admin/laporan/Jasa.vue'
import AdminLSparepart from '../components/admin/laporan/Sparepart.vue'
import AdminLPendapatan from '../components/admin/laporan/Pendapatan.vue'
import AdminLPengeluaran from '../components/admin/laporan/Pengeluaran.vue'
import AdminLStok from '../components/admin/laporan/Stok.vue'
import AdminLPendapatanCabang from '../components/admin/laporan/PendapatanCabang.vue'
import DetailPesanan from '../components/admin/pesananDetail.vue'

//View Pegawai
import AppKaryawan from '../components/karyawan/AppKaryawan.vue'
import KaryawanKustomer from '../components/karyawan/KaryawanKustomer.vue'
import KaryawanKendaraan from '../components/karyawan/KaryawanKendaraan.vue'
import KaryawanTransaksi from '../components/karyawan/KaryawanTransaksi.vue'
import KaryawanUnpaid from '../components/karyawan/KaryawanUnpaid.vue'
import TransaksiDetail from '../components/karyawan/transaksiDetail.vue'

Vue.use(VueRouter)

const routes = [
    {
        path:'/',        
        component: AppPengunjung,
        children:[
            {
                path: 'jasa-service',
                component: JasaService,

            },
            {
                path: 'sparepart',
                component: Sparepart,

            },
            {
                path: 'history',
                component: History,

            },
            {
                path: 'contactus',
                component: ContactUs,

            },
            {
                path: '/',
                component: Home,

            },
            {
                path: 'cariplat',
                name: 'cari-plat',
                component: PengunjungPlat,

            },
            {
                path: 'pengunjungcari',
                name: 'pengunjungcari',
                component: PengunjungCari,

            },
            {

                path:'/login',
                name: 'login',
                component: AdminLogin,
            },
            {

                path:'/logout',
                component: AdminLogout,
            },
            
        ]
    },
    {
        path:'/admin',
        component: AppAdmin,
        children:[
      
        
        {

            path:'/admin/register',
            name: 'register',
            component: AdminRegister,
        },
        {

            path:'/admin/gantipass',
            name: 'gantiPass',
            component: AdminGantiPass,
        },
        {

            path:'/admin/pegawai',
            component: AdminEdit,
        },
        {

            path:'/admin/transaksi',
            component: AdminTransaksi,
        },
        {

            path:'/admin/jasa-service',
            component: AdminJasaService,
        },
        {

            path:'/admin/sparepart',
            name: 'AdminSparepart',
            component: AdminSparepart,
        },
        {
            path:'/admin/laporan',
            component: AdminLaporan,
        },
        {
            path:'/admin/laporan/pendapatan',
            component: AdminLPendapatan,
        },
        {
            path:'/admin/laporan/pendapatan-cabang',
            component: AdminLPendapatanCabang,
        },
        {
            path:'/admin/laporan/pengeluaran',
            component: AdminLPengeluaran,
        },
        {
            path:'/admin/laporan/jasa',
            component: AdminLJasa,
        },
        {
            path:'/admin/laporan/sparepart',
            component: AdminLSparepart,
        },
        {
            path:'/admin/laporan/stok',
            component: AdminLStok,
        },
        {

            path:'/admin/sales',
            component: AdminSales,
        },
        {

            path:'/admin/pesan',
            name: 'AdminPesan',
            component: AdminPesan,
        },
        {
            path: '/admin/pesan/:detailpesanan',
            component: DetailPesanan,
            props: true,
        },
        {

            path:'/admin/sparepartkurang',
            name: 'AdminKurangSparepart',
            component: AdminKurangSparepart,
        },  
        ]
    },
    {
        path:'/karyawan',
        component: AppKaryawan,
        children:[
            {

                path:'/karyawan/kustomer',
                component: KaryawanKustomer,
            },
            {

                path:'/karyawan/kendaraan',
                component: KaryawanKendaraan,
            },
            {

                path:'/karyawan/transaksi',
                component: KaryawanTransaksi,
            },
            {

                path:'/karyawan/unpaid',
                component: KaryawanUnpaid,
            },
            {
                path: '/karyawan/transaksi/:transaksi',
                component: TransaksiDetail,
                props: true,
            }
          
        ]
    }
]

const router = new VueRouter({
    base: '/8786/',
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;

