<!--
  EMIT:
    @deleted - delete (response from server)
    @error - error from server
-->
<template>
  <el-dialog title="Удаление токена" :visible.sync="inDialog" width="40%">
    <!-- TODO: Styles -->
    <p>Вы действительно хотите удалить этот токен?</p>
    <b>{{ userToken.name }} [{{ userToken.mask }}]</b>
    <p>{{ userToken.description }}</p>
    <span slot="footer" class="dialog-footer">
        <el-button @click="inDialog = false">Отмена</el-button>
        <el-button type="danger" @click="fetchDelete()" :loading="loading" :disabled="loading">
          Удалить
        </el-button>
      </span>
  </el-dialog>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    dialog: {
      type: Boolean,
      required: true
    },
    userToken: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      inDialog: false,
      loading: false
    }
  },
  methods: {
    fetchDelete () {
      this.loading = true

      axios.delete('users/tokens/' + this.userToken.id)
        .then(res => {
          if (this.isSelected) {
            this.$store.dispatch('clearSelectedUserToken')
          }
          this.$emit('deleted', res.data)
          this.inDialog = false
          this.loading = false
        })
        .catch(err => {
          this.$emit('error', err.response.data)
          this.loading = false
        })
    }
  },
  watch: {
    dialog () {
      this.inDialog = true
    }
  }
}
</script>
