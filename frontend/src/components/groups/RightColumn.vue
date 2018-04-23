<!--
  EMIT:
    @added - added a new group
    @error - error from server
-->
<template>
  <div class="right-column groups">
    <a @click="dialogs.add = !dialogs.add" class="card">
      <i class="material-icons">add</i>
      <span>Добавить группу</span>
    </a>

    <add-dialog :dialog="dialogs.add" @added="handleAdded" @error="handleError" />
  </div>
</template>

<script>
import AddDialog from './dialogs/Add'

export default {
  components: {
    AddDialog
  },
  data () {
    return {
      dialogs: {
        add: false
      }
    }
  },
  computed: {
    userToken () {
      return this.$store.state.userTokens.selected
    }
  },
  methods: {
    handleAdded (val) {
      this.$emit('added', val)
    },
    handleError (val) {
      this.$emit('error', val)
    }
  }
}
</script>
