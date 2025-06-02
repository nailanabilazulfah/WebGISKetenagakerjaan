
<!-- jQuery -->
<script src="<?=templates()?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=templates()?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=templates()?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=templates()?>/dist/js/demo.js"></script>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
 	$('table.table').DataTable();
  })
</script>