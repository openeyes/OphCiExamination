String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function collectValues( side ){
    var pcrdata = {};
    
    pcrdata.age = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='age']").val();
    pcrdata.gender = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='gender']").val();
    pcrdata.glaucoma = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='glaucoma']").val();
    pcrdata.diabetic = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='diabetic']").val();
    pcrdata.fundalview = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='no_fundal_view']").val();
    pcrdata.brunescentwhitecataract = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='brunescent_white_cataract']").val();
    pcrdata.pxf = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='pxf_phako']").val();
    pcrdata.pupilsize = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='pupil_size']").val();
    pcrdata.axiallength = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='axial_length']").val();
    pcrdata.alpareceptorblocker = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='arb']").val();
    pcrdata.abletolieflat = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='abletolieflat']").val();
    pcrdata.doctorgrade = $('#ophCiExaminationPCRRisk'+side+'Eye').find("select[name='doctor_grade_id']").val();

    return pcrdata;
}

function calculateORValue( inputValues ){
    var OR ={};
    var ORMultiplicated = 1;  // base value

    // multipliers for the attributes and selected values
    OR.age = {'1':1, '2':1.14, '3':1.42, '4':1.58, '5':2.37};
    OR.gender = {'Male':1.28, 'Female':1};
    OR.glaucoma = {'Y':1.30, 'N':1};
    OR.diabetic = {'Y':1.63, 'N':1};
    OR.fundalview = {'Y':2.46, 'N':1};
    OR.brunescentwhitecataract = {'Y':2.99, 'N':1};
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
        if( inputValues[key] == "NK" || inputValues[key] == 0){
            return false;
        }
        ORMultiplicated *= OR[key][inputValues[key]];
    }
    return ORMultiplicated;
}

function pcrCalculate( side ){
    side = side.capitalizeFirstLetter();  // we use this to keep camelCase div names

    var pcrDataValues = collectValues( side );
    var ORValue = calculateORValue( pcrDataValues );
    var pcrRisk;
    var excessRisk;
    var pcrColor;

    if( ORValue ) {
        var pcrRisk = ORValue * (0.00736 / (1 - 0.00736)) / (1 + (ORValue * 0.00736 / (1 - 0.00736))) * 100;
        var averageRiskConst = 1.92;
        excessRisk = pcrRisk / averageRiskConst;
        excessRisk = excessRisk.toFixed(2);
        pcrRisk = pcrRisk.toFixed(2);

        if (pcrRisk <= 1) {
            pcrColor = 'green';
        } else if (pcrRisk > 1 && pcrRisk <= 5) {
            pcrColor = 'orange';
        } else {
            pcrColor = 'red';
        }
    }else{
        pcrRisk = "N/A";
        excessRisk = "N/A";
        pcrColor = 'white';
    }
    $('#ophCiExaminationPCRRisk'+side+'Eye').find('#pcr-risk-div').css('background', pcrColor);
    $('#ophCiExaminationPCRRisk'+side+'Eye').find('.pcr-span').html(pcrRisk);
    $('#ophCiExaminationPCRRisk'+side+'Eye').find('.pcr-erisk').html(excessRisk);

}


