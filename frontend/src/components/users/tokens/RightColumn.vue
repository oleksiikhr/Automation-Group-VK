<!--
  EMIT:
    @created - added new user token (response from the server)
-->
<template>
  <div class="right-column user-tokens">
    <a @click="create.dialog = true" class="card">
      <i class="material-icons">add</i>
      <span>Добавить токен</span>
    </a>

    <!-- DIALOGS -->

    <el-dialog title="Добавить токен пользователя" :visible.sync="create.dialog" width="40%">
      <span>
        <el-input placeholder="Токен" v-model="create.form.token" />
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="create.dialog = false">Отмена</el-button>
        <el-button type="primary" @click="fetchAddToken()" :loading="create.loading" :disabled="create.loading">
          Добавить
        </el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      create: {
        dialog: false,
        loading: false,
        form: {
          token: ''
        }
      }
    }
  },
  methods: {
    fetchAddToken () {
      this.create.loading = true

      axios.post('users/tokens', this.create.form)
        .then(res => {
          console.log(res.data)
          this.$emit('created', res.data)
          this.create.dialog = false
          this.create.loading = false
        })
        .catch(() => {
          this.create.loading = false
        })
    }
  }
}
</script>
