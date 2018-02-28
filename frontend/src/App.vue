<template>
  <div id="app">
    <el-container>
      <el-header>

      </el-header>
      <el-container>
        <el-aside width>
          <el-menu default-active="1" collapse>
            <el-menu-item index="1">
              <i class="el-icon-menu"></i>
              <span slot="title">Меню</span>
            </el-menu-item>
            <el-menu-item index="2">
              <i class="el-icon-time"></i>
              <span slot="title">Запуск</span>
            </el-menu-item>
            <el-menu-item index="3" disabled>
              <i class="el-icon-document"></i>
              <span slot="title">Navigator Three</span>
            </el-menu-item>
            <el-menu-item index="4">
              <i class="el-icon-setting"></i>
              <span slot="title">Navigator Four</span>
            </el-menu-item>
          </el-menu>
        </el-aside>
        <el-main>
          <router-view />
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
body {
  margin: 0;
}

#app {
  max-width: 1000px;
  margin: 20px auto;
  border: 1px solid #e7e7e7;
  box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);
}

.el-header {
  padding: 0;
}
</style>
