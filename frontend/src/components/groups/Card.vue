<template>
  <div class="card-group">
    <div class="el-card">
      <div class="header">
        <div class="left" title="Количество групп">
          <i class="material-icons">people_outline</i>
          <span>{{ group.members_count }}</span>
        </div>
        <div class="right">
          <div class="time-block">
            <span>{{ updatedAt }}</span>
            <el-button type="text" title="Обновить" icon="el-icon-refresh" @click="fetchUpdateGroup()"
                       :loading="loadings.update" :disabled="groupsLoading || loadings.update"
            />
          </div>
          <el-button type="text" :class="'refresh deactivated ' + (group.is_sleep ? 'on' : 'off')"
                     :title="group.is_sleep ? 'Активировать' : 'Деативировать'" :loading="statusLoading"
                     @click="fetchChangeStatusGroup()" :disabled="groupsLoading || statusLoading"
          />
        </div>
      </div>
      <div class="body">
        <!-- FIXME Default photo (local static) -->
        <router-link :to="'group/' + group.id">
          <img :src="group.photo ? group.photo : 'https://vk.com/images/camera_100.png'"
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
            <el-tag v-if="group.deactivated" type="danger">{{ group.deactivated }}</el-tag>
            <template v-else>
              <el-tag :type="group.is_closed ? 'danger' : 'success'" size="medium"
                      :title="(group.is_closed ? 'Закрытая' : 'Открытая') + ' группа'">
                {{ group.is_closed ? 'Закрыто' : 'Открыто' }}
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
  data () {
    return {
      loadings: {
        update: false
      },
      statusLoading: false
    }
  },
  computed: {
    selectedGroup () {
      return this.$store.state.groups.selected
    },
    updatedAt () {
      return moment(this.group.updated_at).fromNow()
    },
    groupsLoading () {
      return this.$store.state.groups.isLoading
    }
  },
  methods: {
    fetchChangeStatusGroup () {
      this.statusLoading = true
      console.log('Change status')
      // TODO this.$store.commit('') is_sleep
    },
    fetchUpdateGroup () {
      this.updateLoading = true
      console.log('Update')
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
    margin-bottom: 20px;
    overflow: auto;
  }
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  border-bottom: 1px solid #e6e6e6;
  padding: 6px 10px;
  background: #f9f9f9;
  i {
    font-size: 19px;
  }
}

.body {
  display: flex;
  overflow: hidden;
  padding: 10px;
  img {
    transition: .3s;
    max-height: 100px;
    max-width: 100px;
    &:hover {
      opacity: .8;
    }
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
  > .time-block {
    display: flex;
    align-items: center;
    > .el-button {
      opacity: .6;
      &:hover {
        opacity: 1;
        color: #333;
      }
    }
    > span {
      font-style: italic;
    }
  }
  .el-button {
    font-size: 16px;
    color: #6c7782;
    padding: 0;
    margin-left: 5px;
    transition: .3s;
    &.is-loading {
      opacity: 1;
      color: #6c7782 !important;
    }
  }
}

.deactivated {
  width: 13px;
  height: 13px;
  border-radius: 50%;
  &:hover {
    background: #545c64 !important;
  }
  &.off {
    background: #3ca01b;
  }
  &.on {
    background: #e43232;
  }
  &.is-loading {
    width: auto;
    height: auto;
    background: none !important;
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
      margin: 0 0 5px;
      font-size: 20px;
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
    color: #8a8a8a;
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
