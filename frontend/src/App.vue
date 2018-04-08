<template>
  <div id="app">
    <el-container>
      <el-header class="blue">
        <component-header />
      </el-header>
      <el-container>
        <el-aside width>
          <el-menu :default-active="activeMenuItem" router>
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
import ComponentHeader from './components/Header'

export default {
  components: {
    ComponentHeader
  },
  data () {
    return {
      menu: [
        { route: '/', icon: 'dashboard', title: 'Главная страница' },
        { route: '/articles', icon: 'description', title: 'Статьи' },
        { route: '/images', icon: 'photo_library', title: 'Изображения' },
        { route: '/videos', icon: 'video_library', title: 'Видео' },
        { route: '/tags', icon: 'label', title: 'Теги' },
        { route: '/logs', icon: 'history', title: 'Логи' }
      ]
    }
  },
  computed: {
    activeMenuItem () {
      return this.$store.state.template.activeMenuItem
    }
  }
}
</script>

<style lang="scss">
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

.el-aside {
  width: 61px;
  min-width: 61px;
  .el-menu-item {
    text-align: center;
    > .material-icons {
      font-size: 20px;
    }
  }
}

.section-header {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #e6e6e6;
  margin: 0 0 10px 0;
  padding-bottom: 5px;
  > h1 {
    margin: 0;
  }
}

.right-column {
  > .card {
    display: flex;
    flex-direction: column;
    border: 1px solid #e6e6e6;
    padding: 20px 10px;
    text-align: center;
    text-decoration: none;
    color: #333;
    cursor: pointer;
    transition: .3s;
    > i {
      margin-bottom: 10px;
    }
    > span {
      color: #848484;
    }
    &:hover {
      background: #545c64;
      color: #fff;
      > span {
        color: #afafaf;
      }
    }
  }
}

.el-tooltip {
  outline: 0;
}
</style>
