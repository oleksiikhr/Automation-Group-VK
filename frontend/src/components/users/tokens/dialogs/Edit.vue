<!--
  EMIT:
    @edited - edited the user token
    @error - error from server
-->
<template>
  <el-dialog title="Редактирование токена" :visible.sync="inDialog" width="40%">
    <div>
      <el-form :model="form" label-width="100px">
        <el-form-item label="Название">
          <el-input v-model="form.name" />
        </el-form-item>
        <el-form-item label="Описание">
          <el-input v-model="form.description" type="textarea" />
        </el-form-item>
      </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
        <el-button @click="inDialog = false">Отмена</el-button>
        <el-button type="primary" @click="fetchEdit()" :loading="loading" :disabled="loading">
          Добавить
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
      form: {},
      inDialog: false,
      loading: false
    }
  },
  methods: {
    fetchEdit () {
      this.loading = false

      axios.put('users/tokens/' + this.userToken.id, this.form)
        .then(res => {
          this.$emit('edited', this.form)
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
      this.form = JSON.parse(JSON.stringify(this.userToken))
      this.inDialog = true
    }
  }
}
</script>
