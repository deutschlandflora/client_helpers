
// Functions
var uspPrepChart, _get_week_number;
// Global Data
var reportOptions;

(function ($) {
	
	// Initially the chart is blank.
	uspPrepChart = function(options) {
		
		reportOptions = options;

		$('#'+reportOptions.species1SelectID+',#'+reportOptions.species2SelectID+',#'+reportOptions.weekNumSelectID).attr('disabled',true);

		$('#loadButton').click(function(){
			var locationType = $('#'+ reportOptions.locationTypeSelectID).val();
			var location = $('#'+ reportOptions.locationSelectIDPrefix+'-'+locationType).val();
			var weekOne_date;

			if(locationType == '' || location == '' || $(this).hasClass('waiting-button'))
				return;

			$(this).addClass('waiting-button');
			$('#'+reportOptions.species1SelectID+',#'+reportOptions.species2SelectID+',#'+reportOptions.weekNumSelectID).attr('disabled',true);

			reportOptions.loadedYear = $('#'+ reportOptions.yearSelectID).val();
			reportOptions.loadedLocationType = locationType;
			reportOptions.loadedLocation = $('#'+ reportOptions.locationSelectIDPrefix+'-'+locationType+' option:selected').text();
			$('#currentlyLoaded').empty().append('LOADING : ' + reportOptions.loadedYear + ' : ' + reportOptions.loadedLocation);

			if(reportOptions.weekstart[0]=='date'){
				var weekstart_date = new Date(reportOptions.loadedYear + "/" + reportOptions.weekstart[1]); // assuming correct format
				reportOptions.weekStartDay=weekstart_date.getDay() + 1;
			} // weekstart should be in range 1=Monday to 7=Sunday
			  else reportOptions.weekStartDay = reportOptions.weekstart[1];

    		if(reportOptions.weekOneContains != "")
    			weekOne_date = new Date(reportOptions.loadedYear + '/' + reportOptions.weekOneContains);
    		else
    			weekOne_date = new Date(reportOptions.loadedYear + '/Jan/01');
    	    weekOne_date_weekday = weekOne_date.getDay() + 1; // in range 1=Monday to 7=Sunday
			reportOptions.zeroWeekStartDate = new Date(weekOne_date.getTime());
			
			reportOptions.allWeeksMax = parseInt(reportOptions.allWeeksMax);

    	    // scan back to start of week one, then back 7 days to start of week zero
    	    // these work across month & year boundaries
    	    if(weekOne_date_weekday > reportOptions.weekStartDay) 
    	    	reportOptions.zeroWeekStartDate.setDate(weekOne_date.getDate() - (weekOne_date_weekday-reportOptions.weekStartDay) - 7);
    		else if(weekOne_date_weekday < reportOptions.weekStartDay)
    			reportOptions.zeroWeekStartDate.setDate(weekOne_date.getDate() - (7+weekOne_date_weekday-reportOptions.weekStartDay) - 7);

			// get the child locations - the sections. We then populate the X labels.
		    $.getJSON(indiciaData.read.url + "index.php/services/data/location?parent_id="+location +
		    	        '&mode=json&view=detail&auth_token=' + indiciaData.read.auth_token +
		    	        '&nonce=' + indiciaData.read.nonce + "&callback=?",
		        function(sdata) {
		    		var chartLabels = [];
		    		reportOptions.sectionIDMapping = [];
		    		reportOptions.sectionCodeMapping = [];
		    		$.each(sdata, function(idx, section) {
		    			reportOptions.sectionIDMapping[section.id] = section;
		    			reportOptions.sectionCodeMapping[section.code] = section;
		    			chartLabels.push(section.code);
		    	    });
		    		chartLabels.sort(function (a, b) {
		    			if(a.charAt(0) == 'S' && b.charAt(0) == 'S') {
		    				return a.substr(1) - b.substr(1);
		    			}
		    			return 0;
		    		});
		    		$.each(chartLabels, function(idx,lbl){
		    			reportOptions.sectionIDMapping[reportOptions.sectionCodeMapping[lbl].id].idx = idx;
		    		});
		    		reportOptions.opts.axes.xaxis.ticks = chartLabels;
					jQuery.getJSON(reportOptions.base_url+'/index.php/services/report/requestReport?report='+reportOptions.dataSource+'.xml' +
							'&reportSource=local&mode=json' +
							'&auth_token='+indiciaData.read.auth_token+'&reset_timeout=true&nonce='+indiciaData.read.nonce + 
							reportOptions.reportExtraParams +
							'&callback=?' +
							'&year='+reportOptions.loadedYear+'&date_from='+reportOptions.loadedYear+'-01-01&date_to='+reportOptions.loadedYear+'-12-31' +
							'&location_type_id='+reportOptions.loadedLocationType+'&location_id='+location+
							'&locattrs=',
						function(rdata){
							reportOptions.values = []; // taxon->weeknumber->section
							reportOptions.species = [];
							reportOptions.parentSampleList = [];
							for(var i=reportOptions.allWeeksMin; i<=reportOptions.allWeeksMax+2; i++) {
								reportOptions.parentSampleList[i] = [];
							}
							$.each(rdata, function(idx, occurrence){
								weekNum = _get_week_number(occurrence);
								if(weekNum < reportOptions.allWeeksMin || weekNum > reportOptions.allWeeksMax)
									return;
								if(typeof reportOptions.values[occurrence.taxon_meaning_id] == 'undefined') {
									reportOptions.species.push({'taxon': occurrence.taxon, 'preferred_taxon': occurrence.preferred_taxon, 'taxon_meaning_id':occurrence.taxon_meaning_id});
									reportOptions.values[occurrence.taxon_meaning_id] = [];
									// NB all weeks max + 1 = All weeks, all weeks max + 2 = in season weeks
									for(var i=reportOptions.allWeeksMin; i<=reportOptions.allWeeksMax+2; i++) {
										reportOptions.values[occurrence.taxon_meaning_id][i] = [];
										for(var j=0; j<reportOptions.opts.axes.xaxis.ticks.length; j++) {
											reportOptions.values[occurrence.taxon_meaning_id][i][j] = 0;
										}
									}
								}
								sectionNum = reportOptions.sectionIDMapping[occurrence.section_id].idx;
								if(parseInt(occurrence[reportOptions.countOccAttr]) != occurrence[reportOptions.countOccAttr]) occurrence[reportOptions.countOccAttr] = 0;
							  	switch(reportOptions.dataCombining){
							  		case 'max':
							  			reportOptions.values[occurrence.taxon_meaning_id][weekNum][sectionNum] = Math.max(reportOptions.values[occurrence.taxon_meaning_id][weekNum][sectionNum], parseInt(occurrence[reportOptions.countOccAttr]));
							  			break;
							  		default : // location and add
										if(reportOptions.parentSampleList[weekNum].indexOf(occurrence.parent_sample_id) < 0)
											reportOptions.parentSampleList[weekNum].push(occurrence.parent_sample_id);
							  			reportOptions.values[occurrence.taxon_meaning_id][weekNum][sectionNum] += parseInt(occurrence[reportOptions.countOccAttr]);
							  			break;
							  	}
							});
							
							// Next sort out the species list drop downs.
							$('#'+reportOptions.species1SelectID+' option').remove();
							$('#'+reportOptions.species2SelectID+' option').remove();
							if(reportOptions.species.length) {
								$('#'+reportOptions.species1SelectID).append('<option value="">&lt;'+reportOptions.pleaseSelectMsg+'&gt;</option><option value="0">'+reportOptions.allSpeciesMsg+'</option>');
								$('#'+reportOptions.species2SelectID).append('<option value="">&lt;'+reportOptions.pleaseSelectMsg+'&gt;</option><option value="0">'+reportOptions.allSpeciesMsg+'</option>');								
								reportOptions.species.sort(function (a, b) { return a.taxon.localeCompare(b.taxon); } );
								$('#'+reportOptions.species1SelectID+',#'+reportOptions.species2SelectID+',#'+reportOptions.weekNumSelectID).removeAttr('disabled');
								$.each(reportOptions.species, function(idx, species){
								  	if(reportOptions.dataCombining == 'location')
								  		for(var i=reportOptions.allWeeksMin; i<=reportOptions.allWeeksMax; i++) {
											for(var j=0; j<reportOptions.opts.axes.xaxis.ticks.length; j++) {
												if(reportOptions.parentSampleList[i].length > 1) {
													reportOptions.values[species.taxon_meaning_id][i][j] = reportOptions.values[species.taxon_meaning_id][i][j] / reportOptions.parentSampleList[i].length;
													switch(reportOptions.dataRound){
														case 'nearest':
															reportOptions.values[species.taxon_meaning_id][i][j] = parseInt(Math.round(reportOptions.values[species.taxon_meaning_id][i][j]));
															break;
														case 'up':
															reportOptions.values[species.taxon_meaning_id][i][j] = parseInt(Math.ceil(reportOptions.values[species.taxon_meaning_id][i][j]));
															break;
														case 'down':
															reportOptions.values[species.taxon_meaning_id][i][j] = parseInt(Math.floor(reportOptions.values[species.taxon_meaning_id][i][j]));
															break;
														case 'none':
														default : break;
													}
												}
											}
								  		}
							  		for(var i=reportOptions.allWeeksMin; i<=reportOptions.allWeeksMax; i++) {
										for(var j=0; j<reportOptions.opts.axes.xaxis.ticks.length; j++) {
											reportOptions.values[species.taxon_meaning_id][reportOptions.allWeeksMax+1][j] += reportOptions.values[species.taxon_meaning_id][i][j];
											if(i >= reportOptions.seasonWeeksMin && i <= reportOptions.seasonWeeksMax) {
												reportOptions.values[species.taxon_meaning_id][reportOptions.allWeeksMax+2][j] += reportOptions.values[species.taxon_meaning_id][i][j];
											}
										}
							  		}
									$('#'+reportOptions.species1SelectID).append('<option value="'+species.taxon_meaning_id+'">'+species.taxon+(species.taxon != species.preferred_taxon ? ' (' + species.preferred_taxon + ')' : '')+'</option>');
									$('#'+reportOptions.species2SelectID).append('<option value="'+species.taxon_meaning_id+'">'+species.taxon+(species.taxon != species.preferred_taxon ? ' (' + species.preferred_taxon + ')' : '')+'</option>');
								});
								// have to do all species calcs after the data rounding. special taxon_meaning_id of 0
								// reportOptions.species.unshift({'taxon': reportOptions.allSpeciesMsg, 'preferred_taxon': reportOptions.allSpeciesMsg, 'taxon_meaning_id':0});
								reportOptions.values[0] = [];
						  		for(var i=reportOptions.allWeeksMin; i<=reportOptions.allWeeksMax+2; i++) {
						  			reportOptions.values[0][i] = [];
									for(var j=0; j<reportOptions.opts.axes.xaxis.ticks.length; j++) {
							  			reportOptions.values[0][i][j] = 0;
										$.each(reportOptions.species, function(idx, species){
											reportOptions.values[0][i][j] += reportOptions.values[species.taxon_meaning_id][i][j];
										});
							  		}
								}
							} else {
								$('#'+reportOptions.species1SelectID).append('<option value="">&lt;'+reportOptions.noDataMsg+'&gt;</option>');
								$('#'+reportOptions.species2SelectID).append('<option value="">&lt;'+reportOptions.noDataMsg+'&gt;</option>');
							}
							$('#currentlyLoaded').empty().append(reportOptions.dataLoadedMsg + ' : ' + reportOptions.loadedYear + ' : ' + reportOptions.loadedLocation);
							$('#loadButton').removeClass('waiting-button');
					});
		    });
		});
		    
		$('#'+reportOptions.species1SelectID+',#'+reportOptions.species2SelectID+',#'+reportOptions.weekNumSelectID).change(function(){
			var week = $('#'+reportOptions.weekNumSelectID).val();
			var seriesData = [];
			var max = 0;

			reportOptions.opts.series = [];
			$('#'+reportOptions.id).empty(); // can we destroy?
			
			reportOptions.opts.title.text = reportOptions.loadedYear + ' : ' + reportOptions.loadedLocation + ' : ';
			if(week == 'all') {
				week = reportOptions.allWeeksMax+1;
				reportOptions.opts.title.text += reportOptions.allWeeksDescription + ' (' + reportOptions.allWeeksMin + ' &gt ' + reportOptions.allWeeksMax + ')'; 
			} else if(week == 'season') {
				week = reportOptions.allWeeksMax+2;
				reportOptions.opts.title.text += reportOptions.seasonWeeksDescription + ' (' + reportOptions.seasonWeeksMin + ' &gt ' + reportOptions.seasonWeeksMax + ')'; 
			} else if(week == '') {
				return;
			} else {
				reportOptions.opts.title.text += reportOptions.weekLabel + ' ' + week; 	
			}
			if($('#'+reportOptions.species1SelectID).val() != '') {
				reportOptions.opts.series.push({"show":true,"label":$('#'+reportOptions.species1SelectID+' option:selected').text(),"showlabel":true});
 				seriesData.push(reportOptions.values[$('#'+reportOptions.species1SelectID).val()][week]);
			}
			if($('#'+reportOptions.species2SelectID).val() != '') {
				reportOptions.opts.series.push({"show":true,"label":$('#'+reportOptions.species2SelectID+' option:selected').text(),"showlabel":true});
				seriesData.push(reportOptions.values[$('#'+reportOptions.species2SelectID).val()][week]);
			}
			if(seriesData.length == 0) return;
			var plot = $.jqplot(reportOptions.id, seriesData, reportOptions.opts);
			$('#'+reportOptions.id).data('jqplot',plot);
        });
		
		$('#'+ reportOptions.locationTypeSelectID).change(function(){
			$('.location-select').hide();
			$('#'+ reportOptions.locationSelectIDPrefix + '-' + $(this).val()).show();
		});
		$('#'+ reportOptions.locationTypeSelectID).change();
		
		$(window).resize(function(){
    		// Calculate scaling factor to alter dimensions according to width.
          var scaling = 1;
          var shadow = true;
          var placement = 'outsideGrid';
          var location = 'ne';
          var width = $(window).width()
          if (width < 480) {
            scaling = 0;
            shadow = false;
//            placement = 'outside';
            location = 's';
          }
          else if (width < 1024) {
            scaling = (width - 480) / (1024 - 480);
//            placement = 'outside';
            location = 's';
          }
    
          $('.jqplot-target').each(function() {
            var jqp = $(this).data('jqplot');
            if(typeof jqp == 'undefined') return;
//            jqp.options.legend.placement = placement;
//          jqp.options.legend.location = location;
            for (var plugin in jqp.plugins) {
              if (plugin == 'barRenderer') {
                $.each(jqp.series, function(i, series) {
                  series.barWidth = undefined;
                  series.shadow = shadow;
                  series.shadowWidth = scaling * 3;
                  series.barMargin = 8 * scaling + 2;
                });
              }
            }
            jqp.replot({resetAxes: true});
          });
        });
	}
	
	_get_week_number = function(o) { // occurrence object
		var d = new Date (o.date);
			var yn = d.getFullYear();
			var mn = d.getMonth();
			var dn = d.getDate();
			var yz = reportOptions.zeroWeekStartDate.getFullYear();
			var mz = reportOptions.zeroWeekStartDate.getMonth();
			var dz = reportOptions.zeroWeekStartDate.getDate();
			var zeroDay = new Date(yz,mz,dz,12,0,0); // noon on Week zero start date
			var d2 = new Date(yn,mn,dn,12,0,0); // noon on input date
			var ddiff = Math.round((d2-zeroDay)/8.64e7); // gets around Daylight Saving.
			return Math.floor(ddiff/7);
	}
	
}) (jQuery);