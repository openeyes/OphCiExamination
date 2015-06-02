

$(document).ready( function (){
    $('#ophCiExaminationPCRDivRight').hide();
    $('#ophCiExaminationPCRDivLeft').hide();

    $('#PCRRiskToggleRight').on('click', function(){
        console.log('toggle right');
        $('#ophCiExaminationPCRDivRight').toggle();
    });
    $('#PCRRiskToggleLeft').on('click', function(){
        console.log('toggle left');
        $('#ophCiExaminationPCRDivLeft').toggle();
    });
});

function pcrCalculate( side ){
    alert('PCR pcrCalculate called from main');

    var pcrDataValues = collectValues( side );

    $('#pcr_risk_div').attr('style', 'background-color: #43a844 !important');
}


function collectValues( side ){
    pcrdata.age = $('#ophCiExaminationPCRDiv'+side).find("select[name='age']").val();

    return pcrdata;
}