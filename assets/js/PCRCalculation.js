

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

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function collectValues( side ){
    var pcrdata = {};

    pcrdata.age = $('#ophCiExaminationPCRDiv'+side).find("select[name='age']").val();
    pcrdata.gender = $('#ophCiExaminationPCRDiv'+side).find("select[name='gender']").val();
    pcrdata.glaucoma = $('#ophCiExaminationPCRDiv'+side).find("select[name='glaucoma']").val();
    pcrdata.diabetic = $('#ophCiExaminationPCRDiv'+side).find("select[name='diabetic']").val();
    pcrdata.fundalview = $('#ophCiExaminationPCRDiv'+side).find("select[name='fundalView']").val();
    pcrdata.psuedoexfoliation = $('#ophCiExaminationPCRDiv'+side).find("select[name='Psuedoexfoliation']").val();
    pcrdata.pxf = $('#ophCiExaminationPCRDiv'+side).find("select[name='pxf']").val();
    pcrdata.pupilsize = $('#ophCiExaminationPCRDiv'+side).find("select[name='pupilSize']").val();
    pcrdata.axiallength = $('#ophCiExaminationPCRDiv'+side).find("select[name='axialLength']").val();
    pcrdata.alpareceptorblocker = $('#ophCiExaminationPCRDiv'+side).find("select[name='alpaReceptorBlocker']").val();
    pcrdata.abletolieflat = $('#ophCiExaminationPCRDiv'+side).find("select[name='abletolieflat']").val();
    pcrdata.doctorgrade = $('#ophCiExaminationPCRDiv'+side).find("select[name='DoctorGrade']").val();

    return pcrdata;
}

function calculateORValue( inputValues ){
    var OR ={};
    var ORMultiplicated = 1;  // base value

    OR.age = {'1':1, '2':1.14, '3':1.42, '4':1.58, '5':2.37};
    OR.gender = {'Male':1.28, 'Female':1};
    OR.glaucoma = {'Y':1.30, 'N':1};
    OR.diabetic = {'Y':1.63, 'N':1};
    OR.fundalview = {'Y':2.46, 'N':1};
    OR.psuedoexfoliation = {'Y':2.99, 'N':1};
    OR.pxf = {'Y':2.92, 'N':1};
    OR.pupilsize = {'Small': 1.45, 'Medium':1.14, 'Large':1};
    OR.axiallength = {'1':1, '2':1.47};
    OR.alpareceptorblocker = {'Y':1.51, 'N':1};
    OR.abletolieflat = {'Y':1, 'N':1.27};
    /*
    1 - Consultant
    2 - Associate specialist
    3 - Trust doctor  // !!!??? Staff grade??
    4 - Fellow
    5 - Specialist Registrar
    6 - Senior House Officer
    7 - House officer  -- ???? no value specified!! using: 1
    */
    OR.doctorgrade = {'1':1, '2':0.87, '3':0.36, '4':1.65, '5':1.60, '6': 3.73, '7':1};

    for (var key in inputValues) {
        ORMultiplicated *= OR[key][inputValues[key]];
    }
    return ORMultiplicated;
}

function pcrCalculate( side ){
    //alert('PCR pcrCalculate called from main');

    side = side.capitalizeFirstLetter();  // we use this to keep camelCase div names

    var pcrDataValues = collectValues( side );

    var ORValue = calculateORValue( pcrDataValues );

    var individualRisk = ORValue*(0.00736/(1-0.00736))/(1+(ORValue*0.00736/(1-0.00736)))*100;

    var averageRiskConst = 1.92;

    var pcrRisk = individualRisk / averageRiskConst;

    var pcrColor;

    if( pcrRisk <= 1){
        pcrColor = 'green';
    }else if( pcrRisk > 1 && pcrRisk <= 5 ){
        pcrColor = 'orange';
    }else{
        pcrColor = 'red';
    }

    $('#pcr_risk_div').css('background', pcrColor);
    $('#pcr_risk_value').html(pcrRisk.toFixed(2));

    console.log(ORValue);
    console.log(individualRisk);
    console.log(pcrRisk);

}


