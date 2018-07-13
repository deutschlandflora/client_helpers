jQuery(document).ready(function docReady($) {
  var sexStageInputSelectors = '.system-function-sex, .system-function-stage, .system-function-sex_stage';
  var taxonRestrictionInputSelectors = '#occurrence\\:taxa_taxon_list_id, ' + sexStageInputSelectors;
  var hasDynamicAttrs = $('.species-dynamic-attributes').length > 0;

  function changeTaxonRestrictionInputs() {
    var urlSep = indiciaData.ajaxUrl.indexOf('?') === -1 ? '?' : '&';
    var sexStageAttrs = $(sexStageInputSelectors);
    var sexStageVals = [];
    if ($('#occurrence\\:taxa_taxon_list_id').val() !== '') {
      $.each(sexStageAttrs, function grabSexStageAttrVal() {
        if ($(this).val() !== '') {
          sexStageVals.push($(this).val());
        }
      });
      $.each($('.species-dynamic-attributes'), function loadAttrDiv() {
        var type = $(this).hasClass('attr-type-sample') ? 'sample' : 'occurrence';
        var div = this;
        // 0 is a fake nid, since we don't care.
        $.get(indiciaData.ajaxUrl + '/dynamicattrs/0' + urlSep +
            'survey_id=' + $('#survey_id').val() +
            '&taxa_taxon_list_id=' + $('#occurrence\\:taxa_taxon_list_id').val() +
            '&type=' + type +
            '&stage_termlists_term_ids=' + JSON.stringify(sexStageVals) +
            '&options=' + JSON.stringify(indiciaData['dynamicAttrOptions' + type]), null,
          function getAttrsReportCallback(data) {
            $(div).html(data);
          }
        );
      });

    }
  }

  if (hasDynamicAttrs) {
    // On selection of a taxon or change of sex/stage attribute, load any dynamically linked attrs into the form.
    $(taxonRestrictionInputSelectors).change(changeTaxonRestrictionInputs);
  }
});
