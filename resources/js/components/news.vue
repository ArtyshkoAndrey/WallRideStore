<template>
  <div class="row">
    <div class="col-lg-4 col-md-6 pl-sm-0" id="mini-news">
      <div class="row">
        <miniNews v-for="(oneNews, index) in news" :news="oneNews" :key="oneNews.slug" :active="activated[index]" :index="index" v-on:toggle="getNews(index)"/>
      </div>
    </div>
    <div class="col-lg-8 col-md-6" id="big-news">
      <div class="card mt-3">
        <div class="card-body p-0">
         <div class="darkened">
           <transition name="fade" appear>
            <img :src="item.img" class="img-fluid" alt="">
           </transition>
         </div>
         <div class="position-absolute info-big-news">
           <transition-group name="fade" appear>
             <h2 key="1">{{ item.title }}</h2>
             <a href="#" key="2" class="c-red">Подробнее <img src="/../../img/arrow-long-right-red.png" width="100" alt=""></a>
           </transition-group>
         </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import miniNews from "./mini-news";
  export default {
    name: "news",
    components: {miniNews},
    props: {
      news: {
        type: Array,
        required: false,
        default: function () {
          return [
            {
              img: '../../../public/storage/images/news1.jpg',
              title: 'Новая коллекция Polar Skate Co',
              slug: 'new-collection'
            },
            {
              img: '../../../public/storage/images/news2.jpg',
              title: 'Новогодние скидки в Wallride Store',
              slug: 'cristmas-sale'
            },
            {
              img: '../../../public/storage/images/news1.jpg',
              title: 'Новая коллекция Polar Skate Co',
              slug: 'new-collection2'
            },
          ];
        }
      }
    },
    data () {
      return {
        item: {},
        activated: []
      }
    },
    mounted () {
      this.adaptiveHeight();
      window.addEventListener("resize", this.adaptiveHeight);

      this.item = this.news[0];
      this.activated = new Array(this.news.length);
      this.activated.fill(false);
      this.activated[0] = true;
    },
    methods: {
      getNews (index) {
        this.item = this.news[index];
        this.activated.fill(false);
        this.activated[index] = true;
      },
      adaptiveHeight () {
        let h = $('#mini-news').height();
        $('#big-news').height(h - this.rem(1));
      },
      rem (count) {
        let unit = $('html').css('font-size');

        if (typeof count !== 'undefined' && count > 0)
        {
          return (parseInt(unit) * count);
        }
        else
        {
          return parseInt(unit);
        }
      }
    }
  }
</script>

<style scoped lang="scss">
  .fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
  }
  .info-big-news {
    color: white;
    bottom: 0;
    padding: 10px;
    z-index: 2;
    a {
      font-size: 16px;
    }
  }
  .darkened {
    position: relative;
    height: 100%;
    border-radius: 10px;
    img {
      min-height: 100%;
      min-width: 100%;
      position: relative;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      display: block;
      margin: auto;
      height: auto;
      max-height: 100%;
      width: auto;
      max-width: 100%;
      object-fit: cover;
      object-position: 85% 20%;
      border-radius: 10px;
    }
  }

  .darkened::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgb(0,0,0);
    background: linear-gradient(0deg, rgba(0,0,0,0.804359243697479) 0%, rgba(0,0,0,0.7371323529411764) 50%, rgba(0,0,0,0.3617822128851541) 100%);
    z-index: 1;
    height: 100%;
    border-radius: 10px;
  }
  .card {
    height: 100%;
    border-radius: 10px;
    border: 0;
    .card-body {
      height: 100%;
    }

  }
</style>
