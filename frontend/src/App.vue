<template>
  <div id="app">
    <el-container>
      <el-header>

      </el-header>
      <el-container>
        <el-aside width>
          <el-menu default-active="/" collapse router>
            <el-menu-item v-for="item in menu" :key="item.route" :index="item.route">
              <i class="material-icons">{{ item.icon }}</i>
              <span slot="title">{{ item.title }}</span>
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
import axios from 'axios'

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
    axios.get('groups')
      .then(res => {
        console.log(res.data)
      })
      .catch(err => {
        console.log(err.response.data)
      })
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
  padding: 0;
}

.el-menu-item {
  text-align: center;
}

.el-menu-item .material-icons {
  font-size: 20px;
}
</style>
