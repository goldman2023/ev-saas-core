<script type="text/javascript">
    function setSchemaKey(evt) {
        if (evt.target.checked) {
            $(".schema-group").removeClass("d-none");
            $("#schema_key").attr("required", "required");
        }else {
            $(".schema-group").addClass("d-none");
            $("#schema_key").removeAttr("required");
        }
    }
</script>