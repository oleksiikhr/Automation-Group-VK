<!--
  EMIT:
    @updated - updated info about this token
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
                       :loading="updateLoading" :disabled="storeLoading || updateLoading"
            />
          </div>
        </div>
      </div>
      <div class="body">
        <!-- FIXME Full name -->
        <img :src="userToken.user.photo" :title="userToken.user.first_name" :alt="userToken.user.first_name">
        <div class="content">
          <div>
            <h2>{{ userToken.name }}</h2>
            <p>{{ userToken.description }}</p>
          </div>
          <div class="bottom-right">
            <!-- TODO Edit, delete buttons -->
            <el-button v-if="!isSelected" size="mini" @click="setSelectedUserToken()">
              Выбрать
            </el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import axios from 'axios'

export default {
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
      updateLoading: false
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
    }
  },
  methods: {
    fetchUpdateUserToken () {
      this.updateLoading = true

      axios.get('users/tokens/' + this.userToken.id)
        .then(res => {
          if (this.isSelected) {
            this.$store.dispatch('setSelectedUserToken', res.data)
          }
          this.$emit('updated', res.data, this.index)
          this.updateLoading = false
        })
        .catch(() => {
          this.updateLoading = false
        })
    },
    setSelectedUserToken () {
      this.$store.dispatch('setSelectedUserToken', this.userToken)
    }
  }
}
</script>

<style lang="scss" scoped>
.card-user-token {
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

.body {
  display: flex;
  max-height: 100px;
  overflow: hidden;
  img {
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
  > div {
    text-decoration: none;
    color: #333;
    > h2 {
      margin: 0 0 5px;
      font-size: 20px;
    }
    > p {
      font-size: smaller;
      text-decoration: none;
      margin: 0;
      color: #8a8a8a;
    }
  }
  .bottom-right {
    text-align: right;
  }
}

.item {
  cursor: context-menu;
}
</style>
