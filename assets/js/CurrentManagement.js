function setCurrentManagementIOP(side){
    console.log('Side ' + side + ' its type : ' + typeof side);
    console.debug(side);
    if(typeof side == 'object'){
        side = side.data.side;
    }

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
    sum = 0;
    readings = $('#OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure_readings_' + side + ' td:nth-child(2) select option:selected') ;
    for(var i = 0; i < readings.length; i++){
        reading = parseInt($(readings[i]).text() );
        sum = sum + reading;
    }
    if(sum != 0){
        result = Math.round(sum/readings.length);
    }
    console.log('Side: ' + side + '. Total reading : ' + sum + ' of ' + readings.length + ' readings. Avg : ' + result );
    return result;
}

$(document).ready(function() {
    $('.event.edit').on('change click', [
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_left_target_iop',
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_right_target_iop',
        '.OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure',
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure_readings_right button.delete',
        '#OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure_readings_left button.delete'
    ].join(','), function(){
        setCurrentManagementIOP('left');
        setCurrentManagementIOP('right');
    });

    setCurrentManagementIOP('left');
    setCurrentManagementIOP('right');

    $("#OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure_readings_right").click({side: "right"}, setCurrentManagementIOP);
    $("#OEModule_OphCiExamination_models_Element_OphCiExamination_IntraocularPressure_readings_left").click({side: "left"}, setCurrentManagementIOP);
});