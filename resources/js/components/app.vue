<template>
    <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <Sidebar />
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <Navbar />
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from './layouts/sidebar.vue';
import Navbar from './layouts/navbar.vue';

export default{
    name: 'Category',
    components: {
        Sidebar,
        Navbar
    }
}
</script>