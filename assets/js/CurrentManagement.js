$(document).ready(function() {

    function setCurrentManagementIOP(side){
        cmIopElement = $('#OEModule_OphCiExamination_models_Element_OphCiExamination_CurrentManagementPlan_' + side + '_iop');
        targetEl = $('#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_' + side + '_target_iop');
        currentIopAvg = getCurrentIopValue(side);

        if( (previous_iop === null && currentIopAvg == false) || targetEl.length == 0){
            cmIopElement.html('N/A');
            return;
        }
        if( targetEl.length!= 0 && targetEl.val() != '' &&
            ( typeof previous_iop[ side +'IOP'] !== 'undefined'  || currentIopAvg)
            ){
            thisSideTargetVal = parseInt(targetEl.val());
            if(currentIopAvg){
                resultIOP = currentIopAvg - thisSideTargetVal;
                if(cmIopElement.hasClass('past_iop')){
                    cmIopElement.removeClass('past_iop');
                }
            }
            else{
                resultIOP = previous_iop[ side +'IOP'] - thisSideTargetVal;
                if(!cmIopElement.hasClass('past_iop')){
                    cmIopElement.addClass('past_iop');
                }
            }

            cmIopElement.html(resultIOP +' mmHh');
            console.log('Set IOP to : ' + resultIOP + '. This side Target val : ' +
                thisSideTargetVal +	'.  Previous val : ' + previous_iop [ side +'IOP']);
        }
        else{
            console.log('This side is : ' + side + ' and its value has not been set.');
            return;
        }
    }

    function getCurrentIopValue(side){
        var result = false;
        c = 0;
        sum = 0;
        domId = function(){
            return 'OEModule_OphCiExamination_models_OphCiExamination_IntraocularPressure_Value_' + side
                + '_values_' + c + '_reading_id option:selected';
        }
        while($('#' + domId()).length!= 0){
            reading = parseInt($('#' + domId()).text() );
            sum = sum + reading;
            c++;
        }
        if(sum != 0){
            result = Math.round(sum/c);
        }
        console.log('Side: ' + side + '. Total reading : ' + sum + ' of ' + c + ' readings. Avg : ' + result );
        return result;
    }

    $('.event.edit').on('change click', [
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_left_target_iop',
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_right_target_iop',
        '.OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure'
    ].join(','), function(){
        setCurrentManagementIOP('left');
        setCurrentManagementIOP('right');
    });

    setCurrentManagementIOP('left');
    setCurrentManagementIOP('right');
});