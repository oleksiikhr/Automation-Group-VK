<template>
  <div id="groups" class="view-content">
    <div class="section-header">
      <h1>Токены пользователей</h1>
      <el-button class="refresh" size="mini" icon="el-icon-refresh" :loading="loading"
                 :disabled="loading" @click="fetchUserTokens()" />
    </div>
    <el-row :gutter="10" justify="space-between">
      <el-col :md="18" class="main-content" v-loading="loading">
        <card-user-token v-for="(userToken, index) in list" :key="userToken.id" :user-token="userToken"
                         :index="index" @updated="handleUserTokenUpdated"/>
      </el-col>
      <el-col :md="6" class="hidden-sm-and-down">
        <right-column @created="fetchUserTokens" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import RightColumn from '../components/users/tokens/RightColumn'
import CardUserToken from '../components/users/tokens/Card'
import axios from 'axios'

export default {
  components: {
    RightColumn, CardUserToken
  },
  data () {
    return {
      list: [],
      loading: false
    }
  },
  mounted () {
    this.fetchUserTokens()
  },
  methods: {
    fetchUserTokens () {
      this.loading = true

      axios.get('users/tokens')
        .then(res => {
          this.list = res.data
          this.loading = false
        })
        .catch(() => {
          this.loading = false
        })
    },
    handleUserTokenUpdated (val, index) {
      this.list[index] = val
    }
  }
}
</script>

<style lang="scss" scoped>
.main-content {
  min-height: 200px;
}
</style>
