<!--
  EMIT:
    @updated - updated info about this token
    @error - error from dialog
-->
<template>
  <div class="card-user-token">
    <div class="el-card">
      <div class="header">
        <div class="left">
          <!-- TODO Component User (Name + id) - with popover on hover -->
        </div>
        <div class="right">
          <div class="time-block">
            <el-tooltip class="item" effect="dark" content="Последний запрос в ВК" placement="bottom">
              <span>{{ lastUsed }}</span>
            </el-tooltip>
            <el-button type="text" title="Обновить" icon="el-icon-refresh" @click="fetchUpdateUserToken()"
                       :loading="loadings.update" :disabled="storeLoading || loadings.update"
            />
          </div>
        </div>
      </div>
      <div class="body">
        <img :src="userToken.user.photo" :title="fullName" :alt="fullName">
        <div class="content">
          <div>
            <h2>{{ userToken.name }}</h2>
            <p>{{ userToken.description }}</p>
          </div>
        </div>
      </div>
      <div class="permissions">
        <span class="tag" v-for="(permission, index) in permissions" :key="index">
          {{ permission }}
        </span>
      </div>
      <div class="buttons">
        <!-- TODO Click handler -->
        <el-button type="danger" size="mini" icon="el-icon-delete" />
        <div>
          <el-button type="primary" size="mini" @click="dialogs.edit = !dialogs.edit">
            Редактировать
          </el-button>
          <el-button v-if="!isSelected" type="info" size="mini" @click="setSelectedUserToken()">
            Выбрать
          </el-button>
        </div>
      </div>
    </div>

    <edit-dialog :dialog="dialogs.edit" :user-token="userToken" @edited="handleUpdated" @error="handleError" />
  </div>
</template>

<script>
import { parseFromMask } from '../../../helpers/permission'
import { fullName } from '../../../helpers/user'
import EditDialog from './dialogs/Edit'
import moment from 'moment'
import axios from 'axios'

export default {
  components: {
    EditDialog
  },
  props: {
    userToken: {
      type: Object,
      required: true
    },
    index: {
      type: Number,
      required: false
    }
  },
  data () {
    return {
      dialogs: {
        edit: false
      },
      loadings: {
        update: false,
      }
    }
  },
  computed: {
    selectedUserToken () {
      return this.$store.state.userTokens.selected
    },
    lastUsed () {
      return moment(this.userToken.last_used).fromNow()
    },
    storeLoading () {
      return this.$store.state.userTokens.isLoading
    },
    isSelected () {
      return this.selectedUserToken.id === this.userToken.id
    },
    permissions () {
      return parseFromMask(this.userToken.mask)
    },
    fullName () {
      return fullName(this.userToken.user)
    }
  },
  methods: {
    fetchUpdateUserToken () {
      this.loadings.update = true

      axios.get('users/tokens/' + this.userToken.id)
        .then(res => {
          if (this.isSelected) {
            this.$store.dispatch('setSelectedUserToken', res.data)
          }
          this.$emit('updated', res.data, this.index)
          this.loadings.update = false
        })
        .catch(err => {
          this.loadings.update = false
          this.$emit('error', err.response.data)
        })
    },
    setSelectedUserToken () {
      this.$store.dispatch('setSelectedUserToken', this.userToken)
    },
    handleUpdated (val) {
      this.$emit('updated', val, this.index)
    },
    handleError (val) {
      this.$emit('error', val)
    }
  }
}
</script>

<style lang="scss" scoped>
.card-user-token {
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

.content {
  display: flex;
  width: 100%;
  flex-direction: column;
  justify-content: space-between;
  margin-left: 10px;
  > div {
    text-decoration: none;
    color: #333;
    > h2 {
      margin: 0 0 5px;
      font-size: 20px;
    }
    > p {
      max-height: 71px;
      text-decoration: none;
      color: #8a8a8a;
      margin: 0;
      overflow: auto;
    }
  }
}

.buttons {
  display: flex;
  padding: 0 10px;
  justify-content: space-between;
  button {
    margin: 10px 0;
  }
}

.item {
  cursor: context-menu;
}

.permissions {
  border: 1px solid #e7e7e7;
  border-left: 0;
  border-right: 0;
  color: #696969;
  background: #f9f9f9;
  padding: 5px 10px;
  cursor: context-menu;
}

.tag {
  display: inline-block;
  margin: 2px;
}
</style>
