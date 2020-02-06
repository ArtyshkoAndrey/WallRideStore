<script>
  export default {
    name: "mini-cart-item",
    props: {
      id: {
        type: Number,
        required: true
      }
    },
    methods: {
      deleteItem () {
        swal({
          title: "\n" + "Вы уверены, что хотите удалить этот товар?",
          icon: "warning",
          buttons: ['Отменить', 'Удалить'],
          dangerMode: true,
        })
        .then((willDelete) => {
          // Пользователь нажимает кнопку ОК, значение willDelete будет истинным, иначе ложным
          if (!willDelete) {
            return;
          }
          axios.delete('/cart/' + this.id)
          .then(() => {
            location.reload();
          })
        });
      }
    }
  }
</script>

<style scoped>

</style>
