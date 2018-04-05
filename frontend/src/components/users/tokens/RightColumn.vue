<!--
  EMIT:
    @created - added new user token (response from the server)
-->
<template>
  <div class="right-column user-tokens">
    <a @click="dialog = true" class="card">
      <i class="material-icons">add</i>
      <span>Добавить токен</span>
    </a>

    <!-- DIALOGS -->

    <el-dialog title="Добавить токен пользователя" :visible.sync="dialog" width="40%">
      <div>
        <el-form :model="form" label-width="100px">
          <el-form-item label="Название">
            <el-input v-model="form.name" />
          </el-form-item>
          <el-form-item label="Токен">
            <el-input v-model="form.token" />
          </el-form-item>
          <el-form-item label="Описание">
            <el-input v-model="form.description" type="textarea" />
          </el-form-item>
        </el-form>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialog = false">Отмена</el-button>
        <el-button type="primary" @click="fetchAddToken()" :loading="loading" :disabled="loading">
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
      dialog: false,
      loading: false,
      form: {}
    }
  },
  methods: {
    fetchAddToken () {
      this.loading = true

      axios.post('users/tokens', this.form)
        .then(res => {
          this.$emit('created', res.data)
          this.dialog = false
          this.form = {}
          this.loading = false
        })
        .catch(() => {
          this.loading = false
        })
    }
  }
}
</script>
