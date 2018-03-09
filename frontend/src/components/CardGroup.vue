<template>
  <div class="card-group el-card">
    <div class="header">
      <div class="left">
        <i class="material-icons">people_outline</i>
        <span>1000 / 526</span>
      </div>
      <div class="right">
        <div class="time">
          <span>25.05.18 12:15</span>
        </div>
        <div :class="'deactivated ' + (group.deactivated ? 'on' : 'off')"></div>
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
  font-size: 14px;
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
  > .time {
    display: flex;
    align-items: center;
  }
}

.deactivated {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  box-shadow: 0 0 0 5px #e6e6e6;
  margin: 0 5px 0 10px;
  &.off {
    background: #e43232;
  }
  &.on {
    background: #3ca01b;
  }
}
</style>
