<template>
  <div id="app">
    <el-container>
      <el-header class="blue">
        <router-link to="groups" class="h-card-group">
          <!-- TODO Data from vuex -->
          <img src="https://pp.userapi.com/c637217/v637217600/45610/Zpgr3st-NUw.jpg" alt="__NAME__" title="__NAME__">
          <div class="h-name">English</div>
        </router-link>
      </el-header>
      <el-container>
        <el-aside width>
          <el-menu default-active="/"  router>
            <el-menu-item v-for="item in menu" :key="item.route" :index="item.route" :title="item.title">
              <i class="material-icons">{{ item.icon }}</i>
            </el-menu-item>
          </el-menu>
        </el-aside>
        <el-main>
          <keep-alive>
            <router-view />
          </keep-alive>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script>
// import axios from 'axios'

export default {
  data () {
    return {
      menu: [
        { route: '/', icon: 'dashboard', title: 'Главная страница' },
        { route: 'articles', icon: 'description', title: 'Статьи' },
        { route: 'images', icon: 'photo_library', title: 'Изображения' },
        { route: 'videos', icon: 'video_library', title: 'Видео' },
        { route: 'tags', icon: 'label', title: 'Теги' },
        { route: 'logs', icon: 'history', title: 'Логи' }
      ]
    }
  },
  mounted () {
    this.$router.push('/')
    // axios.get('groups')
    //   .then(res => {
    //     console.log(res)
    //   })
    //   .catch(err => {
    //     console.log(err)
    //   })
  }
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
  display: flex;
  align-items: center;
  padding: 0 20px;
  background: #545c64;
}

.h-card-group {
  display: flex;
  flex-direction: row;
  max-width: 250px;
  min-width: 150px;
  background: #fff;
  height: 35px;
  align-items: center;
  cursor: pointer;
  padding: 0 10px;
  box-shadow: 0 0 8px 2px #989898;
  text-decoration: none;
}

.h-card-group > img {
  border-radius: 50%;
  max-height: 27px;
}

.h-name {
  align-items: center;
  text-indent: 5px;
  color: #525252;
  font-family: monospace;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.el-aside .el-menu-item {
  text-align: center;
}

.el-aside .el-menu-item .material-icons {
  font-size: 20px;
}
</style>
