<template>
  <div class="col-12 mt-3">
    <div :class="active ? 'card active' : 'card'" @click="$emit('toggle', index)">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-5">
            <div class="darkened">
              <img :src="news.img" alt="" class="img-fluid">
            </div>
          </div>
          <div class="col-7 py-4">
            <h5>{{ news.title }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "mini-news",
    props: {
      news: {
        type: Object,
        required: true
      },
      active: {
        type: Boolean,
        default: false,
        required: false
      },
      index: {
        type: Number,
        required: true
      }
    }
  }
</script>

<style scoped lang="scss">
  .darkened {
    position: relative;
    height: 100%;
    border-radius: 10px 0 0 10px;
  }

  .darkened::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 1;
    height: 100%;
    border-radius: 10px 0 0 10px;
  }
  .card {
    border: 0;
    box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);
    border-radius: 10px;
    background: #ffffff;
    color: black;
    cursor: pointer;
    transition: 0.3s;
    &.active {
      background: #000000;
      color: white;
    }
    img {
      min-height: 100%;
      min-width: 100%;
      position: relative;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: block;
      margin: auto;
      height: auto;
      max-height: 100%;
      width: auto;
      max-width: 100%;
      object-fit: cover;
      border-radius: 10px 0 0 10px;
    }
  }
</style>
