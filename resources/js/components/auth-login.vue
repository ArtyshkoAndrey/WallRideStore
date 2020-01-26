<script>
  export default {
    name: "auth-login",
    data: () =>({
      showPass: false
    }),
    mounted () {
      console.log(this.showPass)
    }
  }
</script>

<style lang="scss" scoped>
  h3 {
    font-weight: 800!important;
  }
  span.field-icon {
    position: absolute;
    display: inline-block;
    cursor: pointer;
    right: 0.5rem;
    top: 1rem;
    color: #000;
    z-index: 2;
  }
  .md-form.md-outline input {
    border-radius: 0!important;
    &:focus:not([readonly]) {
      border-color: #000!important;
      box-shadow: inset 0 0 0 1px #000000!important;
      color: #000!important;

      + label {
        color: #000!important;
      }
    }
  }

  .md-form.md-outline.form-lg label{
    font-size: 14px!important;
  }

  body, html {
    overflow: auto;
    margin: 0;
    padding: 0;
  }

  #auth {
    height: 100vh;
    background: linear-gradient(0deg, rgba(0,0,0,0.804359243697479) 0%, rgba(0,0,0,0.7371323529411764) 50%, rgba(0,0,0,0.3617822128851541) 100%), url('https://s3-alpha-sig.figma.com/img/ee0c/009c/c5c04cbdefc09eb942679d1a8bd1e051?Expires=1580688000&Signature=eALpfOah87u8TYoC-f1evHuwUnIzleLtVl-F6KF2y6wP~~5W3MjRIxS~NnGFjsdKjjlZyIPq6WUD~eiDvoOn939hzzp3Jl6Q3ny91T72v3P2PexrVLQjeEPhcnATRw0d5E4s5iZJ89MdwL6hqSbOnqd2uUUcTVOM55Wxpscq9qUJ6qDFi8DbF5XA6gKmAlPsFKDA1vMoDotUuWbPOO-ss9jmy4IqFdmQy~MbFI4KSfCS9a0RlRgys1HnN0pnP5VFAMX~YGua-cU-BfJvIMSov68y32dBJCivR3EnHlU-znhsAbXUwgTDWoiQeN36DtDzS21bv~4XgyDjHp05e3WO9Q__&Key-Pair-Id=APKAINTVSUGEWH5XD5UA');
    background-size: cover;
    @import "~mdbootstrap/scss/core/bootstrap/functions";
    @import "~mdbootstrap/scss/core/bootstrap/variables";
    // CORE
    @import "~mdbootstrap/scss/core/mixins";
    // Your custom variables
    @import "~mdbootstrap/scss/custom-variables";
    @import "~mdbootstrap/scss/core/colors";
    @import "~mdbootstrap/scss/core/variables";
    @import "~mdbootstrap/scss/core/global";
    @import "~mdbootstrap/scss/core/helpers";
    @import "~mdbootstrap/scss/core/typography";
    @import "~mdbootstrap/scss/core/waves";
    @import '~mdbootstrap/scss/free/animations-basic';
    @import '~mdbootstrap/scss/free/buttons';
    @import '~mdbootstrap/scss/free/forms';
  }

  .auth-card {
    border-radius: 5px!important;
    border: 0;
    box-shadow: none;
  }

  a {
    color: black;
    &:hover {
      color: red;
    }
  }

  @media screen and (max-height: 540px) {
    #auth {
      height: 100%;
    }
  }
</style>
