<script type="text/javascript">

    function cargarCodigoInterno(codigo_interno_contrato,codigo_visible_contrato){
        $.ajax({
            url: "<?= Url::base() ?>/rrhh/contrato-contrato/enviar-codigo-interno",
            method: 'POST',
            data: {
                codigo_interno_contrato : codigo_interno_contrato,
                codigo_visible_contrato : codigo_visible_contrato
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('tablas_anexas');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-entregable-pjax',
                });
                $.pjax.xhr = null;
                $.pjax.reload({
                    container:'#crud-datatable-penalidad-pjax',
                });
                $.pjax.xhr = null;
            },
            fail:function(text){
                alert('Hubo un error en la conexión, la data es invalida. Recargue la página porfavor.');
            }
        });
    }

</script>