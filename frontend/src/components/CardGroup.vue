<template>
  <div class="card-group el-card">
    <div class="header">
      <div class="left">
        <i class="material-icons">people_outline</i>
        <span>1000 / 526</span>
      </div>
      <div class="right">
        Time
      </div>
    </div>
    <div class="body">

    </div>
    <div class="footer">

    </div>
  </div>
</template>

<script>
export default {
  props: {
    group: {
      type: Object,
      required: true
    }
  }
}
</script>

<style lang="scss" scoped>
.card-group {
  border: 1px solid #e6e6e6;
  margin-bottom: 15px;
  padding: 10px;
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.left {
  font-size: 14px;
  display: flex;
  align-items: center;
  > i {
    font-size: 19px;
  }
  > span {
    text-indent: 5px;
  }
}
</style>
