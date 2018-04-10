<template>
  <div class="h-header">
    <div class="h-panel">
      <router-link to="/user/tokens" class="h-card-group users">
        <template v-if="userToken.id">
          <img :src="userToken.user.photo" :alt="fullName" :title="fullName">
          <div class="h-name">{{ userToken.name }}</div>
          <a class="h-clear" @click.prevent="clearSelectedUserToken()" title="Убрать"></a>
        </template>
        <template v-else>
          <div class="no-image"></div>
          <div class="h-name">Выберите токен</div>
        </template>
      </router-link>
      <router-link to="/groups" class="h-card-group groups">
        <template v-if="group.id">
          <img :src="group.photo_100" :alt="group.name" :title="group.name">
          <div class="h-name">{{ group.name }}</div>
          <a class="h-clear" @click.prevent="clearSelectedGroup()" title="Убрать"></a>
        </template>
        <template v-else>
          <div class="no-image"></div>
          <div class="h-name">Выберите группу</div>
        </template>
      </router-link>
    </div>
    <div class="h-buttons">
      <el-button @click="routeCron()" size="mini" icon="el-icon-setting" />
    </div>
  </div>
</template>

<script>
import { fullName } from '../helpers/user'

export default {
  computed: {
    group () {
      return this.$store.state.groups.selected
    },
    userToken () {
      return this.$store.state.userTokens.selected
    },
    fullName () {
      return fullName(this.userToken.user)
    }
  },
  methods: {
    clearSelectedUserToken () {
      this.$store.dispatch('clearSelectedUserToken')
    },
    clearSelectedGroup () {
      this.$store.dispatch('clearSelectedGroup')
    },
    routeCron () {
      this.$router.push({ name: 'cron' })
    }
  }
}
</script>

<style lang="scss" scoped>
.h-header {
  display: flex;
  justify-content: space-between;
  width: 100%;
}

.h-panel {
  display: flex;
  align-items: center;
}

.h-card-group {
  display: flex;
  flex-direction: row;
  max-width: 170px;
  min-width: 120px;
  background: #fff;
  height: 35px;
  align-items: center;
  cursor: pointer;
  padding: 0 10px 0 5px;
  box-shadow: 0 0 8px 1px #989898;
  position: relative;
  text-decoration: none;
  transition: .2s;
  &:hover {
    background: rgba(0, 0, 0, 0.2);
    color: #fff !important;
    box-shadow: 0 0 2px 0;
    > .h-name {
      color: #fff;
    }
    > .h-clear {
      display: block;
    }
  }
  > img {
    border-radius: 50%;
    max-height: 27px;
  }
  > .no-image {
    height: 27px;
    width: 27px;
    border: 1px solid #d2d2d2;
    border-radius: 50%;
  }
  &.users {
    margin-right: 15px;
  }
}

.h-name {
  position: relative;
  align-items: center;
  text-indent: 14px;
  color: #525252;
  font-family: monospace;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  &::before {
    content: "";
    position: absolute;
    background: #7d7d7d;
    top: 0;
    bottom: 0;
    left: 7px;
    width: 1px;
  }
}

.h-clear {
  display: none;
  position: absolute;
  right: 5px;
  top: 9px;
  width: 18px;
  height: 18px;
  opacity: 0.3;
  &:hover {
    opacity: 1;
  }
  &::before, &::after {
    position: absolute;
    left: 8px;
    content: ' ';
    height: 18px;
    width: 2px;
    background-color: #fff;
  }
  &:before {
    transform: rotate(45deg);
  }
  &:after {
    transform: rotate(-45deg);
  }
}

.h-buttons {
  display: flex;
}
</style>
