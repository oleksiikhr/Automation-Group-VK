<template>
  <div id="groups" class="view-content">
    <div class="section-header">
      <h1>Токены пользователей</h1>
      <el-button class="refresh" size="mini" icon="el-icon-refresh" :loading="storeLoading"
                 :disabled="storeLoading" @click="fetchUserTokens()" />
    </div>
    <el-row :gutter="10" justify="space-between">
      <el-col :md="18">
        {{ userTokens }}
      </el-col>
      <el-col :md="6" class="hidden-sm-and-down">
        <right-column @created="fetchUserTokens" />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import RightColumn from '../components/users/tokens/RightColumn'

export default {
  components: {
    RightColumn
  },
  mounted () {
    this.fetchUserTokens()
  },
  computed: {
    userTokens () {
      return this.$store.state.userTokens.list
    },
    storeLoading () {
      return this.$store.state.userTokens.loading
    }
  },
  methods: {
    fetchUserTokens () {
      this.$store.dispatch('fetchUserTokens')
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
