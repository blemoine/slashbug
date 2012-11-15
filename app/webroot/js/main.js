function instrumentAjaxDatatable(selector, source, colDef) {
    if (colDef == undefined) {
        colDef = [];
    }
    return $(selector).dataTable({
        "bProcessing":true,
        "bJQueryUI":true,
        "bServerSide":true,
        "sAjaxSource":source,
        "aoColumnDefs":colDef
    });
}
