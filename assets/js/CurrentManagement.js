function setCurrentManagementIOP(side){
    cmIopElement = $('#OEModule_OphCiExamination_models_Element_OphCiExamination_CurrentManagementPlan_' + side + '_iop');
    targetIop = getTargetIop(side);
    currentIopAvg = getCurrentIopValue(side);

    if( (previous_iop === null && currentIopAvg == false) || targetIop == null){
        cmIopElement.html('N/A');
        return;
    }
    if( targetIop!= null &&
        ( typeof previous_iop[ side +'IOP'] !== 'undefined'  || currentIopAvg)
        ){
        if(currentIopAvg){
            resultIOP = currentIopAvg - targetIop;
            if(cmIopElement.hasClass('past_iop')){
                cmIopElement.removeClass('past_iop');
            }
        }
        else{
            resultIOP = previous_iop[ side +'IOP'] - targetIop;
            if(!cmIopElement.hasClass('past_iop')){
                cmIopElement.addClass('past_iop');
            }
        }

        cmIopElement.html(resultIOP +' mmHh');
        console.log('Set IOP to : ' + resultIOP + '. This side Target val : ' +
            targetIop +	'.  Previous val : ' + previous_iop [ side +'IOP']);
    }
    else{
        console.log('This side is : ' + side + ' and its value has not been set.');
        return;
    }
}

function getTargetIop(side){
    targetEl= $('#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_' + side + '_target_iop');
    if(targetEl.length!= 0){
        if(targetEl.text()>0){
            return parseInt(targetEl.text());
        }
        else if(targetEl.val() != ''){
            return parseInt(targetEl.val());
        }

    }
    return null;
}

function getCurrentIopValue(side){
    if(side =='right' && typeof view_iop_right != 'undefined' ){
        return parseInt(view_iop_right);
    }
    else if(side =='left' && typeof view_iop_left != 'undefined'){
        return parseInt(view_iop_left);
    }
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

$(document).ready(function() {
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