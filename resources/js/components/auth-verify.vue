<script>
  export default {
    name: "auth-verify",
    data: () =>({
    }),
    mounted () {
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
    height: calc(100vh - 47px);
    background-size: cover;
    background-position: center;
    @import '../../sass/material';
  }

  .auth-card {
    border-radius: 5px!important;
    border: 0;
    box-shadow: none;
  }

  a {
    color: black !important;
    &:hover {
      text-decoration: underline !important;
      color: red !important;
    }
  }

  @media screen and (max-height: 540px) {
    #auth {
      height: 100%;
    }
  }
</style>
