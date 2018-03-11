<template>
  <div class="card-group">
    <div class="el-card">
      <div class="header">
        <div class="left" title="Количество пользователей в ВК / БД">
          <i class="material-icons">people_outline</i>
          <span>{{ group.vk_users + ' / ' + group.users_count }}</span>
        </div>
        <div class="right">
          <div class="time">
            <span>{{ updatedAt }}</span>
            <a title="Обновить" @click="fetchUpdateGroup()">
              <i class="material-icons">refresh</i>
            </a>
          </div>
          <a :class="'deactivated ' + (group.deactivated ? 'on' : 'off')"
             :title="group.deactivated ? 'Активировать' : 'Деативировать'"
              @click="fetchChangeStatusGroup()"
          ></a>
        </div>
      </div>
      <div class="body">
        <!-- FIXME Default photo (local static) -->
        <router-link :to="'group/' + group.id">
          <img :src="group.photo_100 ? group.photo_100 : 'https://vk.com/images/camera_100.png'"
               :title="group.name" :alt="group.name">
        </router-link>
        <div class="content">
          <div>
            <router-link :to="'group/' + group.id" class="local-link">
              <h2>{{ group.name }}</h2>
            </router-link>
            <a :href="'https://vk.com/' + group.screen_name" class="vk-link"
               title="Открыть в ВК" target="_blank" rel="noopener noreferrer">
              <i class="material-icons">http</i>{{ group.screen_name }}
            </a>
          </div>
          <div class="bottom-right">
            <el-tag v-if="group.vk_blocked" type="danger">Заблокировано</el-tag>
            <template v-else>
              <el-tag :type="group.vk_closed ? 'danger' : 'success'" size="medium"
                      :title="(group.vk_closed ? 'Закрытая' : 'Открытая') + ' группа'">
                {{ group.vk_closed ? 'Закрыто' : 'Открыто' }}
              </el-tag>
              <el-button v-if="selectedGroup.id !== group.id" size="mini" @click="setSelectedGroup()">
                Выбрать
              </el-button>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  props: {
    group: {
      type: Object,
      required: true
    }
  },
  computed: {
    selectedGroup () {
      return this.$store.state.groups.selected
    },
    updatedAt () {
      return moment(this.group.updated_at).fromNow()
    }
  },
  methods: {
    fetchChangeStatusGroup () {
      // TODO this.$store.commit('')
    },
    fetchUpdateGroup () {
      // TODO this.$store.commit('')
    },
    setSelectedGroup () {
      this.$store.dispatch('setSelectedGroup', this.group)
    }
  }
}
</script>

<style lang="scss" scoped>
.card-group {
  margin-bottom: 20px;
  > .el-card {
    border: 1px solid #e6e6e6;
    padding: 10px;
    overflow: auto;
  }
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  border-bottom: 1px solid #e6e6e6;
  padding-bottom: 5px;
  margin-bottom: 10px;
  i {
    font-size: 19px;
  }
}

.left {
  display: flex;
  align-items: center;
  > span {
    text-indent: 5px;
  }
}

.right {
  display: flex;
  align-items: center;
  > .time {
    display: flex;
    align-items: center;
    > a {
      margin-left: 8px;
      cursor: pointer;
      font-size: 0;
      transition: .3s;
      color: #b3b3b3;
      &:hover {
        color: #333;
      }
    }
    > span {
      font-style: italic;
    }
  }
}

.deactivated {
  width: 13px;
  height: 13px;
  border-radius: 50%;
  margin-left: 8px;
  cursor: pointer;
  transition: .3s;
  &:hover {
    background: #545c64 !important;
  }
  &.off {
    background: #3ca01b;
  }
  &.on {
    background: #e43232;
  }
}

.body {
  display: flex;
  max-height: 100px;
  overflow: hidden;
  img {
    width: 100px;
    height: 100px;
    transition: .3s;
    &:hover {
      opacity: .8;
    }
  }
}

.content {
  display: flex;
  width: 100%;
  flex-direction: column;
  justify-content: space-between;
  margin-left: 10px;
  .local-link {
    text-decoration: none;
    color: #333;
    > h2 {
      margin: 0 0 3px;
      font-size: 22px;
    }
    &:hover {
      text-decoration: underline;
    }
  }
  .vk-link {
    display: flex;
    align-items: center;
    font-size: smaller;
    text-decoration: none;
    color: #545c64;
    &:hover {
      color: #222;
    }
    > i {
      margin-right: 3px;
    }
  }
  .bottom-right {
    text-align: right;
  }
}
</style>
