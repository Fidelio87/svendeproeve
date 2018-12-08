<?php

?>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/matchHeight/dist/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--DATEPICKER-->
<script src="../bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.da.js"></script>
<!-- Googles prettyprint -->
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify/loader/run_prettify.js"></script>
<script>

    $('#date-picker.input-daterange').datepicker({
        language: "da",
        toggleActive: true,
        format: 'yyyy-mm-dd'
    });
</script>

<!--script der checker hvor mange karakter brugeren har tilbage-->
<!--med kommentar-->
<script type="text/javascript">
//    TODO bestem max karakterer i anmeldelser
    $('#kommentar').keyup(function () {
        var max = 1500 - $(this).val().length;
        if (max < 0) {
            $('#kommentar').css({'color':'red'});
            max = 0;
        } else {
            $('#kommentar').css({'color':'inherit'});
        }
        $('#helpBlock').text('Tegn tilbage: ' + max);

    });
</script>

<script type="text/javascript">

    $('#album-box .album-thmb').matchHeight({
        byRow: 0
    });

</script>

